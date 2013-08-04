<?php

namespace Marmotz\Dumper;


/**
 * Output
 *
 * @package Dumper
 * @author  Renaud Littolff <rlittolff@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link    https://github.com/marmotz/Dumper
 */
class Output
{
    protected $currentPosition;
    protected $dumper;
    protected $indent;
    protected $level;
    protected $autoIndent;
    protected $parentOutput;
    protected $prefix;

    static protected $templates = array();
    protected $currentTemplate;
    protected $currentTemplateIndent;
    protected $addLnAfterLine;

    /**
     * Constructor
     *
     * @param Dump   $dumper
     * @param Output $parentOutput
     */
    public function __construct(Dump $dumper, Output $parentOutput = null)
    {
        $this
            ->setDumper($dumper)
            ->setIndent(2)
            ->setLevel(0)
            ->setAutoIndent(true)
            ->setPrefix('')
            ->setParentOutput($parentOutput)
        ;
    }

    /**
     * Add given text to output
     *
     * @return Output
     */
    public function add(/*$format, $args1, ... */)
    {
        $args   = func_get_args();
        $format = array_shift($args);

        $toAdd = vsprintf($format, $args);

        echo $this->getSpace() . $toAdd;

        if (substr($toAdd, -1) === PHP_EOL) {
            $this
                ->setAutoIndent(true)
                ->setCurrentPosition(null)
            ;
        } else {
            $this
                ->setAutoIndent(false)
                ->setCurrentPosition(
                    ($this->getCurrentPosition() ?: $this->getIndent() * $this->getLevel())
                    + strlen($toAdd)
                )
            ;
        }

        return $this;
    }

    /**
     * Add given text to output and add a PHP_EOL
     *
     * @return Output
     */
    public function addLn(/*$format, $args1, ... */)
    {
        $args = func_get_args();

        if (!isset($args[0])) {
            $args[0] = '';
        }

        $args[0] .= PHP_EOL;

        return call_user_func_array(
            array($this, 'add'),
            $args
        );
    }

    /**
     * Compile indentation
     *
     * @param string $indent
     */
    public function compileIndent($indent)
    {
        $nbIndent = substr_count($indent, '    ');

        if ($nbIndent > $this->currentTemplateIndent) {
            for ($i = 0; $i < ($nbIndent - $this->currentTemplateIndent); $i++) {
                $this->addToCompiledTemplate('$this->inc();');
            }
        } elseif ($nbIndent < $this->currentTemplateIndent) {
            for ($i = 0; $i < ($this->currentTemplateIndent - $nbIndent); $i++) {
                $this->addToCompiledTemplate('$this->dec();');
            }
        }

        $this->currentTemplateIndent = $nbIndent;
    }

    /**
     * Compile given line
     *
     * @param string  $line
     */
    public function compileLine($line)
    {
        $trimLine = trim($line);

        if ($trimLine === '{{}}') {
            return;
        } else {
            if (preg_match('/^([ ]*)([^ ].*)$/U', $line, $matches)) {
                $this->compileIndent($matches[1]);

                $trimLine = $matches[2];
            }

            if (preg_match('/^{%(.*)%}$/U', $trimLine, $matches)) {
                $code = trim($matches[1]);

                if ($code === 'end') {
                    $code = '}';
                } else {
                    $code .= ' {';
                }

                $this->addToCompiledTemplate($code);
            } else {
                $this->processLine($trimLine);

                if ($this->addLnAfterLine) {
                    $this->addToCompiledTemplate('$this->addLn();');
                }
            }
        }
    }

    /**
     * Compile load template
     *
     * @return Output
     */
    public function compileCurrentTemplate()
    {
        if (self::$templates[$this->currentTemplate]['compiled'] === null) {
            self::$templates[$this->currentTemplate]['compiled'] = '';

            $this->currentTemplateIndent = 0;

            foreach (self::$templates[$this->currentTemplate]['raw'] as $line) {
                $this->compileLine($line);
            }
            $this->compileIndent('');

            self::$templates[$this->currentTemplate]['compiled'] = str_replace(
                'FORMAT_SHORT',
                '\Marmotz\Dumper\Dump::FORMAT_SHORT',
                self::$templates[$this->currentTemplate]['compiled']
            );
        }

        return $this;
    }

    /**
     * Decrements indentation
     *
     * @return Output
     */
    public function dec()
    {
        return $this->setLevel($this->getLevel() - 1);
    }

    /**
     * Dump given variable
     *
     * @param mixed   $variable
     * @param integer $format
     *
     * @return Output
     */
    public function dump($variable, $format = null)
    {
        $this->getDumper()->dump($variable, $this, $format);

        $this->setCurrentPosition(null);

        return $this;
    }

    /**
     * execute current template
     *
     * @param array $data
     *
     * @return Output
     */
    public function executeCurrentTemplate(array $data)
    {
        extract($data);

        eval(self::$templates[$this->currentTemplate]['compiled']);

        return $this;
    }

    /**
     * Returns whether auto indent is activated or not
     *
     * @return boolean
     */
    public function getAutoIndent()
    {
        return $this->autoIndent;
    }

    /**
     * Returns current position
     *
     * @return integer
     */
    public function getCurrentPosition()
    {
        return $this->currentPosition;
    }

    /**
     * Returns current dumper
     *
     * @return Dumper
     */
    public function getDumper()
    {
        return $this->dumper;
    }

    /**
     * Returns indent size
     *
     * @return size
     */
    public function getIndent()
    {
        return $this->indent;
    }

    /**
     * Returns current level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Returns parent output
     *
     * @return Output
     */
    public function getParentOutput()
    {
        return $this->parentOutput;
    }

    /**
     * Return prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Return current indent space
     *
     * @return string
     */
    public function getSpace()
    {
        $space = '';

        if ($this->getAutoIndent() === true) {
            $spaceSize = $this->getCurrentPosition() ?: $this->getIndent() * $this->getLevel();

            if ($spaceSize > 0) {
                $space =
                    $this->getPrefix() .
                    str_repeat(' ', $spaceSize - strlen($this->getPrefix()))
                ;
            }
        }

        if ($this->getParentOutput()) {
            $space = $this->getParentOutput()->getSpace() . $space;
        }

        return $space;
    }

    /**
     * Increments indentation
     *
     * @return Output
     */
    public function inc()
    {
        return $this->setLevel($this->getLevel() + 1);
    }

    /**
     * Load a template
     *
     * @param string $template
     *
     * @return Output
     */
    public function loadTemplate($template)
    {
        $this->currentTemplate = $template;

        if (!isset(self::$templates[$this->currentTemplate])) {
            self::$templates[$this->currentTemplate] = array(
                'raw'      => file(__DIR__ . '/../../../resources/templates/' . $template),
                'compiled' => null,
            );
        }

        return $this;
    }

    /**
     * Add code to current compiled template
     *
     * @param string $code
     */
    public function addToCompiledTemplate($code)
    {
        self::$templates[$this->currentTemplate]['compiled'] .= $code . PHP_EOL;
    }

    /**
     * Process given line (without indentation)
     *
     * @param string $line
     */
    public function processLine($line)
    {
        $this->addLnAfterLine = true;

        if (preg_match('/^(.*){{{(.*)}}}(.*)$/U', $line, $matches)) {
            if ($matches[1] !== '') {
                $this->processLine($matches[1]);
            }

            $this->addToCompiledTemplate('$this->dump(' . $matches[2] . ');');

            if ($matches[3] !== '') {
                $this->processLine($matches[3]);
            }

            $this->addLnAfterLine = false;
        } elseif (preg_match('/^(.*){{(.*)}}(.*)$/U', $line, $matches)) {
            if ($matches[1] !== '') {
                $this->processLine($matches[1]);
            }

            $this->addToCompiledTemplate('$this->add(' . $matches[2] . ');');

            if ($matches[3] !== '') {
                $this->processLine($matches[3]);
            }
        } else {
            $this->addToCompiledTemplate('$this->add("' . addslashes($line) . '");');
        }

        if (preg_match('/^(.*){{}}$/U', $line)) {
            $this->addLnAfterLine = false;
        }
    }

    /**
     * Render a template
     *
     * @param string $template
     * @param array  $data
     */
    public function render($template, array $data = array())
    {
        $this
            ->loadTemplate($template)
            ->compileCurrentTemplate()
            ->executeCurrentTemplate($data)
        ;
    }

    /**
     * Set whether auto indent is activated or not
     *
     * @param boolean $autoIndent
     *
     * @return Output
     */
    public function setAutoIndent($autoIndent)
    {
        $this->autoIndent = (boolean) $autoIndent;

        if ($this->getParentOutput()) {
            $this->getParentOutput()->setAutoIndent($this->autoIndent);
        }

        return $this;
    }

    /**
     * Set current position
     *
     * @param integer $position
     *
     * @return Output
     */
    public function setCurrentPosition($position)
    {
        $this->currentPosition = $position;

        return $this;
    }

    /**
     * Set current dumper
     *
     * @param Dump $dumper
     *
     * @return Output
     */
    public function setDumper(Dump $dumper)
    {
        $this->dumper = $dumper;

        return $this;
    }

    /**
     * Set indent size
     *
     * @param integer $indent
     *
     * @return Output
     */
    public function setIndent($indent)
    {
        $this->indent = $indent;

        return $this;
    }

    /**
     * Set current level
     *
     * @param integer $level
     *
     * @return Output
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Set parent output
     *
     * @param Output $parentOutput
     *
     * @return Output
     */
    public function setParentOutput(Output $parentOutput = null)
    {
        $this->parentOutput = $parentOutput;

        return $this;
    }

    /**
     * Set prefix
     *
     * @param string $prefix
     *
     * @return Output
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }
}
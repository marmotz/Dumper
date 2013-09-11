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
    protected $prefixFontOptions;

    static protected $templates = array();
    protected $currentTemplate;
    protected $currentTemplateIndent;
    protected $currentTemplateAddLnAfterLine;

    protected $fontOptionsEnabled;

    protected $fontOptions = array(
        'reset'      => 0,

        'fgblack'    => 30,
        'fgred'      => 31,
        'fggreen'    => 32,
        'fgyellow'   => 33,
        'fgblue'     => 34,
        'fgmagenta'  => 35,
        'fgcyan'     => 36,
        'fgwhite'    => 37,

        'bgblack'    => 40,
        'bgred'      => 41,
        'bggreen'    => 42,
        'bgyellow'   => 43,
        'bgblue'     => 44,
        'bgmagenta'  => 45,
        'bgcyan'     => 46,
        'bgwhite'    => 47,

        'bold'       => 1,
        'underscore' => 4,
        'blink'      => 5,
        'reverse'    => 7,
        'conceal'    => 8,
    );

    /**
     * Constructor
     *
     * @param Dump   $dumper
     * @param Output $parentOutput
     */
    public function __construct(Dump $dumper, Output $parentOutput = null)
    {
        $this
            ->reset()
            ->setDumper($dumper)
            ->setIndent(2)
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
                    + strlen(preg_replace("#\033\[[^m]+m#", '', $toAdd))
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
     * Add code to current compiled template
     *
     * @param string $code
     *
     * @return Output
     */
    public function addToCurrentTemplateCompilation($code)
    {
        self::$templates[$this->getCurrentTemplate()]['compilation'] .= $code . PHP_EOL;

        return $this;
    }

    /**
     * Compile load template
     *
     * @return Output
     */
    public function compileCurrentTemplate()
    {
        if (!$this->isCurrentTemplateCompiled()) {
            $this
                ->setCurrentTemplateCompilation('')
                ->setCurrentTemplateIndent(0)
            ;

            foreach ($this->getCurrentTemplateSource() as $line) {
                $this->compileLine($line);
            }
            $this->compileIndent('');

            $this->setCurrentTemplateCompilation(
                str_replace(
                    'FORMAT_SHORT',
                    '\Marmotz\Dumper\Dump::FORMAT_SHORT',
                    $this->getCurrentTemplateCompilation()
                )
            );
        }

        return $this;
    }

    /**
     * Compile indentation
     *
     * @param string $indent
     */
    public function compileIndent($indent)
    {
        $nbIndent = substr_count($indent, '    ');

        if ($nbIndent > $this->getCurrentTemplateIndent()) {
            for ($i = 0; $i < ($nbIndent - $this->getCurrentTemplateIndent()); $i++) {
                $this->addToCurrentTemplateCompilation('$this->inc();');
            }
        } elseif ($nbIndent < $this->getCurrentTemplateIndent()) {
            for ($i = 0; $i < ($this->getCurrentTemplateIndent() - $nbIndent); $i++) {
                $this->addToCurrentTemplateCompilation('$this->dec();');
            }
        }

        $this->setCurrentTemplateIndent($nbIndent);
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
                } elseif ($code === 'else') {
                    $code = '} else {';
                } else {
                    $code .= ' {';
                }

                $this->addToCurrentTemplateCompilation($code);
            } else {
                $this->compileText($trimLine);

                if ($this->getCurrentTemplateAddLnAfterLine()) {
                    $this->addToCurrentTemplateCompilation('$this->addLn();');
                }
            }
        }
    }

    /**
     * Compile given text
     *
     * @param string $text
     */
    public function compileText($text)
    {
        $this->setCurrentTemplateAddLnAfterLine(true);

        if (preg_match('/^(.*){{{(.*)}}}(.*)$/U', $text, $matches)) {
            if ($matches[1] !== '') {
                $this->compileText($matches[1]);
            }

            $this->addToCurrentTemplateCompilation('$this->dump(' . trim($matches[2]) . ');');

            $this->setCurrentTemplateAddLnAfterLine(false);

            if ($matches[3] !== '') {
                $this->setCurrentTemplateAddLnAfterLine(true);

                $this->compileText($matches[3]);
            }
        } elseif (preg_match('/^(.*){{(.*)}}(.*)$/U', $text, $matches)) {
            if ($matches[1] !== '') {
                $this->compileText($matches[1]);
            }

            $matches[2] = trim($matches[2]);

            if ($matches[2] !== '') {
                $this->addToCurrentTemplateCompilation('$this->add(' . trim($matches[2]) . ');');
            }

            if ($matches[3] !== '') {
                $this->compileText($matches[3]);
            }
        } elseif (preg_match('/^(.*){\[(.*)\]}(.*)$/U', $text, $matches)) {
            if ($matches[1] !== '') {
                $this->compileText($matches[1]);
            }

            $matches[2] = trim($matches[2]);

            if ($matches[2] !== '') {
                $this->addToCurrentTemplateCompilation('$this->add($this->generateFontOptions("' . trim($matches[2]) . '"));');
            }

            if ($matches[3] !== '') {
                $this->compileText($matches[3]);
            }
        } else {
            $this->addToCurrentTemplateCompilation('$this->add("' . str_replace('%', '%%', addslashes($text)) . '");');
        }

        if (preg_match('/^(.*){{}}$/U', $text)) {
            $this->setCurrentTemplateAddLnAfterLine(false);
        }
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
     * Disable usage of font options
     *
     * @return Output
     */
    public function disableFontOptions()
    {
        return $this->setFontOptionsEnabled(false);
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
     * Enable usage of font options
     *
     * @return Output
     */
    public function enableFontOptions()
    {
        return $this->setFontOptionsEnabled(true);
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

        $code = $this->getCurrentTemplateCompilation();

        // var_dump($code);

        eval($code);

        return $this;
    }

    /**
     * Generate font options characters sequence
     *
     * @param string $fontOptions
     *
     * @return string
     */
    public function generateFontOptions($fontOptions)
    {
        if ($this->isFontOptionsEnabled()) {
            $fontOptions = explode(';', $fontOptions);
            $codes = array();

            foreach ($fontOptions as $fontOption) {
                if (isset($this->fontOptions[$fontOption])) {
                    $codes[] = $this->fontOptions[$fontOption];
                } else {
                    throw new \OutOfRangeException(
                        sprintf(
                            '"%s" is not a valid font option',
                            $fontOption
                        )
                    );
                }
            }

            return sprintf(
                "\033[%sm",
                implode(';', $codes)
            );
        } else {
            return '';
        }
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
     * Returns current template
     *
     * @return string
     */
    public function getCurrentTemplate()
    {
        return $this->currentTemplate;
    }

    /**
     * Set current template AddLnAfterLine flag to indicate if a new line must be added after this line
     *
     * @return boolean
     */
    public function getCurrentTemplateAddLnAfterLine()
    {
        return $this->currentTemplateAddLnAfterLine;
    }

    /**
     * Get code from current compiled template
     *
     * @return string
     */
    public function getCurrentTemplateCompilation()
    {
        return self::$templates[$this->getCurrentTemplate()]['compilation'];
    }

    /**
     * Returns current template indent
     *
     * @return integer
     */
    public function getCurrentTemplateIndent()
    {
        return $this->currentTemplateIndent;
    }

    /**
     * Returns current template source
     *
     * @return array
     */
    public function getCurrentTemplateSource()
    {
        return self::$templates[$this->getCurrentTemplate()]['source'];
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
     * Returns font options enabled
     *
     * @return boolean
     */
    public function getFontOptionsEnabled()
    {
        return $this->fontOptionsEnabled;
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
     * Returns prefix font options
     *
     * @return string
     */
    public function getPrefixFontOptions()
    {
        return $this->prefixFontOptions;
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
            if ($this->getCurrentPosition() !== null) {
                $spaceSize = $this->getCurrentPosition();
            } else {
                $spaceSize = $this->getIndent() * $this->getLevel();
            }

            if ($spaceSize > 0) {
                $space = sprintf(
                    '%s%s%s%s',
                    $this->generateFontOptions($this->getPrefixFontOptions()),
                    $this->getPrefix(),
                    $this->generateFontOptions('reset'),
                    str_repeat(' ', $spaceSize - strlen($this->getPrefix()))
                );
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
     * Initialize template array for given template
     *
     * @return Output
     */
    public function initCurrentTemplate()
    {
        self::$templates[$this->getCurrentTemplate()] = array(
            'source'      => null,
            'compilation' => null,
        );

        return $this;
    }

    /**
     * Check if current template is already compiled
     *
     * @return boolean
     */
    public function isCurrentTemplateCompiled()
    {
        return self::$templates[$this->getCurrentTemplate()]['compilation'] !== null;
    }

    /**
     * Check if font options are disabled
     *
     * @return boolean
     */
    public function isFontOptionsDisabled()
    {
        return $this->getFontOptionsEnabled() === false;
    }

    /**
     * Check if font options are enabled
     *
     * @return boolean
     */
    public function isFontOptionsEnabled()
    {
        return $this->getFontOptionsEnabled() === true;
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
        $this->setCurrentTemplate($template);

        if (!$this->templateExists($template)) {
            $this
                ->initCurrentTemplate()
                ->setCurrentTemplateSource(file(__DIR__ . '/../../../resources/templates/' . $template))
            ;
        }

        return $this;
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
     * Reset parameters
     *
     * @return Output
     */
    public function reset()
    {
        return $this
            ->setAutoIndent(true)
            ->setCurrentPosition(null)
            ->disableFontOptions()
            ->setLevel(0)
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
     * Set current template
     *
     * @param string $template
     *
     * @return Output
     */
    public function setCurrentTemplate($template)
    {
        $this->currentTemplate = $template;

        return $this;
    }

    /**
     * Set current template AddLnAfterLine flag to indicate if a new line must be added after this line
     *
     * @param boolean $add
     *
     * @return Output
     */
    public function setCurrentTemplateAddLnAfterLine($add)
    {
        $this->currentTemplateAddLnAfterLine = (boolean) $add;

        return $this;
    }

    /**
     * Set code to current compiled template
     *
     * @param string $code
     *
     * @return Output
     */
    public function setCurrentTemplateCompilation($code)
    {
        self::$templates[$this->getCurrentTemplate()]['compilation'] = $code;

        return $this;
    }

    /**
     * Set current template indent
     *
     * @param integer $indent
     *
     * @return Output
     */
    public function setCurrentTemplateIndent($indent)
    {
        $this->currentTemplateIndent = $indent;

        return $this;
    }

    /**
     * Set current template source
     *
     * @param array $source
     *
     * @return Output
     */
    public function setCurrentTemplateSource(array $source)
    {
        self::$templates[$this->getCurrentTemplate()]['source'] = $source;

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
     * Set if font options are enabled
     *
     * @param boolean $enabled
     *
     * @return Output
     */
    public function setFontOptionsEnabled($enabled)
    {
        $this->fontOptionsEnabled = (boolean) $enabled;

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

    /**
     * Set prefix font options
     *
     * @param string $prefixFontOptions
     *
     * @return Output
     */
    public function setPrefixFontOptions($prefixFontOptions)
    {
        $this->prefixFontOptions = $prefixFontOptions;

        return $this;
    }

    /**
     * Check if given template exist
     *
     * @param string $template
     *
     * @return boolean
     */
    public function templateExists($template)
    {
        return isset(self::$templates[$template]);
    }
}
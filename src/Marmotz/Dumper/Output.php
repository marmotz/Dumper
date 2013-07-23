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
                ->setCurrentPosition(strlen($toAdd) + $this->getIndent() * $this->getLevel())
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
        $args[0] .= PHP_EOL;

        return call_user_func_array(
            array($this, 'add'),
            $args
        );
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
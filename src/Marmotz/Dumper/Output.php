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
    protected $currentSpace;
    protected $dumper;
    protected $indent;
    protected $level;
    protected $newLine;
    protected $parentOutput;
    protected $prefix;

    public function __construct(Dump $dumper, Output $parentOutput = null)
    {
        $this
            ->setDumper($dumper)
            ->setIndent(2)
            ->setLevel(0)
            ->setNewLine(true)
            ->setPrefix('')
            ->setParentOutput($parentOutput)
        ;
    }

    public function add()
    {
        $args   = func_get_args();
        $format = array_shift($args);

        $toAdd = vsprintf($this->getSpace() . $format, $args);

        echo $toAdd;

        return $this;
    }

    public function addLn()
    {
        $args = func_get_args();
        $args[0] .= PHP_EOL;

        return call_user_func_array(
            array($this, 'add'),
            $args
        );
    }

    public function dec()
    {
        return $this->setLevel($this->getLevel() - 1);
    }

    public function dump($toDump)
    {
        $this->getDumper()->dump($toDump);

        return $this;
    }

    public function getCurrentPosition()
    {
        return $this->currentPosition;
    }

    public function getCurrentSpace()
    {
        return $this->currentSpace;
    }

    public function getDumper()
    {
        return $this->dumper;
    }

    public function getIndent()
    {
        return $this->indent;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getNewLine()
    {
        return $this->newLine;
    }

    public function getParentOutput()
    {
        return $this->parentOutput;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function getPrefixLength()
    {
        return strlen($this->getPrefix());
    }

    public function getSpace()
    {
        $spaceSize = $this->getIndent() * $this->getLevel();

        if ($spaceSize === 0) {
            return '';
        }
        else {
            return
                $this->getPrefix() .
                str_repeat(' ', $spaceSize - $this->getPrefixLength())
            ;
        }
    }

    public function inc()
    {
        return $this->setLevel($this->getLevel() + 1);
    }

    public function setCurrentPosition($position)
    {
        $this->currentPosition = $position;

        return $this;
    }

    public function setCurrentSpace($space)
    {
        $this->currentSpace = $space;

        return $this;
    }

    public function setDumper(Dump $dumper)
    {
        $this->dumper = $dumper;

        return $this;
    }

    public function setIndent($indent)
    {
        $this->indent = $indent;

        return $this;
    }

    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    public function setNewLine($newLine)
    {
        $this->newLine = $newLine;

        return $this;
    }

    public function setParentOutput($parentOutput)
    {
        $this->parentOutput = $parentOutput;

        return $this;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }
}
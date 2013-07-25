<?php

namespace Marmotz\Dumper;


/**
 * Abstract dump
 *
 * Main dumper
 *
 * @package Dumper
 * @author  Renaud Littolff <rlittolff@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link    https://github.com/marmotz/Dumper
 */
abstract class Dump
{
    const FORMAT_SHORT    = 1;
    const FORMAT_COMPLETE = 2;

    protected $level;
    protected $objectHashes = array();

    static protected $maxLevelOfRecursion = 10;

    /**
     * Do dump array variable
     *
     * @param Proxy\ArrayProxy $array
     * @param Output           $output
     */
    abstract public function doDumpArray(Proxy\ArrayProxy $array, Output $output);

    /**
     * Do dump object variable
     *
     * @param Proxy\ObjectProxy $object
     * @param Output            $output
     */
    abstract public function doDumpObject(Proxy\ObjectProxy $object, Output $output);

    /**
     * Init current output object
     *
     * @param Output $output
     *
     * @return Output
     */
    abstract public function initOutput(Output $output);

    /**
     * Create a dump instance by decorator
     *
     * @param string $decorator
     *
     * @return Dump
     */
    static public function factory($decorator = null)
    {
        if ($decorator === null) {
            $decorator = php_sapi_name();
        }

        if ($decorator === 'cli') {
            return new CliDump;
        } else {
            return new HtmlDump;
        }
    }

    /**
     * Returns max level of recursion
     *
     * @return integer|boolean
     */
    static public function getMaxLevelOfRecursion()
    {
        return static::$maxLevelOfRecursion;
    }

    /**
     * Checks if current level reach max level of recursion
     *
     * @param integer $currentLevel
     *
     * @return boolean
     */
    static public function isMaxLevelOfRecursion($currentLevel)
    {
        return static::getMaxLevelOfRecursion() !== false && static::getMaxLevelOfRecursion() < $currentLevel;
    }

    /**
     * Set max level of recursion
     *
     * @param integer|boolean $maxLevel
     */
    static public function setMaxLevelOfRecursion($maxLevel)
    {
        if (is_numeric($maxLevel)) {
            $maxLevel = (int) $maxLevel;
        }

        static::$maxLevelOfRecursion = is_integer($maxLevel) && $maxLevel > 0 ? $maxLevel : false;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Add an object hash to hash repository
     *
     * @param string $hash
     *
     * @return Dump
     */
    public function addObjectHash($hash)
    {
        $this->objectHashes[] = $hash;

        return $this;
    }

    /**
     * Method called just after the whole dump process
     *
     * @param Output $output
     */
    public function afterDump(Output $output)
    {
    }

    /**
     * Method called just before the whole dump process
     *
     * @param Output $output
     */
    public function beforeDump(Output $output)
    {
    }

    /**
     * Create an Output object
     *
     * @param Output $parentOutput
     *
     * @return Output
     */
    public function createOutput(Output $parentOutput = null)
    {
        $output = new Output($this, $parentOutput);
        $this->initOutput($output);

        return $output;
    }

    /**
     * Decrements current level
     *
     * @return Dump
     */
    public function decLevel()
    {
        return $this->setLevel($this->getLevel() - 1);
    }

    /**
     * Central dump method
     *
     * Dispatch to all dump methods
     *
     * @param mixed   &$variable
     * @param Output  $parentOutput
     * @param integer $format
     */
    public function dump(&$variable, Output $parentOutput = null, $format = null)
    {
        if ($format === null) {
            $format = self::FORMAT_COMPLETE;
        }

        $output = $this->createOutput($parentOutput);

        if ($this->getLevel() === 0) {
            $this->beforeDump($output);
        }

        $this->incLevel();

        $type = strtolower(gettype($variable));

        switch ($type) {
            case 'array':
            case 'object':
                if (static::isMaxLevelOfRecursion($this->getLevel())) {
                    $this->dumpMaxLevelOfRecursion($type, $output);
                    break;
                }
            case 'boolean':
            case 'double':
            case 'float':
            case 'integer':
            case 'resource':
            case 'string':
                $method = 'dump' . ucfirst($type);

                $this->$method($variable, $output, $format);
                break;

            case 'null':
                $this->dumpNull($output, $format);
                break;

            default:
                $this->dumpUnknown($type, $variable, $output);
                break;
        }

        $this->decLevel();

        if ($this->getLevel() === 0) {
            $this->afterDump($output);
            $this->reset();
        }
    }

    /**
     * Dump array variable
     *
     * @param array  &$array
     * @param Output $output
     */
    public function dumpArray(array &$array, Output $output)
    {
        $this->doDumpArray(
            new Proxy\ArrayProxy($array, $this),
            $output
        );
    }

    /**
     * Dump double
     *
     * @param float  $float
     * @param Output $output
     */
    public function dumpDouble($float, Output $output)
    {
        $this->dumpFloat($float, $output);
    }

    /**
     * Dump reach max level of recursion
     *
     * @param string $type
     * @param Output $output
     */
    public function dumpMaxLevelOfRecursion($type, Output $output)
    {
        $output->addLn($type . ' *MAX LEVEL OF RECURSION*');
    }

    /**
     * Dump object variable
     *
     * @param object $object
     * @param Output $output
     */
    public function dumpObject($object, Output $output)
    {
        $hash = spl_object_hash($object);

        if ($this->hasObjectHash($hash)) {
            $output->addLn('*OBJECT ALREADY DUMPED*');
        } else {
            $this->addObjectHash($hash);

            $this->doDumpObject(
                new Proxy\ObjectProxy($object, $this),
                $output
            );
        }
    }

    /**
     * Dump string variable
     *
     * @param string  $string
     * @param Output  $output
     * @param integer $format
     */
    public function dumpString($string, Output $output, $format)
    {
        if (function_exists('mb_strlen')) {
            $length = mb_strlen($string, 'UTF-8');
        } else {
            $length = strlen($string);
        }

        $this->doDumpString($string, $length, $output, $format);
    }

    /**
     * Dump unknown variable
     *
     * @param string $type
     * @param mixed  $variable
     * @param Output $output
     */
    public function dumpUnknown($type, $variable, Output $output)
    {
        ob_start();
        var_dump($variable);
        $dump = ob_get_clean();

        $this->doDumpString($type, $dump, $output);
    }

    /**
     * Empty the hashes
     *
     * @return Dump
     */
    public function emptyObjectHashes()
    {
        $this->objectHashes = array();

        return $this;
    }

    /**
     * Returns a dump
     *
     * @param mixed   &$variable
     * @param Output  $output
     * @param integer $format
     *
     * @return string
     */
    public function getDump(&$variable, Output $output = null, $format = self::FORMAT_COMPLETE)
    {
        ob_start();

        $this->dump($variable, $output, $format);

        return ob_get_clean();
    }

    /**
     * Return current level
     *
     * @return Dump
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Tests if given hash was already dumped
     *
     * @param string $hash
     *
     * @return boolean
     */
    public function hasObjectHash($hash)
    {
        return in_array($hash, $this->objectHashes);
    }

    /**
     * Increment current level
     *
     * @return Dump
     */
    public function incLevel()
    {
        return $this->setLevel($this->getLevel() + 1);
    }

    /**
     * Reset current dumper
     *
     * @return self
     */
    public function reset()
    {
        return $this
            ->setLevel(0)
            ->emptyObjectHashes()
        ;
    }

    /**
     * Set current level
     *
     * @param integer $level
     *
     * @return Dump
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }
}
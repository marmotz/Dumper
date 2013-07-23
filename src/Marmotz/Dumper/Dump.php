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
    const FORMAT_KEY   = 'key';
    const FORMAT_VALUE = 'value';

    protected $level;
    protected $objectHashes = array();
    protected $dumpedArrayMarker;
    protected $dumpedArrays = array();

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
     * Constructor
     */
    public function __construct()
    {
        $this->reset();

        // init dumpedArrayMarker
        $str = '';

        for ($i = 0; $i < 128; $i++) {
            $str .= chr(rand(32, 126));
        }

        $this->setDumpedArrayMarker($str);
    }

    /**
     * Add a dumped array
     *
     * @param array $array
     *
     * @return Dump
     */
    public function addDumpedArray(array &$array)
    {
        $array[$this->getDumpedArrayMarker()] = true;

        $this->dumpedArrays[] =& $array;

        return $this;
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
     * @param mixed  $variable
     * @param Output $parentOutput
     * @param string $format
     */
    public function dump(&$variable, Output $parentOutput = null, $format = self::FORMAT_VALUE)
    {
        $output = $this->createOutput($parentOutput);

        $this->incLevel();

        $type = strtolower(gettype($variable));

        switch ($type) {
            case 'array':
            case 'boolean':
            case 'double':
            case 'float':
            case 'integer':
            case 'object':
            case 'resource':
            case 'string':
                $method = 'dump' . ucfirst($type);

                $this->$method($variable, $output, $format);
                break;

            case 'null':
                $this->dumpNull($output);
                break;

            default:
                $this->dumpUnknown($type, $variable, $output);
                break;
        }

        $this->decLevel();

        if ($this->getLevel() === 0) {
            $this->reset();
        }
    }

    /**
     * Dump array variable
     *
     * @param array  $array
     * @param Output $output
     */
    public function dumpArray(array &$array, Output $output)
    {
        if ($this->isDumpedArray($array)) {
            $output->addLn('*ARRAY ALREADY DUMPED*');
        } else {
            $this->addDumpedArray($array);

            $this->doDumpArray(
                new Proxy\ArrayProxy($array, $this),
                $output
            );
        }
    }

    /**
     * Dump boolean
     *
     * @param boolean $boolean
     * @param Output  $output
     */
    public function dumpBoolean($boolean, Output $output)
    {
        $output
            ->addLn(
                'boolean(%s)',
                $boolean ? 'true' : 'false'
            )
        ;
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
     * Dump float
     *
     * @param float  $float
     * @param Output $output
     */
    public function dumpFloat($float, Output $output)
    {
        $output
            ->addLn(
                'float(%s)',
                $float
            )
        ;
    }

    /**
     * Dump integer variable
     *
     * @param integer $integer
     * @param Output  $output
     * @param string  $format
     */
    public function dumpInteger($integer, Output $output, $format)
    {
        if ($format === self::FORMAT_VALUE) {
            $output
                ->addLn(
                    'integer(%d)',
                    $integer
                )
            ;
        } else {
            $output
                ->add((string) $integer)
            ;
        }
    }

    /**
     * Dump null
     *
     * @param Output $output
     */
    public function dumpNull(Output $output)
    {
        $output
            ->addLn('NULL')
        ;
    }

    /**
     * Dump object variable
     *
     * @param object $object
     * @param Output $output
     */
    public function dumpObject(&$object, Output $output)
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
     * Dump resource
     *
     * @param resource $resource
     * @param Output   $output
     */
    public function dumpResource($resource, Output $output)
    {
        $output
            ->addLn(
                'resource %s "%s"',
                get_resource_type($resource),
                (string) $resource
            )
        ;
    }

    /**
     * Dump string variable
     *
     * @param string $string
     * @param Output $output
     * @param string $format
     */
    public function dumpString($string, Output $output, $format)
    {
        if ($format === self::FORMAT_VALUE) {
            if (function_exists('mb_strlen')) {
                $len = mb_strlen($string, 'UTF-8');
            } else {
                $len = strlen($string);
            }

            $output
                ->addLn(
                    'string(%d) "%s"',
                    $len,
                    $string
                )
            ;
        } else {
            $output
                ->add(
                    '"%s"',
                    $string
                )
            ;
        }
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

        $output
            ->addLn(
                'unknown type "%s" : %s',
                $type,
                trim($dump)
            )
        ;
    }

    /**
     * Empty dumped arrays
     *
     * @return Dump
     */
    public function emptyDumpedArrays()
    {
        foreach (array_keys($this->dumpedArrays) as $key) {
            unset($this->dumpedArrays[$key][$this->getDumpedArrayMarker()]);
        }

        $this->dumpedArrays = array();

        return $this;
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
     * @param mixed  $variable
     * @param Output $output
     * @param string $format
     *
     * @return string
     */
    public function getDump(&$variable, Output $output = null, $format = self::FORMAT_VALUE)
    {
        ob_start();

        $this->dump($variable, $output, $format);

        return ob_get_clean();
    }

    /**
     * Returns current dumped array marker
     *
     * @return string
     */
    public function getDumpedArrayMarker()
    {
        return $this->dumpedArrayMarker;
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
     * Check if a given array was already dumped
     *
     * @param array $array
     *
     * @return boolean
     */
    public function isDumpedArray(array $array)
    {
        return isset($array[$this->getDumpedArrayMarker()]);
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
            ->emptyDumpedArrays()
        ;
    }

    /**
     * Set current dumped array marker
     *
     * @param string $marker
     *
     * @return Dump
     */
    public function setDumpedArrayMarker($marker)
    {
        $this->dumpedArrayMarker = $marker;

        return $this;
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
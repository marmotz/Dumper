<?php

namespace Mattlab\Dumper;


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

    protected $variable;

    /**
     * Dump array variable
     *
     * @param array $array
     *
     * @return string
     */
    abstract public function dumpArray(array $array);

    /**
     * Dump object variable
     *
     * @param object $object
     *
     * @return string
     */
    abstract public function dumpObject($object);

    /**
     * Create a dump instance by decorator
     *
     * @param mixed  $variable
     * @param string $decorator
     *
     * @return Dump
     */
    static public function factory($variable, $decorator = null)
    {
        if ($decorator === null) {
            $decorator = php_sapi_name();
        }

        if ($decorator === 'cli') {
            return new CliDump($variable);
        } else {
            return new HtmlDump($variable);
        }
    }

    /**
     * Return one dump
     *
     * @param mixed  $variable
     * @param string $decorator
     *
     * @return string
     */
    static public function getDump($variable, $decorator = null)
    {
        return (string) static::factory($variable, $decorator);
    }

    /**
     * Return all variables dump
     *
     * @param array  $variables
     * @param string $decorator
     *
     * @return string
     */
    static public function getDumps(array $variables, $decorator = null)
    {
        $output = '';

        foreach ($variables as $variable) {
            $output .= static::getDump($variable, $decorator);
        }

        return $output;
    }

    /**
     * Constructor
     *
     * @param mixed $variable
     */
    public function __construct($variable = null)
    {
        $this
            ->reset()
            ->setVariable($variable)
        ;
    }

    /**
     * __toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this
            ->dump(
                $this->getVariable()
            )
        ;
    }

    /**
     * Central dump method
     *
     * Dispatch to all dump methods
     *
     * @param mixed  $variable
     * @param string $format
     *
     * @return string
     */
    public function dump($variable, $format = self::FORMAT_VALUE)
    {
        $type = gettype($variable);

        switch ($type) {
            case 'boolean':
            case 'integer':
            case 'double':
            case 'float':
            case 'string':
            case 'array':
            case 'object':
            case 'resource':
            case 'NULL':
                $method = 'dump' . ucfirst(strtolower($type));

                return $this->$method($variable, $format);
            break;

            default:
                return sprintf(
                    'Unknown type "%s"',
                    $type
                );
            break;
        }
    }

    /**
     * Dump integer variable
     *
     * @param integer $integer
     * @param string  $format
     *
     * @return string
     */
    public function dumpInteger($integer, $format)
    {
        if ($format === self::FORMAT_VALUE) {
            return sprintf(
                'integer(%d)',
                $integer
            );
        } else {
            return (string) $integer;
        }
    }

    /**
     * Dump string variable
     *
     * @param string $string
     * @param string $format
     *
     * @return string
     */
    public function dumpString($string, $format)
    {
        if ($format === self::FORMAT_VALUE) {
            if (function_exists('mb_strlen')) {
                $len = mb_strlen($string, 'UTF-8');
            } else {
                $len = strlen($string);
            }

            return sprintf(
                'string(%d) "%s"',
                $len,
                $string
            );
        } else {
            return sprintf(
                '"%s"',
                $string
            );
        }
    }

    /**
     * Return current variable
     *
     * @return mixed
     */
    public function getVariable()
    {
        return $this->variable;
    }

    /**
     * Prepare array variable (pre dump keys and values)
     *
     * @param array $array
     *
     * @return array
     */
    public function prepareArray(array $array)
    {
        $preparedArray = array();

        foreach ($array as $key => $value) {
            $preparedArray[$this->dump($key, self::FORMAT_KEY)] = $this->dump($value);
        }

        return $preparedArray;
    }

    static public $foo = 4;
    static private $bar = 42;

    /**
     * Prepare object variable (pre dump properties, methods, etc..)
     *
     * @param array $object
     *
     * @return array
     */
    public function prepareObject($object)
    {
        self::$foo = 13;
        $preparedObject = array();

        $class = new \ReflectionClass(get_class($object));

        $preparedObject['class'] = $class;

        // extends
        $preparedObject['extends'] = array();

        $parentClass = $class;

        while ($parentClass = $parentClass->getParentClass()) {
            $preparedObject['extends'][] = $parentClass->getName();
        }

        // properties
        $preparedObject['properties'] = array();

        $filter = \ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE | \ReflectionProperty::IS_STATIC;
        foreach ($class->getProperties($filter) as $propertie) {
            if (!$propertie->isPublic()) {
                $propertie->setAccessible(true);
            }

            $preparedObject['properties'][$propertie->getName()] = array(
                'propertie'    => $propertie,
                'defaultValue' => $propertie->getValue(),
                'value'        => $propertie->getValue($object),
            );
        }

        var_dump($preparedObject);

        return $preparedObject;
    }

    /**
     * Reset current dumper
     *
     * @return self
     */
    public function reset()
    {
        return $this
            ->setVariable()
        ;
    }

    /**
     * Set current variable
     *
     * @param mixed $variable
     *
     * @return self
     */
    public function setVariable($variable = null)
    {
        $this->variable = $variable;

        return $this;
    }
}
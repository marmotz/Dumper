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
     * Do dump array variable
     *
     * @param \Mattlab\Dumper\Proxy\ArrayProxy $array
     *
     * @return string
     */
    abstract public function doDumpArray(Proxy\ArrayProxy $array);

    /**
     * Do dump object variable
     *
     * @param \Mattlab\Dumper\Proxy\ObjectProxy $object
     *
     * @return string
     */
    abstract public function doDumpObject(Proxy\ObjectProxy $object);

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
     * Dump array variable
     *
     * @param array $array
     *
     * @return string
     */
    public function dumpArray(array $array)
    {
        return $this->doDumpArray(
            new Proxy\ArrayProxy($this, $array)
        );
    }

    /**
     * Dump boolean
     *
     * @param boolean $boolean
     *
     * @return string
     */
    public function dumpBoolean($boolean)
    {
        return sprintf(
            'boolean(%s)',
            $boolean ? 'true' : 'false'
        );
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
     * Dump null
     *
     * @return string
     */
    public function dumpNull()
    {
        return 'NULL';
    }

    /**
     * Dump object variable
     *
     * @param object $object
     *
     * @return string
     */
    public function dumpObject($object)
    {
        return $this->doDumpObject(
            new Proxy\ObjectProxy($object)
        );
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
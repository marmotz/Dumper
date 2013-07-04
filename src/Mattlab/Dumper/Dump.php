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
     * @param array $variable
     *
     * @return string
     */
    abstract public function dumpArray(array $variable);

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
     * @param integer $variable
     * @param string  $format
     *
     * @return string
     */
    public function dumpInteger($variable, $format)
    {
        if ($format === self::FORMAT_VALUE) {
            return sprintf(
                'integer(%d)',
                $variable
            );
        } else {
            return (string) $variable;
        }
    }

    /**
     * Dump string variable
     *
     * @param string $variable
     * @param string $format
     *
     * @return string
     */
    public function dumpString($variable, $format)
    {
        if ($format === self::FORMAT_VALUE) {
            if (function_exists('mb_strlen')) {
                $len = mb_strlen($variable, 'UTF-8');
            } else {
                $len = strlen($variable);
            }

            return sprintf(
                'string(%d) "%s"',
                $len,
                $variable
            );
        } else {
            return sprintf(
                '"%s"',
                $variable
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
     * Prepare array variables and pre dump keys and values
     *
     * @param array $variable
     *
     * @return array
     */
    public function prepareArray(array $variable)
    {
        $array = array();

        foreach ($variable as $key => $value) {
            $array[$this->dump($key, self::FORMAT_KEY)] = $this->dump($value);
        }

        return $array;
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
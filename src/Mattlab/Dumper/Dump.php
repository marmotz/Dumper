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
    protected $variable;

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
        $dumps = '';

        foreach ($variables as $variable) {
            $dumps .= static::getDump($variable, $decorator);
        }

        return $dumps;
    }

    /**
     * Constructor
     *
     * @param mixed $variable
     */
    public function __construct($variable = null)
    {
        $this->setVariable($variable);
    }

    /**
     * __toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->dump($this->getVariable());
    }

    /**
     * Central dump method
     *
     * Dispatch to all dump methods
     *
     * @param mixed $variable
     *
     * @return string
     */
    public function dump($variable)
    {
        switch (gettype($variable)) {
            case 'boolean':
            case 'integer':
            case 'double':
            case 'float':
            case 'string':
            case 'array':
            case 'object':
            case 'resource':
            case 'NULL':
                $method = 'dump' . ucfirst(strtolower(gettype($variable)));

                return $this->$method($variable);
            break;

            default:
                return 'Unknown type "' . gettype($variable) . '"';
            break;

        }
    }

    /**
     * Dump integer variable
     *
     * @param integer $variable
     *
     * @return string
     */
    public function dumpInteger($variable)
    {
        return sprintf(
            'integer(%d)',
            $variable
        );
    }

    /**
     * Dump string variable
     *
     * @param string $variable
     *
     * @return string
     */
    public function dumpString($variable)
    {
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
     * Set current variable
     *
     * @param mixed $variable
     *
     * @return self
     */
    public function setVariable($variable)
    {
        $this->variable = $variable;

        return $this;
    }

}
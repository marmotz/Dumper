<?php

namespace Marmotz\Dumper;


/**
 * CLI decorator
 *
 * Dumper for cli interface
 *
 * @package Dumper
 * @author  Renaud Littolff <rlittolff@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link    https://github.com/marmotz/Dumper
 */
class CliDump extends Dump
{
    const INDENT = 2;

    /**
     * Do dump array variable
     *
     * @param Proxy\ArrayProxy $array
     * @param Output           $output
     */
    public function doDumpArray(Proxy\ArrayProxy $array, Output $output)
    {
        $output->render(
            'array.cli',
            array(
                'array' => $array,
            )
        );
    }

    /**
     * Do dump boolean
     *
     * @param string $boolean
     * @param Output $output
     */
    public function doDumpBoolean($boolean, Output $output)
    {
        $output->addLn(
            'boolean(%s)',
            $boolean
        );
    }

    /**
     * Do dump object variable
     *
     * @param Proxy\ObjectProxy $object
     * @param Output            $output
     *
     * @return void
     */
    public function doDumpObject(Proxy\ObjectProxy $object, Output $output)
    {
        $output->render(
            'object.cli',
            array(
                'object' => $object,
            )
        );
    }

    /**
     * Do dump resource
     *
     * @param string $type
     * @param string $resource
     * @param Output $output
     */
    public function doDumpResource($type, $resource, Output $output)
    {
        $output->addLn(
            'resource %s "%s"',
            $type,
            $resource
        );
    }

    /**
     * Do dump string variable
     *
     * @param string  $string
     * @param integer $length
     * @param Output  $output
     * @param integer $format
     */
    public function doDumpString($string, $length, Output $output, $format)
    {
        if ($format === self::FORMAT_COMPLETE) {
            $output->addLn(
                'string(%d) "%s"',
                $length,
                $string
            );
        } else {
            $output->add(
                '"%s"',
                $string
            );
        }
    }

    /**
     * Do dump unknown variable
     *
     * @param string $type
     * @param string $dump
     * @param Output $output
     */
    public function doDumpUnknown($type, $dump, Output $output)
    {
        $output->addLn(
            'unknown type "%s" : %s',
            $type,
            trim($dump)
        );
    }

    /**
     * Dump float
     *
     * @param float  $float
     * @param Output $output
     */
    public function dumpFloat($float, Output $output)
    {
        $output->addLn(
            'float(%s)',
            $float
        );
    }

    /**
     * Dump integer variable
     *
     * @param integer $integer
     * @param Output  $output
     * @param integer $format
     */
    public function dumpInteger($integer, Output $output, $format)
    {
        if ($format === self::FORMAT_COMPLETE) {
            $output->addLn(
                'integer(%d)',
                $integer
            );
        } else {
            $output->add((string) $integer);
        }
    }

    /**
     * Dump null
     *
     * @param Output  $output
     * @param integer $format
     */
    public function dumpNull(Output $output, $format)
    {
        $output->add('NULL');

        if ($format === self::FORMAT_COMPLETE) {
            $output->addLn();
        }
    }

    /**
     * Init current output object
     *
     * @param Output $output
     *
     * @return Output
     */
    public function initOutput(Output $output)
    {
        $output
            ->setIndent(2)
            ->setPrefix('|')
        ;
    }
}
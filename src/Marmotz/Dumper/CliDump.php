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
     * @param integer          $format
     */
    public function doDumpArray(Proxy\ArrayProxy $array, Output $output, $format)
    {
        $output->setPrefixFontOptions(
            'bgblue;fgwhite;bold'
        );

        if ($format === self::FORMAT_COMPLETE) {
            $output->render(
                'array.complete.cli',
                array(
                    'array' => $array,
                )
            );
        } else {
            $output->render(
                'array.short.cli',
                array(
                    'array' => $array,
                )
            );
        }
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
            'boolean(%s%s%s)',
            $output->generateFontOptions('fgyellow'),
            $boolean,
            $output->generateFontOptions('reset')
        );
    }

    /**
     * Do dump object variable
     *
     * @param Proxy\ObjectProxy $object
     * @param Output            $output
     */
    public function doDumpObject(Proxy\ObjectProxy $object, Output $output)
    {
        $output->setPrefixFontOptions(
            'bggreen;fgwhite;bold'
        );

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
            'resource %s "%s%s%s"',
            $type,
            $output->generateFontOptions('fgyellow'),
            $resource,
            $output->generateFontOptions('reset')
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
                'string(%d) %s"%s"%s',
                $length,
                $output->generateFontOptions('fgyellow'),
                $string,
                $output->generateFontOptions('reset')
            );
        } else {
            $output->add(
                '%s"%s"%s',
                $output->generateFontOptions('fgyellow'),
                $string,
                $output->generateFontOptions('reset')
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
            'unknown type "%s" : %s%s%s',
            $type,
            $output->generateFontOptions('fgyellow'),
            trim($dump),
            $output->generateFontOptions('reset')
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
            'float(%s%s%s)',
            $output->generateFontOptions('fgyellow'),
            $float,
            $output->generateFontOptions('reset')
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
                'integer(%s%d%s)',
                $output->generateFontOptions('fgyellow'),
                $integer,
                $output->generateFontOptions('reset')
            );
        } else {
            $output->add(
                '%s%s%s',
                $output->generateFontOptions('fgyellow'),
                $integer,
                $output->generateFontOptions('reset')
            );
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
        $output->add(
            '%sNULL%s',
            $output->generateFontOptions('fgyellow'),
            $output->generateFontOptions('reset')
        );

        if ($format === self::FORMAT_COMPLETE) {
            $output->addLn();
        }
    }

    /**
     * Init current output object
     *
     * @param Output $output
     */
    public function initOutput(Output $output)
    {
        $output
            ->setIndent(2)
            ->setPrefix('|')
            ->enableFontOptions()
        ;
    }
}
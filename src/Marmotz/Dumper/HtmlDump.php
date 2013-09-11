<?php

namespace Marmotz\Dumper;


/**
 * HTML decorator
 *
 * Dumper for web interface
 *
 * @package Dumper
 * @author  Renaud Littolff <rlittolff@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link    https://github.com/marmotz/Dumper
 */
class HtmlDump extends Dump
{
    static protected $cssWritten = false;

    /**
     * Method called just after the whole dump process
     *
     * @param Output $output
     */
    public function afterDump(Output $output)
    {
        $output
            ->dec()
            ->addLn('</div>')
        ;
    }

    /**
     * Method called just before the whole dump process
     *
     * @param Output $output
     */
    public function beforeDump(Output $output)
    {
        $this->writeCss($output);

        $output
            ->addLn('<div class="dumper">')
            ->inc()
        ;
    }

    /**
     * Do dump array variable
     *
     * @param Proxy\ArrayProxy $array
     * @param Output           $output
     * @param integer          $format
     */
    public function doDumpArray(Proxy\ArrayProxy $array, Output $output, $format)
    {
        if ($format === self::FORMAT_COMPLETE) {
            $output->render(
                'array.complete.html',
                array(
                    'array' => $array,
                )
            );
        } else {
            $output->render(
                'array.short.html',
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
            'boolean(%s)',
            $boolean
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
        $output->render(
            'object.html',
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
        $output
            ->addLn(
                'resource %s "%s"',
                $type,
                $resource
            )
        ;
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
            $output
                ->addLn(
                    'string(%d) "%s"',
                    $length,
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
     * Do dump unknown variable
     *
     * @param string $type
     * @param string $dump
     * @param Output $output
     */
    public function doDumpUnknown($type, $dump, Output $output)
    {
        $output
            ->addLn(
                '<span class="unknown">unknown type "%s" : %s</span>',
                $type,
                trim($dump)
            )
        ;
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
     */
    public function initOutput(Output $output)
    {
        $output
            ->setIndent(4)
            ->disableFontOptions()
        ;
    }

    /**
     * Check if css was already written
     *
     * @return boolean
     */
    public function isCssWasWritten()
    {
        return static::$cssWritten === true;
    }

    /**
     * Set if css was already written
     *
     * @param boolean $bool
     *
     * @return HtmlDump
     */
    public function setCssWritten($bool)
    {
        static::$cssWritten = $bool;

        return $this;
    }

    /**
     * Write css if not already written
     *
     * @param Output $output
     */
    public function writeCss(Output $output)
    {
        if (!$this->isCssWasWritten()) {
            $output->render('css.html');

            $this->setCssWritten(true);
        }
    }
}
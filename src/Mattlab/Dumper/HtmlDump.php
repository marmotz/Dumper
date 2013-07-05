<?php

namespace Mattlab\Dumper;


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
    /**
     * Do dump array variable
     *
     * @param \Mattlab\Dumper\Proxy\ArrayProxy $array
     *
     * @return string
     */
    public function doDumpArray(Proxy\ArrayProxy $array)
    {
        $output = '';

        $output .= '<table class="dumper array">' . PHP_EOL;
        $output .= '    <thead>' . PHP_EOL;
        $output .= '        <tr>' . PHP_EOL;
        $output .= '            <th>';
        $output .= sprintf(
            'array(%d)',
            $array->size()
        );
        $output .=             '</th>' . PHP_EOL;
        $output .= '        </tr>' . PHP_EOL;
        $output .= '    </thead>' . PHP_EOL;

        if ($array->size()) {
            $output .= '    <tbody>' . PHP_EOL;

            foreach ($array as $key => $value) {
                $output .= '        <tr>' . PHP_EOL;
                $output .= '            <th>' . $key . '</th>' . PHP_EOL;
                $output .= '            <td>' . $value . '</td>' . PHP_EOL;
                $output .= '        </tr>' . PHP_EOL;
            }

            $output .= '    </tbody>' . PHP_EOL;
        }

        $output .= '</table>' . PHP_EOL;

        return $output;
    }

    /**
     * Do dump object variable
     *
     * @param \Mattlab\Dumper\Proxy\ObjectProxy $object
     *
     * @return string
     */
    public function doDumpObject(Proxy\ObjectProxy $object)
    {

    }
}
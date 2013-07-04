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
     * Dump array variable
     *
     * @param array $variable
     *
     * @return string
     */
    public function dumpArray(array $variable)
    {
        $variable = $this->prepareArray($variable);

        $output = '';

        $output .= '<table class="dumper array">' . PHP_EOL;
        $output .= '    <thead>' . PHP_EOL;
        $output .= '        <tr>' . PHP_EOL;
        $output .= '            <th>';
        $output .= sprintf(
            'array(%d)',
            count($variable)
        );
        $output .=             '</th>' . PHP_EOL;
        $output .= '        </tr>' . PHP_EOL;
        $output .= '    </thead>' . PHP_EOL;

        if ($variable) {
            $output .= '    <tbody>' . PHP_EOL;

            foreach ($variable as $key => $value) {
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
}
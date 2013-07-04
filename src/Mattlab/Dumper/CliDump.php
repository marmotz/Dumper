<?php

namespace Mattlab\Dumper;


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
    /**
     * Dump array variable
     *
     * @param array $array
     *
     * @return string
     */
    public function dumpArray(array $array)
    {
        $array = $this->prepareArray($array);

        $output = '';

        $output .= sprintf(
            'array(%d)' . PHP_EOL,
            count($array)
        );

        $maxLength = 0;
        foreach (array_keys($array) as $key) {
            $maxLength = max($maxLength, strlen($key));
        }

        foreach ($array as $key => $value) {
            $value = explode(PHP_EOL, rtrim($value, PHP_EOL));

            foreach ($value as $k => $line) {
                if ($k !== 0) {
                    $value[$k] = str_repeat(' ', $maxLength + 2) . $line;
                }
            }

            $value = implode(PHP_EOL, $value);

            $output .= sprintf(
                '%s: %s' . PHP_EOL,
                str_pad($key, $maxLength, ' ', STR_PAD_LEFT),
                $value
            );
        }

        return $output;
    }

    public function dumpObject($object)
    {

    }
}
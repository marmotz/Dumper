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
    const INDENT = 2;

    /**
     * Indent given text with given level and optionnaly add given dump
     *
     * @param string  $text
     * @param integer $level
     * @param string  $dump
     *
     * @return string
     */
    public function indent($text, $level = 1, $dump = null)
    {
        $text = $this->indentLine(
            $text,
            $level * self::INDENT
        );

        if ($dump !== null) {
            $text .= $this->indentDump(
                $dump,
                strlen($text)
            );
        }

        return $text;
    }

    /**
     * Indent a dump
     *
     * @param string  $value
     * @param integer $space
     *
     * @return string
     */
    public function indentDump($value, $space)
    {
        $value = explode(PHP_EOL, trim($value));

        foreach ($value as $k => $line) {
            if ($k !== 0) {
                $value[$k] = $this->indentLine(
                    $line,
                    $space
                );
            }
        }

        return implode(PHP_EOL, $value) . PHP_EOL;
    }

    /**
     * Indent a line
     *
     * @param string  $text
     * @param integer $space
     *
     * @return string
     */
    public function indentLine($text, $space)
    {
        return sprintf(
            '| %s%s',
            str_repeat(' ', $space - self::INDENT),
            $text
        );
    }

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

        $output .= sprintf(
            'array(%d)' . PHP_EOL,
            $array->size()
        );

        foreach ($array as $key => $value) {
            $output .= $this->indent(
                sprintf(
                    '%s: ',
                    str_pad($key, $array->getMaxLengthKey(), ' ', STR_PAD_LEFT)
                ),
                1,
                $value
            );
        }

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
        $output = '';

        $output .= sprintf(
            'object %s' . PHP_EOL,
            $object->getClass()->getName()
        );

        foreach ($object->getParents() as $parent) {
            $output .= $this->indent(
                sprintf(
                    'extends %s%s' . PHP_EOL,
                    $parent->isAbstract() ? 'abstract ' : '',
                    $parent->getName()
                )
            );
        }

        foreach ($object->getInterfaces() as $interface) {
            $output .= $this->indent(
                sprintf(
                    'implements %s' . PHP_EOL,
                    $interface->getName()
                )
            );
        }

        foreach ($object->getTraits() as $trait) {
            $output .= $this->indent(
                sprintf(
                    'use trait %s' . PHP_EOL,
                    $trait->getName()
                )
            );
        }

        if ($object->hasConstants()) {
            $output .= $this->indent('Constants :' . PHP_EOL);

            foreach ($object->getConstants() as $name => $value) {
                $output .= $this->indent(
                    sprintf(
                        '%s: ',
                        str_pad($name, $object->getMaxLengthConstantNames())
                    ),
                    2,
                    $this->dump($value)
                );
            }
        }

        if ($object->hasProperties()) {
            $output .= $this->indent('Properties:' . PHP_EOL);

            foreach ($object->getProperties() as $property) {
                $output .= $this->indent(
                    sprintf(
                        '%s $%s' . PHP_EOL,
                        str_pad(
                            ($property['property']->isStatic() ? 'static ' : '') . $property['visibility'],
                            $object->getMaxLengthPropertyVisibilities()
                        ),
                        $property['property']->getName()
                    ),
                    2
                );

                if (isset($property['defaultValue'])) {
                    $output .= $this->indent(
                        'Default : ',
                        3,
                        $this->dump($property['defaultValue'])
                    );
                }

                $output .= $this->indent(
                    'Current : ',
                    3,
                    $this->dump($property['value'])
                );
            }
        }

        if ($object->hasMethods()) {
            $output .= $this->indent('Methods :' . PHP_EOL);

            foreach ($object->getMethods() as $method) {
                $output .= $this->indent(
                    sprintf(
                        '%s %s(%s)' . PHP_EOL,
                        str_pad(
                            ($method['method']->isStatic() ? 'static ' : '') . $method['visibility'],
                            $object->getMaxLengthMethodVisibilities()
                        ),
                        $method['method']->getName(),
                        implode(
                            ', ',
                            array_map(
                                function($argument) {
                                    return sprintf(
                                        '%s%s%s%s',
                                        $argument['type'] ? $argument['type'] . ' ' : '',
                                        $argument['reference'],
                                        $argument['name'],
                                        isset($argument['default']) ? sprintf(
                                            ' = %s',
                                            $argument['default']
                                        ) : ''
                                    );
                                },
                                $method['arguments']
                            )
                        )
                    )
                );
            }
        }

        $output .= PHP_EOL;

        return $output;
    }
}
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
     * Init current output object
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

    /**
     * Do dump array variable
     *
     * @param \Marmotz\Dumper\Proxy\ArrayProxy $array
     *
     * @return string
     */
    public function doDumpArray(Proxy\ArrayProxy $array, Output $output)
    {
        $output
            ->addLn(
                'array(%d)',
                $array->size()
            )
            ->inc()
        ;

        foreach ($array as $key => $value) {
            $output
                ->add(
                    '%s: ',
                    str_pad($key, $array->getMaxLengthKey(), ' ', STR_PAD_LEFT)
                )
                ->dump($value)
            ;
        }

        $output->dec();
    }

    /**
     * Do dump object variable
     *
     * @param \Marmotz\Dumper\Proxy\ObjectProxy $object
     *
     * @return string
     */
    public function doDumpObject(Proxy\ObjectProxy $object, Output $output)
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
                            $property['visibility'] . ($property['property']->isStatic() ? ' static' : ''),
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
                            $method['visibility'] . ($method['method']->isStatic() ? ' static' : ''),
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
                    ),
                    2
                );
            }
        }

        $output .= PHP_EOL;

        return $output;
    }
}
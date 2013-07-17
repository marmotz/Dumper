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
        $output
            ->addLn(
                'array(%d)',
                $array->size()
            )
            ->inc()
        ;

        foreach ($array as $key => $value) {
            $output->add(
                '%s: ',
                str_pad($key, $array->getMaxKeyLength(), ' ', STR_PAD_LEFT)
            );

            if ($array->isRecursion($key)) {
                $output->addLn('*RECURSION*');
            } else {
                $output->dump($value);
            }
        }

        $output->dec();
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
        $output
            ->addLn(
                'object %s',
                $object->getClass()->getName()
            )
            ->inc()
        ;

        foreach ($object->getParents() as $parent) {
            $output
                ->addLn(
                    'extends %s%s',
                    $parent->isAbstract() ? 'abstract ' : '',
                    $parent->getName()
                )
            ;
        }

        foreach ($object->getInterfaces() as $interface) {
            $output
                ->addLn(
                    'implements %s',
                    $interface->getName()
                )
            ;
        }

        foreach ($object->getTraits() as $trait) {
            $output
                ->addLn(
                    'use trait %s',
                    $trait->getName()
                )
            ;
        }

        if ($object->hasConstants()) {
            $output
                ->addLn('Constants :')
                ->inc()
            ;

            foreach ($object->getConstants() as $name => $value) {
                $output
                    ->add(
                        '%s: ',
                        str_pad($name, $object->getMaxLengthConstantNames())
                    )
                    ->dump($value)
                ;
            }

            $output->dec();
        }

        if ($object->hasProperties()) {
            $output
                ->addLn('Properties :')
                ->inc()
            ;

            foreach ($object->getProperties() as $property) {
                $output
                    ->addLn(
                        '%s $%s',
                        str_pad(
                            $property['visibility'] . ($property['property']->isStatic() ? ' static' : ''),
                            $object->getMaxLengthPropertyVisibilities()
                        ),
                        $property['property']->getName()
                    )
                ;

                if (isset($property['defaultValue'])) {
                    $output
                        ->inc()
                            ->add('Default : ')
                            ->dump($property['defaultValue'])
                        ->dec()
                    ;
                }

                $output
                    ->inc()
                        ->add('Current : ')
                ;

                if ($property['isRecursion']) {
                    $output->addLn('*RECURSION*');
                } else {
                    $output->dump($property['value']);
                }

                $output->dec();
            }

            $output->dec();
        }

        if ($object->hasMethods()) {
            $output
                ->addLn('Methods :')
                ->inc()
            ;

            foreach ($object->getMethods() as $method) {
                $output
                    ->addLn(
                        '%s %s(%s)',
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
                    )
                ;
            }

            $output->dec();
        }

        $output->dec();
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
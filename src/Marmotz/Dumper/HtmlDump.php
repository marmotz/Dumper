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
    /**
     * Init current output object
     *
     * @param Output $output
     *
     * @return Output
     */
    public function initOutput(Output $output)
    {
        $output->setIndent(4);
    }


    /**
     * Do dump array variable
     *
     * @param Proxy\ArrayProxy $array
     * @param Output           $output
     *
     * @return string
     */
    public function doDumpArray(Proxy\ArrayProxy $array, Output $output)
    {
        $output
            ->addLn('<table class="dumper array">')
            ->inc()
                ->addLn('<thead>')
                ->inc()
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn(
                            '<th colspan="2">array(%d)</th>',
                            $array->size()
                        )
                    ->dec()
                    ->addLn('</tr>')
                ->dec()
                ->addLn('</thead>')
        ;

        if ($array->size()) {
            $output
                ->addLn('<tbody>')
                ->inc()
            ;

            foreach ($array as $key => $value) {
                $output
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn('<th>%s</th>', $key)
                        ->addLn('<td>')
                        ->inc()
                            ->dump($value)
                        ->dec()
                        ->addLn('</td>')
                    ->dec()
                    ->addLn('</tr>')
                ;
            }

            $output
                ->dec()
                ->addLn('</tbody>')
            ;
        }

        $output
            ->dec()
            ->addLn('</table>')
        ;
    }

    /**
     * Do dump object variable
     *
     * @param Proxy\ObjectProxy $object
     * @param Output            $output
     *
     * @return string
     */
    public function doDumpObject(Proxy\ObjectProxy $object, Output $output)
    {
        $output
            ->addLn('<table class="dumper object">')
            ->inc()
                ->addLn('<thead>')
                ->inc()
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn(
                            '<th>object %s<th>',
                            $object->getClass()->getName()
                        )
                    ->dec()
                    ->addLn('</tr>')
                ->dec()
                ->addLn('</thead>')
        ;

        if ($object->hasParents()) {
            $output
                ->addLn('<tbody class="classAttributes parent">')
                ->inc()
            ;

            foreach ($object->getParents() as $parent) {
                $output
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn(
                            '<td>extends %s%s</td>',
                            $parent->isAbstract() ? 'abstract ' : '',
                            $parent->getName()
                        )
                    ->dec()
                    ->addLn('</tr>')
                ;
            }

            $output
                ->dec()
                ->addLn('</tbody>')
            ;
        }

        if ($object->hasInterfaces()) {
            $output
                ->addLn('<tbody class="classAttributes interface">')
                ->inc()
            ;

            foreach ($object->getInterfaces() as $interface) {
                $output
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn(
                            '<td>implements %s</td>',
                            $interface->getName()
                        )
                    ->dec()
                    ->addLn('</tr>')
                ;
            }

            $output
                ->dec()
                ->addLn('</tbody>')
            ;
        }

        if ($object->hasTraits()) {
            $output
                ->addLn('<tbody class="classAttributes trait">')
                ->inc()
            ;

            foreach ($object->getTraits() as $trait) {
                $output
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn(
                            '<td>use trait %s</td>',
                            $trait->getName()
                        )
                    ->dec()
                    ->addLn('</tr>')
                ;
            }

            $output
                ->dec()
                ->addLn('</tbody>')
            ;
        }

        if ($object->hasConstants()) {
            $output
                ->addLn('<tbody class="constants">')
                ->inc()
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn('<th>Constants :</th>')
                    ->dec()
                    ->addLn('</tr>')
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn('<td>')
                        ->inc()
                            ->addLn('<table>')
                            ->inc()
            ;

            foreach ($object->getConstants() as $name => $value) {
                $output
                                ->addLn('<tr>')
                                ->inc()
                                    ->addLn(
                                        '<td class="name">%s</td>',
                                        $name
                                    )
                                    ->addLn('<td class="value">')
                                    ->inc()
                                        ->dump($value)
                                    ->dec()
                                    ->addLn('</td>')
                                ->dec()
                                ->addLn('</tr>')
                ;
            }

            $output
                            ->dec()
                            ->addLn('</table>')
                        ->dec()
                        ->addLn('</td>')
                    ->dec()
                    ->addLn('</tr>')
                ->dec()
                ->addLn('</tbody>')
            ;
        }

        if ($object->hasProperties()) {
            $output
                ->addLn('<tbody class="properties">')
                ->inc()
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn('<th>Properties :</th>')
                    ->dec()
                    ->addLn('</tr>')
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn('<td>')
                        ->inc()
                            ->addLn('<table>')
                            ->inc()
            ;

            foreach ($object->getProperties() as $property) {
                $output
                                ->addLn('<tr>')
                                ->inc()
                                    ->addLn(
                                        '<td class="name"%s>%s $%s</td>',
                                        isset($property['defaultValue']) ? ' rowspan="2"' : '',
                                        ($property['property']->isStatic() ? 'static ' : '') . $property['visibility'],
                                        $property['property']->getName()
                                    )
                ;

                if (isset($property['defaultValue'])) {
                    $output
                                    ->addLn('<td class="type">Default:</td>')
                                    ->addLn('<td class="value default">')
                                    ->inc()
                                        ->dump($property['defaultValue'])
                                    ->dec()
                                    ->addLn('</td>')
                                ->dec()
                                ->addLn('</tr>')
                                ->addLn('<tr>')
                                ->inc()
                    ;
                }

                $output
                                    ->addLn('<td class="type">Current:</td>')
                                    ->addLn('<td class="value current">')
                                    ->inc()
                                        ->dump($property['value'])
                                    ->dec()
                                    ->addLn('</td>')
                                ->dec()
                                ->addLn('</tr>')
                ;
            }

            $output
                            ->dec()
                            ->addLn('</table>')
                        ->dec()
                        ->addLn('</td>')
                    ->dec()
                    ->addLn('</tr>')
                ->dec()
                ->addLn('</tbody>')
            ;
        }

        if ($object->hasMethods()) {
            $output
                ->addLn('<tbody class="methods">')
                ->inc()
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn('<th>Methods :</th>')
                    ->dec()
                    ->addLn('</tr>')
            ;

            foreach ($object->getMethods() as $method) {
                $output
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn(
                            '<td>%s %s(%s)</td>',
                            ($method['method']->isStatic() ? 'static ' : '') . $method['visibility'],
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
                    ->dec()
                    ->addLn('</tr>')
                ;
            }

            $output
                ->dec()
                ->addLn('</tbody>')
            ;
        }

        $output
            ->dec()
            ->addLn('</table>')
        ;
    }
}
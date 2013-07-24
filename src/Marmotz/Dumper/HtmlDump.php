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

        if (!$this->isCssWasWritten()) {
            $output
            ->addLn('<style type="text/css">')
            ->inc()
                ->addLn('.dumper, .dumper table {')
                ->inc()
                    ->addLn('background-color: white;')
                    ->addLn('color: black;')
                    ->addLn('font-family: sans-serif;')
                    ->addLn('font-size: 12px;')
                ->dec()
                ->addLn('}')

                ->addLn('.dumper table {')
                ->inc()
                    ->addLn('border-spacing: 1px;')
                    ->addLn('background-color: white;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table tbody th {')
                ->inc()
                    ->addLn('text-align: left;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table tbody td {')
                ->inc()
                    ->addLn('background: #EEE;')
                ->dec()
                ->addLn('}')

                ->addLn('.dumper > table.array, .dumper > table.object {')
                ->inc()
                    ->addLn('margin: 10px 0;')
                    ->addLn('box-shadow: 2px 2px 10px black;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.array, .dumper table.object {')
                ->inc()
                    ->addLn('border: 1px solid black;')
                ->dec()
                ->addLn('}')

                ->addLn('.dumper table.array {')
                ->inc()
                    ->addLn('border-color: #345678;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.array thead {')
                ->inc()
                    ->addLn('background-color: #345678;')
                    ->addLn('color: white;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.array tbody > tr > th {')
                ->inc()
                    ->addLn('background-color: #56789A;')
                    ->addLn('color: white;')
                ->dec()
                ->addLn('}')

                ->addLn('.dumper table.object {')
                ->inc()
                    ->addLn('border-color: #347856;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object thead {')
                ->inc()
                    ->addLn('background-color: #347856;')
                    ->addLn('color: white;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object tbody > tr > th {')
                ->inc()
                    ->addLn('background-color: #569A78;')
                    ->addLn('color: white;')
                ->dec()
                ->addLn('}')
            ->dec()
            ->addLn('</style>')
            ;

            $this->setCssWritten(true);
        }
    }

    /**
     * Method called just before the whole dump process
     *
     * @param Output $output
     */
    public function beforeDump(Output $output)
    {
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
     *
     * @return string
     */
    public function doDumpArray(Proxy\ArrayProxy $array, Output $output)
    {
        $output
            ->addLn('<table class="array">')
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
                        ->addLn('<th>')
                        ->inc()
                            ->addLn($key)
                        ->dec()
                        ->addLn('</th>')
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
            ->addLn('<table class="object">')
            ->inc()
                ->addLn('<thead>')
                ->inc()
                    ->addLn('<tr>')
                    ->inc()
                        ->addLn(
                            '<th>object %s</th>',
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
                            ->add('<td>')
                            // visibility
                            ->add(($method['method']->isStatic() ? 'static ' : '') . $method['visibility'])
                            // method name
                            ->add(' ' . $method['method']->getName() . '(')
                ;

                // arguments
                foreach ($method['arguments'] as $key => $argument) {
                    // type
                    if ($argument['type']) {
                        $output
                            ->add($argument['type'] . ' ')
                        ;
                    }

                    $output
                            // reference "&"
                            ->add($argument['reference'])
                            // name
                            ->add($argument['name'])
                    ;

                    // default value
                    if (array_key_exists('default', $argument)) {
                        $output
                            ->add(' = ')
                            ->dump($argument['default'], self::FORMAT_SHORT)
                        ;
                    }

                    if ($key != count($method['arguments']) - 1) {
                        $output
                            ->add(', ')
                        ;
                    }
                }

                $output
                            ->addLn(')</td>')
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
     * Do dump string variable
     *
     * @param string  $string
     * @param integer $length
     * @param Output  $output
     * @param integer $format
     */
    public function doDumpString($string, $length, Output $output, $format)
    {
        $output->add('<span class="string">');

        if ($format === self::FORMAT_COMPLETE) {
            $output
                ->add(
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

        $output->add('</span>');

        if ($format === self::FORMAT_COMPLETE) {
            $output->addLn();
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
     * Dump boolean
     *
     * @param boolean $boolean
     * @param Output  $output
     */
    public function dumpBoolean($boolean, Output $output)
    {
        $output
            ->addLn(
                '<span class="boolean">boolean(%s)</span>',
                $boolean ? 'true' : 'false'
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
        $output
            ->addLn(
                '<span class="float">float(%s)</span>',
                $float
            )
        ;
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
        $output->add('<span class="integer">');

        if ($format === self::FORMAT_COMPLETE) {
            $output
                ->add(
                    'integer(%d)',
                    $integer
                )
            ;
        } else {
            $output
                ->add((string) $integer)
            ;
        }

        $output->add('</span>');

        if ($format === self::FORMAT_COMPLETE) {
            $output->addLn();
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
        $output->add('<span class="null">NULL</span>');

        if ($format === self::FORMAT_COMPLETE) {
            $output->addLn();
        }
    }

    /**
     * Dump resource
     *
     * @param resource $resource
     * @param Output   $output
     */
    public function dumpResource($resource, Output $output)
    {
        $output
            ->addLn(
                '<span class="resource">resource %s "%s"</span>',
                get_resource_type($resource),
                (string) $resource
            )
        ;
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
        $output->setIndent(4);
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
}
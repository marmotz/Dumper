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
                    ->addLn('background:    -moz-linear-gradient(top, #345678 0%%, #56789A 100%%);')
                    ->addLn('background: -webkit-linear-gradient(top, #345678 0%%, #56789A 100%%);')
                    ->addLn('background:      -o-linear-gradient(top, #345678 0%%, #56789A 100%%);')
                    ->addLn('background:     -ms-linear-gradient(top, #345678 0%%, #56789A 100%%);')
                    ->addLn('background:         linear-gradient(top, #345678 0%%, #56789A 100%%);')
                    ->addLn('color: white;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.array thead th {')
                ->inc()
                    ->addLn('text-align: center;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.array tbody > tr > th {')
                ->inc()
                    ->addLn('background-color: #56789A;')
                    ->addLn('background:    -moz-linear-gradient(left, #56789A 0%%, #89ABCD 100%%);')
                    ->addLn('background: -webkit-linear-gradient(left, #56789A 0%%, #89ABCD 100%%);')
                    ->addLn('background:      -o-linear-gradient(left, #56789A 0%%, #89ABCD 100%%);')
                    ->addLn('background:     -ms-linear-gradient(left, #56789A 0%%, #89ABCD 100%%);')
                    ->addLn('background:         linear-gradient(left, #56789A 0%%, #89ABCD 100%%);')
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
                    ->addLn('background:    -moz-linear-gradient(top, #347856 0%%, #569A78 100%%);')
                    ->addLn('background: -webkit-linear-gradient(top, #347856 0%%, #569A78 100%%);')
                    ->addLn('background:      -o-linear-gradient(top, #347856 0%%, #569A78 100%%);')
                    ->addLn('background:     -ms-linear-gradient(top, #347856 0%%, #569A78 100%%);')
                    ->addLn('background:         linear-gradient(top, #347856 0%%, #569A78 100%%);')
                    ->addLn('color: white;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object thead th {')
                ->inc()
                    ->addLn('text-align: center;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object tbody > tr > th {')
                ->inc()
                    ->addLn('background-color: #569A78;')
                    ->addLn('background:    -moz-linear-gradient(left, #569A78 0%%, #89CDAB 100%%);')
                    ->addLn('background: -webkit-linear-gradient(left, #569A78 0%%, #89CDAB 100%%);')
                    ->addLn('background:      -o-linear-gradient(left, #569A78 0%%, #89CDAB 100%%);')
                    ->addLn('background:     -ms-linear-gradient(left, #569A78 0%%, #89CDAB 100%%);')
                    ->addLn('background:         linear-gradient(left, #569A78 0%%, #89CDAB 100%%);')
                    ->addLn('color: white;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object tbody.classAttributes {')
                ->inc()
                    ->addLn('font-style: italic;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object tbody.classAttributes td span.class {')
                ->inc()
                    ->addLn('font-weight: bold;')
                    ->addLn('font-style: normal;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object tbody.constants table {')
                ->inc()
                    ->addLn('width: 100%%;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object tbody.properties .visibility,')
                ->addLn('.dumper table.object tbody.methods .visibility {')
                ->inc()
                    ->addLn('color: #258FD9;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object tbody.properties .static,')
                ->addLn('.dumper table.object tbody.methods .static {')
                ->inc()
                    ->addLn('color: #25A96F;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object tbody.properties tr.default td:nth-child(n+2) {')
                ->inc()
                    ->addLn('color: #666;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object tbody.methods span.arguments .type {')
                ->inc()
                    ->addLn('color: #550;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object tbody.methods span.arguments .name {')
                ->inc()
                    ->addLn('color: #500;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper table.object tbody.methods span.arguments .value {')
                ->inc()
                    ->addLn('color: #055;')
                ->dec()
                ->addLn('}')
                ->addLn('.dumper .unknown {')
                ->inc()
                    ->addLn('color: #900;')
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
     * Do dump boolean
     *
     * @param string $boolean
     * @param Output $output
     */
    public function doDumpBoolean($boolean, Output $output)
    {
        $output
            ->addLn(
                'boolean(%s)',
                $boolean
            )
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
                            '<td>extends %s<span class="class">%s</span></td>',
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
                            '<td>implements <span class="class">%s</span></td>',
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
                            '<td>use trait <span class="class">%s</span></td>',
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
                                        '<td>%s</td>',
                                        $name
                                    )
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
                                ->addLn(
                                    '<tr%s>',
                                    isset($property['defaultValue']) ? ' class="default"' : ''
                                )
                                ->inc()
                                    ->addLn(
                                        '<td%s><span class="visibility">%s</span> $%s</td>',
                                        isset($property['defaultValue']) ? ' rowspan="2"' : '',
                                        ($property['property']->isStatic() ? '<span class="static">static</span> ' : '') . $property['visibility'],
                                        $property['property']->getName()
                                    )
                ;

                if (isset($property['defaultValue'])) {
                    $output
                                    ->addLn('<td>Default:</td>')
                                    ->addLn('<td>')
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
                                    ->addLn('<td>Current:</td>')
                                    ->addLn('<td>')
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
                            ->add(
                                '<span class="visibility">%s</span>',
                                ($method['method']->isStatic() ? '<span class="static">static</span> ' : '') . $method['visibility']
                            )
                            // method name
                            ->add(' ' . $method['method']->getName() . '(')
                ;

                if ($method['arguments']) {
                    $output
                            ->add('<span class="arguments">')
                    ;

                    // arguments
                    foreach ($method['arguments'] as $key => $argument) {
                        // type
                        if ($argument['type']) {
                            $output
                            ->add(
                                '<span class="type">%s</span> ',
                                $argument['type']
                            )
                            ;
                        }

                        $output
                            // reference "&"
                            ->add($argument['reference'])
                            // name
                            ->add(
                                '<span class="name">%s</span>',
                                $argument['name']
                            )
                        ;

                        // default value
                        if (array_key_exists('default', $argument)) {
                            $output
                            ->add(' = <span class="value">')
                            ->dump($argument['default'], self::FORMAT_SHORT)
                            ->add('</span>')
                            ;
                        }

                        if ($key != count($method['arguments']) - 1) {
                            $output
                            ->add(', ')
                            ;
                        }
                    }

                    $output
                            ->add('</span>')
                    ;
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
     * Dump float
     *
     * @param float  $float
     * @param Output $output
     */
    public function dumpFloat($float, Output $output)
    {
        $output
            ->addLn(
                'float(%s)',
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
        if ($format === self::FORMAT_COMPLETE) {
            $output
                ->addLn(
                    'integer(%d)',
                    $integer
                )
            ;
        } else {
            $output
                ->add((string) $integer)
            ;
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
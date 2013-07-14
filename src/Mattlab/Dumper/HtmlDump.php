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
        $output .= '            <th colspan="2">';
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
                $output .= '            <td>' . $this->indentDump(12, $value) . '</td>' . PHP_EOL;
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
        $output = '';

        $output .= '<table class="dumper object">' . PHP_EOL;
        $output .= '    <thead>' . PHP_EOL;
        $output .= '        <tr>' . PHP_EOL;
        $output .= '            <th colspan="3">';
        $output .= sprintf(
            'object %s',
            $object->getClass()->getName()
        );
        $output .=             '<th>' . PHP_EOL;
        $output .= '        </tr>' . PHP_EOL;
        $output .= '    </thead>' . PHP_EOL;

        if ($object->hasParents()) {
            $output .= '    <tbody class="classAttributes parent">' . PHP_EOL;

            foreach ($object->getParents() as $parent) {
                $output .= '        <tr>' . PHP_EOL;
                $output .= '            <td colspan="3">';
                $output .= sprintf(
                    'extends %s%s',
                    $parent->isAbstract() ? 'abstract ' : '',
                    $parent->getName()
                );
                $output .=             '<td>' . PHP_EOL;
                $output .= '        </tr>' . PHP_EOL;
            }

            $output .= '    </tbody>' . PHP_EOL;
        }

        if ($object->hasInterfaces()) {
            $output .= '    <tbody class="classAttributes interface">' . PHP_EOL;

            foreach ($object->getInterfaces() as $interface) {
                $output .= '        <tr>' . PHP_EOL;
                $output .= '            <td colspan="3">';
                $output .= sprintf(
                    'implements %s',
                    $interface->getName()
                );
                $output .=             '<td>' . PHP_EOL;
                $output .= '        </tr>' . PHP_EOL;
            }

            $output .= '    </tbody>' . PHP_EOL;
        }

        if ($object->hasTraits()) {
            $output .= '    <tbody class="classAttributes trait">' . PHP_EOL;

            foreach ($object->getTraits() as $trait) {
                $output .= '        <tr>' . PHP_EOL;
                $output .= '            <td colspan="3" class="trait">';
                $output .= sprintf(
                    'use trait %s',
                    $trait->getName()
                );
                $output .=             '<td>' . PHP_EOL;
                $output .= '        </tr>' . PHP_EOL;
            }

            $output .= '    </tbody>' . PHP_EOL;
        }

        if ($object->hasConstants()) {
            $output .= '    <tbody class="constants">' . PHP_EOL;
            $output .= '        <tr>' . PHP_EOL;
            $output .= '            <th colspan="3">Constants :</th>' . PHP_EOL;
            $output .= '        </tr>' . PHP_EOL;

            foreach ($object->getConstants() as $name => $value) {
                $output .= '        <tr>' . PHP_EOL;
                $output .= '            <td class="name">' . $name . '</td>' . PHP_EOL;
                $output .= '            <td class="value">' . $this->dump($value) . '</td>' . PHP_EOL;
                $output .= '        </tr>' . PHP_EOL;
            }

            $output .= '    </tbody>' . PHP_EOL;
        }

        if ($object->hasProperties()) {
            $output .= '    <tbody class="properties">' . PHP_EOL;
            $output .= '        <tr>' . PHP_EOL;
            $output .= '            <th colspan="3">Properties :</th>' . PHP_EOL;
            $output .= '        </tr>' . PHP_EOL;

            foreach ($object->getProperties() as $property) {
                $output .= '        <tr>' . PHP_EOL;
                $output .= '            <td class="name"' . (isset($property['defaultValue']) ? ' rowspan="2"' : '') . '>';
                $output .= sprintf(
                    '%s $%s',
                    ($property['property']->isStatic() ? 'static ' : '') . $property['visibility'],
                    $property['property']->getName()
                );
                $output .=             '</td>' . PHP_EOL;

                if (isset($property['defaultValue'])) {
                    $output .= '            <td class="type">Default:</td>' . PHP_EOL;
                    $output .= '            <td class="value default">' . $this->indentDump(12, $this->dump($property['defaultValue'])) . '</td>' . PHP_EOL;
                    $output .= '        </tr>' . PHP_EOL;
                    $output .= '        <tr>' . PHP_EOL;
                }

                $output .= '            <td class="type">Current:</td>' . PHP_EOL;
                $output .= '            <td class="value current">' . $this->indentDump(12, $this->dump($property['value'])) . '</td>' . PHP_EOL;
                $output .= '        </tr>' . PHP_EOL;
            }

            $output .= '    </tbody>' . PHP_EOL;
        }

        if ($object->hasMethods()) {
            $output .= '    <tbody class="methods">' . PHP_EOL;
            $output .= '        <tr>' . PHP_EOL;
            $output .= '            <th colspan="3">Methods :</th>' . PHP_EOL;
            $output .= '        </tr>' . PHP_EOL;

            foreach ($object->getMethods() as $method) {
                $output .= '        <tr>' . PHP_EOL;
                $output .= '            <td colspan="3">';
                $output .= sprintf(
                    '%s %s(%s)',
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
                );
                $output .=             '</td>' . PHP_EOL;
                $output .= '        </tr>' . PHP_EOL;
            }

            $output .= '    </tbody>' . PHP_EOL;
        }

        $output .= '</table>' . PHP_EOL;

        return $output;
    }

    /**
     * Indent given dump
     *
     * @param integer $indent
     * @param string  $dump
     *
     * @return string
     */
    public function indentDump($indent, $dump)
    {
        $dump = explode(PHP_EOL, trim($dump));

        if (count($dump) === 1) {
            return $dump[0];
        } else {
            return PHP_EOL . str_repeat(' ', $indent + 4) . implode(
                PHP_EOL . str_repeat(' ', $indent + 4),
                $dump
            ) . PHP_EOL . str_repeat(' ', $indent);
        }
    }
}
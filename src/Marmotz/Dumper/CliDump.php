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
            $output
                ->add(
                    '%s: ',
                    str_pad($key, $array->getMaxKeyLength(), ' ', STR_PAD_LEFT)
                )
                ->dump($value)
            ;
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
                        ->dump($property['value'])
                    ->dec()
                ;
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
                    // visibility
                    ->add(
                        str_pad(
                            $method['visibility'] . ($method['method']->isStatic() ? ' static' : ''),
                            $object->getMaxLengthMethodVisibilities()
                        )
                    )
                    // method name
                    ->add(' ' . $method['method']->getName() . '(')
                ;

                // arguments
                foreach ($method['arguments'] as $key => $argument) {
                    // type
                    if ($argument['type']) {
                        $output->add($argument['type'] . ' ');
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
                        $output->add(', ');
                    }
                }

                $output->addLn(')');
            }

            $output->dec();
        }

        $output->dec();
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
                'unknown type "%s" : %s',
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
                'boolean(%s)',
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
     * Dump resource
     *
     * @param resource $resource
     * @param Output   $output
     */
    public function dumpResource($resource, Output $output)
    {
        $output
            ->addLn(
                'resource %s "%s"',
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
        $output
            ->setIndent(2)
            ->setPrefix('|')
        ;
    }
}
<?php

namespace tests\units\Mattlab\Dumper;

use atoum;
use Mattlab\Dumper\Dump      as TestedClass;
use mock\Mattlab\Dumper\Dump as mockTestedClass;
use stdClass;


class Dump extends atoum
{

    public function testConstruct()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->variable($dump->getVariable())
                    ->isNull()

            ->if($dump = new mockTestedClass($variable = uniqid()))
                ->string($dump->getVariable())
                    ->isEqualTo($variable)
        ;
    }

    public function testDumpInteger()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->string($dump->dumpInteger(42, TestedClass::FORMAT_KEY))
                    ->isEqualTo('42')
                ->string($dump->dumpInteger(42, TestedClass::FORMAT_VALUE))
                    ->isEqualTo('integer(42)')
        ;
    }

    public function testDumpString()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->string($dump->dumpString('azerty', TestedClass::FORMAT_KEY))
                    ->isEqualTo('"azerty"')
                ->string($dump->dumpString('azerty', TestedClass::FORMAT_VALUE))
                    ->isEqualTo('string(6) "azerty"')
        ;
    }

    /** @extensions mbstring */
    public function testDumpStringIUtf8()
    {
        $this
            ->if($dump = new mockTestedClass)
            ->and($variable = 'àâäéèêëîïôöùüŷÿ')
            ->and($variable = mb_convert_encoding($variable, 'UTF-8', mb_detect_encoding($variable)))
                ->string($dump->dumpString($variable, TestedClass::FORMAT_KEY))
                    ->isEqualTo('"àâäéèêëîïôöùüŷÿ"')
                ->string($dump->dumpString($variable, TestedClass::FORMAT_VALUE))
                    ->isEqualTo('string(15) "àâäéèêëîïôöùüŷÿ"')
        ;
    }

    public function testFactory()
    {
        $this
            ->object($dump = TestedClass::factory(uniqid(), 'cli'))
                ->isInstanceOf('Mattlab\Dumper\CliDump')
            ->object($dump = TestedClass::factory(uniqid(), 'apache2'))
                ->isInstanceOf('Mattlab\Dumper\HtmlDump')
        ;
    }

    public function testGetDump()
    {
        $this
            ->string(TestedClass::getDump(42, 'cli'))
                ->contains('42')
        ;
    }

    public function testGetDumps()
    {
        $this
            ->string(TestedClass::getDumps(array(42, 'dump'), 'cli'))
                ->contains('42')
                ->contains('dump')
        ;
    }

    public function testPrepareArray()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->array(
                    $dump->prepareArray(
                        array()
                    )
                )
                    ->isIdenticalTo(
                        array()
                    )
                ->array(
                    $dump->prepareArray(
                        array(1)
                    )
                )
                    ->isIdenticalTo(
                        array(
                            $dump->dump(0, TestedClass::FORMAT_KEY) => $dump->dump(1)
                        )
                    )
                ->array(
                    $dump->prepareArray(
                        array(
                            1,
                            'key' => 42
                        )
                    )
                )
                    ->isIdenticalTo(
                        array(
                            $dump->dump(0,     TestedClass::FORMAT_KEY) => $dump->dump(1),
                            $dump->dump('key', TestedClass::FORMAT_KEY) => $dump->dump(42),
                        )
                    )
        ;
    }

    public function testPrepareObject()
    {
        $this
            ->if($dump = new mockTestedClass(4))
                ->array($preparedObject = $dump->prepareObject(new stdClass))
                    // ->keys
                    ->array(array_keys($preparedObject))
                        // ->isIdenticalTo(
                        //     array(
                        //         'class',
                        //         'extends',
                        //         'properties',
                        //         'staticProperties',
                        //     )
                        // )
                ->object($preparedObject['class'])
                    // ->isInstanceOf('ReflectionObject')
                ->array($preparedObject['extends'])
                    ->foreach(
                        $preparedObject['extends'],
                        function($assert, $extend) {
                            $assert->string($extend);
                        }
                    )
                ->array($preparedObject['properties'])
                    ->foreach(
                        $preparedObject['properties'],
                        function($assert, $propertie) {
                            $assert
                                ->object($propertie)
                                    ->isInstanceOf('ReflectionPropertie')
                            ;
                        }
                    )

            ->if($dump = new mockTestedClass)
                ->array($preparedObject = $dump->prepareObject($dump))
        ;
    }

    public function testSetGetVariable()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->object($dump->setVariable($variable = new \StdClass))
                    ->isIdenticalTo($dump)
                ->object($dump->getVariable())
                    ->isIdenticalTo($variable)
        ;
    }

}
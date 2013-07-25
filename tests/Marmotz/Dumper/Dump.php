<?php

namespace tests\units\Marmotz\Dumper;

use atoum;
use Marmotz\Dumper\Dump      as TestedClass;
use mock\Marmotz\Dumper\Dump as mockTestedClass;
use Marmotz\Dumper\Output;
use Marmotz\Dumper\Proxy;


class Dump extends atoum
{
    public function testConstruct()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->integer($dump->getLevel())
                    ->isEqualTo(0)
        ;
    }

    public function testDump()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $variable = array();
                        $dump->dump($variable);
                    }
                )
                ->mock($dump)
                    ->call('dumpArray')
                        ->once()
                ->integer($dump->getLevel())
                    ->isEqualTo(0)
        ;
    }

    public function testDumpArray()
    {
        $this
            ->if($dump = new mockTestedClass)
            ->and($array = array())
                ->output(
                    function() use($dump, $array) {
                        $dump->dumpArray($array, $dump->createOutput());
                    }
                )
                ->mock($dump)
                    ->call('doDumpArray')
                        ->once()
        ;
    }

    public function testDumpObject()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dumpObject($dump, $dump->createOutput());
                    }
                )
                ->mock($dump)
                    ->call('doDumpObject')
                        ->once()
        ;
    }

    public function testFactory()
    {
        $this
            ->object($dump = TestedClass::factory('cli'))
                ->isInstanceOf('Marmotz\Dumper\CliDump')
            ->object($dump = TestedClass::factory('apache2'))
                ->isInstanceOf('Marmotz\Dumper\HtmlDump')
        ;
    }

    public function testFunctionGetDump()
    {
        $this
            ->string(getDump(42))
                ->isEqualTo(
                    'integer(42)' . PHP_EOL .
                    PHP_EOL
                )

            ->string(getDump(42, 'foobar', new \stdClass))
                ->isEqualTo(
                    'integer(42)' . PHP_EOL .
                    PHP_EOL .
                    'string(6) "foobar"' . PHP_EOL .
                    PHP_EOL .
                    'object stdClass' . PHP_EOL .
                    PHP_EOL
                )
        ;
    }

    // public function testFunctionDumpd()
    // {
    //     $this
    //         ->output(
    //             function() {
    //                 dumpd(42);
    //                 echo 'never executed';
    //             }
    //         )
    //             ->isEqualTo(
    //                 'integer(42)' . PHP_EOL .
    //                 PHP_EOL
    //             )

    //         ->output(
    //             function() {
    //                 dumpd(42, 'foobar', new \stdClass);
    //                 echo 'never executed';
    //             }
    //         )
    //             ->isEqualTo(
    //                 'integer(42)' . PHP_EOL .
    //                 PHP_EOL .
    //                 'string(6) "foobar"' . PHP_EOL .
    //                 PHP_EOL .
    //                 'object stdClass' . PHP_EOL .
    //                 PHP_EOL
    //             )
    //     ;
    // }

    public function testFunctionDump()
    {
        $this
            ->output(
                function() {
                    dump(42);
                }
            )
                ->isEqualTo(
                    'integer(42)' . PHP_EOL .
                    PHP_EOL
                )

            ->output(
                function() {
                    dump(42, 'foobar', new \stdClass);
                }
            )
                ->isEqualTo(
                    'integer(42)' . PHP_EOL .
                    PHP_EOL .
                    'string(6) "foobar"' . PHP_EOL .
                    PHP_EOL .
                    'object stdClass' . PHP_EOL .
                    PHP_EOL
                )
        ;
    }

    public function testIncDecSetGetLevel()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->object($dump->setLevel($level = rand(10, 20)))
                    ->isIdenticalTo($dump)
                ->integer($dump->getLevel())
                    ->isIdenticalTo($level)

                ->object($dump->incLevel())
                    ->isIdenticalTo($dump)
                ->integer($dump->getLevel())
                    ->isIdenticalTo($level + 1)

                ->object($dump->decLevel())
                    ->isIdenticalTo($dump)
                ->integer($dump->getLevel())
                    ->isIdenticalTo($level)
        ;
    }

    public function testIsMaxLevelOfRecursion()
    {
        $this
            ->variable(mockTestedClass::setMaxLevelofRecursion(5))
                ->isNull()
            ->boolean(mockTestedClass::isMaxLevelOfRecursion(4))
                ->isFalse()
            ->boolean(mockTestedClass::isMaxLevelOfRecursion(5))
                ->isFalse()
            ->boolean(mockTestedClass::isMaxLevelOfRecursion(6))
                ->isTrue()
        ;
    }

    public function testMaxLevelOfRecursion()
    {
        $this
            ->variable(mockTestedClass::setMaxLevelofRecursion($level = rand(1,19)))
                ->isNull()
            ->integer(mockTestedClass::getMaxLevelofRecursion())
                ->isEqualTo($level)

            ->variable(mockTestedClass::setMaxLevelofRecursion($level = (string) rand(1,19)))
                ->isNull()
            ->integer(mockTestedClass::getMaxLevelofRecursion())
                ->isEqualTo((int) $level)

            ->variable(mockTestedClass::setMaxLevelofRecursion(false))
                ->isNull()
            ->boolean(mockTestedClass::getMaxLevelofRecursion())
                ->isFalse()

            ->variable(mockTestedClass::setMaxLevelofRecursion(-1))
                ->isNull()
            ->boolean(mockTestedClass::getMaxLevelofRecursion())
                ->isFalse()
        ;
    }
}
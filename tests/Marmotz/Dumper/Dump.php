<?php

namespace tests\units\Marmotz\Dumper;

use atoum;
use Marmotz\Dumper\Dump      as TestedClass;
use mock\Marmotz\Dumper\Dump as mockTestedClass;
use Marmotz\Dumper\Output;
use Marmotz\Dumper\Proxy;

require_once __DIR__ . '/../../resources/classes/SampleClass1.php';


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

    public function testDumpBoolean()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dumpBoolean(true, $dump->createOutput());
                    }
                )
                    ->isEqualTo('boolean(true)' . PHP_EOL)
                ->output(
                    function() use($dump) {
                        $dump->dumpBoolean(false, $dump->createOutput());
                    }
                )
                    ->isEqualTo('boolean(false)' . PHP_EOL)
        ;
    }

    public function testDumpDouble()
    {
        $this
            ->if($dump = new mockTestedClass)
            ->and($float = 1.2)
                ->output(
                    function() use($dump, $float) {
                        $dump->dumpDouble($float, $dump->createOutput());
                    }
                )
                ->mock($dump)
                    ->call('dumpFloat')
                        ->withIdenticalArguments($float)
        ;
    }

    public function testDumpFloat()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dumpFloat(1.2, $dump->createOutput());
                    }
                )
                    ->isEqualTo('float(1.2)' . PHP_EOL)
        ;
    }

    public function testDumpInteger()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dumpInteger(42, $dump->createOutput(), TestedClass::FORMAT_KEY);
                    }
                )
                    ->isEqualTo('42')
                ->output(
                    function() use($dump) {
                        $dump->dumpInteger(42, $dump->createOutput(), TestedClass::FORMAT_VALUE);
                    }
                )
                    ->isEqualTo('integer(42)' . PHP_EOL)
        ;
    }

    public function testDumpNull()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dumpNull($dump->createOutput());
                    }
                )
                    ->isEqualTo('NULL' . PHP_EOL)
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

    public function testDumpResource()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dumpResource(fopen(__FILE__, 'r'), $dump->createOutput());
                    }
                )
                    ->match('/^resource stream "Resource id #[0-9]+"$/')
        ;
    }

    public function testDumpString()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dumpString('azerty', $dump->createOutput(), TestedClass::FORMAT_KEY);
                    }
                )
                    ->isEqualTo('"azerty"')
                ->output(
                    function() use($dump) {
                        $dump->dumpString('azerty', $dump->createOutput(), TestedClass::FORMAT_VALUE);
                    }
                )
                    ->isEqualTo('string(6) "azerty"' . PHP_EOL)
        ;
    }

    /** @extensions mbstring */
    public function testDumpStringIUtf8()
    {
        $this
            ->if($dump = new mockTestedClass)
            ->and($variable = 'àâäéèêëîïôöùüŷÿ')
            ->and($variable = mb_convert_encoding($variable, 'UTF-8', mb_detect_encoding($variable)))
                ->output(
                    function() use($dump, $variable) {
                        $dump->dumpString($variable, $dump->createOutput(), TestedClass::FORMAT_KEY);
                    }
                )
                    ->isEqualTo('"àâäéèêëîïôöùüŷÿ"')
                ->output(
                    function() use($dump, $variable) {
                        $dump->dumpString($variable, $dump->createOutput(), TestedClass::FORMAT_VALUE);
                    }
                )
                    ->isEqualTo('string(15) "àâäéèêëîïôöùüŷÿ"' . PHP_EOL)
        ;
    }

    public function testDumpUnknown()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dumpUnknown('unknown type', 'unknown variable', $dump->createOutput());
                    }
                )
                    ->isEqualTo('unknown type "unknown type" : string(16) "unknown variable"' . PHP_EOL)
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
}
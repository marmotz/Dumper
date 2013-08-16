<?php

namespace tests\units\Marmotz\Dumper;

use atoum;
use Marmotz\Dumper\Dump        as TestedClass;
use mock\Marmotz\Dumper\Dump   as mockTestedClass;
use Marmotz\Dumper\Output;
use mock\Marmotz\Dumper\Output as mockOutput;
use Marmotz\Dumper\Proxy;


require_once __DIR__ . '/../../../resources/classes/SampleClass2.php';
require_once __DIR__ . '/../../../resources/classes/SampleClass3.php';
require_once __DIR__ . '/../../../resources/classes/SampleClass4.php';


class Dump extends atoum
{
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

    public function testConstruct()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->mock($dump)
                    ->call('reset')
                        ->once()
        ;
    }

    public function testObjectHash()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->array($dump->getObjectHashes())
                    ->isEmpty()
                ->object($dump->addObjectHash($hash = uniqid()))
                    ->isIdenticalTo($dump)
                ->array($dump->getObjectHashes())
                    ->isEqualTo(
                        array(
                            $hash
                        )
                    )
                ->boolean($dump->hasObjectHash($hash))
                    ->isTrue()
                ->boolean($dump->hasObjectHash(uniqid()))
                    ->isFalse()
        ;
    }

    public function testCreateOutput()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->object($dump->createOutput())
                    ->isInstanceOf('Marmotz\Dumper\Output')
        ;
    }

    public function testDumpArray()
    {
        $this
            ->if($dump = new mockTestedClass)
            ->and($array = array())
                ->output(
                    function() use($dump, $array) {
                        $dump->dump($array);
                    }
                )
                ->mock($dump)
                    ->call('doDumpArray')
                        ->once()
        ;
    }

    public function testDumpForDumpArray()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dump(array());
                    }
                )
                ->mock($dump)
                    ->call('dumpArray')
                        ->once()
                    ->call('reset')
                        ->twice()   // once on construct and once on dump
        ;
    }

    public function testDumpForDumpBoolean()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dump(true);
                    }
                )
                ->mock($dump)
                    ->call('dumpBoolean')
                        ->once()
                    ->call('reset')
                        ->twice()   // once on construct and once on dump
        ;
    }

    /**
     * @php >= 5.4
     */
    public function testDumpForDumpDouble()
    {
        $this
            ->if($dump = new mockTestedClass)
            ->and($this->function->gettype = 'double')
                ->output(
                    function() use($dump) {
                        $dump->dump(4.2);
                    }

)                ->mock($dump)
                    ->call('dumpDouble')
                        ->once()
                    ->call('dumpFloat')
                        ->once()
                    ->call('reset')
                        ->twice()   // once on construct and once on dump
        ;
    }

    public function testDumpForDumpInteger()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dump(42);
                    }
                )
                ->mock($dump)
                    ->call('dumpInteger')
                        ->once()
                    ->call('reset')
                        ->twice()   // once on construct and once on dump
        ;
    }

    public function testDumpForDumpMaxLevelOfRecursion()
    {
        $this
            ->if($dump = new mockTestedClass)
            ->and(
                $this->calling($dump)->doDumpObject = function(\Marmotz\Dumper\Proxy\ObjectProxy $object, \Marmotz\Dumper\Output $output) use($dump) {
                    foreach ($object->getProperties() as $property) {
                        $dump->dump($property['value'], $output);
                    }
                }
            )
            ->and(mockTestedClass::setMaxLevelOfRecursion(1))
                ->output(
                    function() use($dump) {
                        $dump->dump(new \SampleClass2);
                    }
                )
                ->mock($dump)
                    ->call('dumpMaxLevelOfRecursion')
                        ->once()
                    ->call('reset')
                        ->twice()   // once on construct and once on dump
        ;
    }

    public function testDumpForDumpNull()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dump(null);
                    }
                )
                ->mock($dump)
                    ->call('dumpNull')
                        ->once()
                    ->call('reset')
                        ->twice()   // once on construct and once on dump
        ;
    }

    public function testDumpForDumpObject()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dump(new \stdClass);
                    }
                )
                ->mock($dump)
                    ->call('dumpObject')
                        ->once()
                    ->call('reset')
                        ->twice()   // once on construct and once on dump
        ;
    }

    public function testDumpForDumpObjectAlreadyDumped()
    {
        $this
            ->if($dump = new mockTestedClass)
            ->and($mockOutput = new mockOutput($dump))
            ->and($this->calling($dump)->createOutput = $mockOutput)
            ->and(
                $this->calling($dump)->doDumpObject = function(\Marmotz\Dumper\Proxy\ObjectProxy $object, \Marmotz\Dumper\Output $output) use($dump) {
                    foreach ($object->getProperties() as $property) {
                        $dump->dump($property['value'], $output);
                    }
                }
            )
                ->output(
                    function() use($dump) {
                        $object1 = new \SampleClass3;
                        $object2 = new \SampleClass4;

                        $object1->property = $object2;
                        $object2->property = $object1;

                        $dump->dump($object1);
                    }
                )
                ->mock($mockOutput)
                    ->call('addLn')
                        ->withArguments('*OBJECT ALREADY DUMPED*')
                            ->once()
        ;
    }

    public function testDumpForDumpResource()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dump(fopen(__FILE__, 'r'));
                    }
                )
                ->mock($dump)
                    ->call('dumpResource')
                        ->once()
                    ->call('reset')
                        ->twice()   // once on construct and once on dump
        ;
    }

    /**
     * @extensions mbstring
     */
    public function testDumpForDumpStringWithMbString()
    {
        $this
            ->if($dump = new mockTestedClass)
            ->and($mockOutput = new mockOutput($dump))
            ->and($this->calling($dump)->createOutput = $mockOutput)
            ->and($string = 'foobaré')
            ->and($string = mb_convert_encoding($string, 'UTF-8', mb_detect_encoding($string)))
                ->output(
                    function() use($dump, $string) {
                        $dump->dump($string);
                    }
                )
                ->mock($dump)
                    ->call('dumpString')
                        ->once()
                    ->call('doDumpString')
                        ->withArguments($string, 7, $mockOutput, mockTestedClass::FORMAT_COMPLETE)
                            ->once()
                    ->call('reset')
                        ->twice()   // once on construct and once on dump
        ;
    }

    public function testDumpForDumpStringWithoutMbString()
    {
        $this
            ->if($dump = new mockTestedClass)
            ->and(
                $this->function->function_exists = function($function) {
                    return $function === 'mb_strlen' ? false : \function_exists($function);
                }
            )
                ->output(
                    function() use($dump) {
                        $dump->dump('foobar');
                    }
                )
                ->mock($dump)
                    ->call('dumpString')
                        ->once()
                    ->call('reset')
                        ->twice()   // once on construct and once on dump
        ;
    }

    /**
     * @php >= 5.4
     */
    public function testDumpForDumpUnknown()
    {
        $this
            ->if($dump = new mockTestedClass)
            ->and($this->function->gettype = uniqid())
                ->output(
                    function() use($dump) {
                        $dump->dump('unknown variable');
                    }
                )
                ->mock($dump)
                    ->call('dumpUnknown')
                        ->once()
                    ->call('reset')
                        ->twice()   // once on construct and once on dump
        ;
    }

    public function testDumpForFloat()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dump(4.2);
                    }
                )
                ->mock($dump)
                    ->call('dumpFloat')
                        ->once()
                    ->call('reset')
                        ->twice()   // once on construct and once on dump
        ;
    }

    public function testDumpObject()
    {
        $this
            ->if($dump = new mockTestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dump($dump);
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
            ->if($this->function->php_sapi_name = 'cli')
                ->object($dump = TestedClass::factory())
                    ->isInstanceOf('Marmotz\Dumper\CliDump')

            ->if($this->function->php_sapi_name = 'apache2')
                ->object($dump = TestedClass::factory())
                    ->isInstanceOf('Marmotz\Dumper\HtmlDump')

            ->if($this->function->php_sapi_name = \php_sapi_name())
                ->object($dump = TestedClass::factory('cli'))
                    ->isInstanceOf('Marmotz\Dumper\CliDump')
                ->object($dump = TestedClass::factory('apache2'))
                    ->isInstanceOf('Marmotz\Dumper\HtmlDump')
                ->object($dump = TestedClass::factory(uniqid()))
                    ->isInstanceOf('Marmotz\Dumper\HtmlDump')
        ;
    }

    public function testMaxLevelOfRecursion()
    {
        $this
            ->if($level = rand(1, 10))
                ->variable(TestedClass::setMaxLevelOfRecursion($level))
                    ->isNull()
                ->integer(TestedClass::getMaxLevelOfRecursion())
                    ->isEqualTo($level)
                ->boolean(TestedClass::isMaxLevelOfRecursion($level))
                    ->isFalse()
                ->boolean(TestedClass::isMaxLevelOfRecursion($level + 1))
                    ->isTrue()

            ->if($level = (string) rand(1, 10))
                ->variable(TestedClass::setMaxLevelOfRecursion($level))
                    ->isNull()
                ->integer(TestedClass::getMaxLevelOfRecursion())
                    ->isEqualTo((int) $level)
                ->boolean(TestedClass::isMaxLevelOfRecursion($level))
                    ->isFalse()
                ->boolean(TestedClass::isMaxLevelOfRecursion($level + 1))
                    ->isTrue()

            ->if($level = -1)
                ->variable(TestedClass::setMaxLevelOfRecursion($level))
                    ->isNull()
                ->boolean(TestedClass::getMaxLevelOfRecursion())
                    ->isFalse()
                ->boolean(TestedClass::isMaxLevelOfRecursion(rand(1, 100)))
                    ->isFalse()

            ->if($level = false)
                ->variable(TestedClass::setMaxLevelOfRecursion($level))
                    ->isNull()
                ->boolean(TestedClass::getMaxLevelOfRecursion())
                    ->isFalse()
                ->boolean(TestedClass::isMaxLevelOfRecursion(rand(1, 100)))
                    ->isFalse()

            ->if($level = true)
                ->variable(TestedClass::setMaxLevelOfRecursion($level))
                    ->isNull()
                ->boolean(TestedClass::getMaxLevelOfRecursion())
                    ->isFalse()
                ->boolean(TestedClass::isMaxLevelOfRecursion(rand(1, 100)))
                    ->isFalse()

            ->if($level = __METHOD__)
                ->variable(TestedClass::setMaxLevelOfRecursion($level))
                    ->isNull()
                ->boolean(TestedClass::getMaxLevelOfRecursion())
                    ->isFalse()
                ->boolean(TestedClass::isMaxLevelOfRecursion(rand(1, 100)))
                    ->isFalse()
        ;
    }

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

    public function testReset()
    {
        $this
            ->if($dump = new mockTestedClass)
            ->and($dump->setLevel(42))
            ->and($dump->addObjectHash(uniqid()))
                ->object($dump->reset())
                    ->isIdenticalTo($dump)
                ->integer($dump->getLevel())
                    ->isEqualTo(0)
                ->array($dump->getObjectHashes())
                    ->isEmpty()
        ;
    }
}
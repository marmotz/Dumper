<?php

namespace tests\units\Marmotz\Dumper;

use atoum;
use Marmotz\Dumper\CliDump as TestedClass;

require_once __DIR__ . '/../../resources/classes/SampleClass1.php';


class CliDump extends atoum
{
    public function testDumpArray()
    {
        $this
            ->if($dump = new TestedClass())
                ->output(
                    function() use($dump) {
                        $dump->dumpArray(array(), $dump->createOutput());
                    }
                )
                    ->isEqualTo(
                        'array(0)' . PHP_EOL
                    )
                ->output(
                    function() use($dump) {
                        $dump->dumpArray(array(1), $dump->createOutput());
                    }
                )
                    ->isEqualTo(
                        'array(1)' . PHP_EOL .
                        '| 0: integer(1)' . PHP_EOL
                    )
                ->output(
                    function() use($dump) {
                        $dump->dumpArray(array(1, 'key' => 42), $dump->createOutput());
                    }
                )
                    ->isEqualTo(
                        'array(2)' . PHP_EOL .
                        '|     0: integer(1)' . PHP_EOL .
                        '| "key": integer(42)' . PHP_EOL
                    )
                ->output(
                    function() use($dump) {
                        $dump->dumpArray(array(1, 'key' => 42, array('dump')), $dump->createOutput());
                    }
                )
                    ->isEqualTo(
                        'array(3)' . PHP_EOL .
                        '|     0: integer(1)' . PHP_EOL .
                        '| "key": integer(42)' . PHP_EOL .
                        '|     1: array(1)' . PHP_EOL .
                        '|        | 0: string(4) "dump"' . PHP_EOL
                    )
                ->output(
                    function() use($dump) {
                        $dump->dumpArray(array(1, 'key' => 42, array('dump', array('deep'))));
                    }
                )
                    ->isEqualTo(
                        'array(3)' . PHP_EOL .
                        '|     0: integer(1)' . PHP_EOL .
                        '| "key": integer(42)' . PHP_EOL .
                        '|     1: array(2)' . PHP_EOL .
                        '|        | 0: string(4) "dump"' . PHP_EOL .
                        '|        | 1: array(1)' . PHP_EOL .
                        '|        |    | 0: string(4) "deep"' . PHP_EOL
                    )
        ;
    }

    public function testDumpObject()
    {
        /*
        $this
            ->if($dump = new TestedClass())
                ->output(
                    function() use($dump) {
                        $dump->dumpObject(new \SampleClass1, $dump->createOutput());
                    }
                )
                    ->isEqualTo(
                        'object SampleClass1' . PHP_EOL .
                        '| extends SampleClass2' . PHP_EOL .
                        '| extends abstract SampleAbstract1' . PHP_EOL .
                        '| implements SampleInterface1' . PHP_EOL .
                        '| use trait SampleTrait1' . PHP_EOL .
                        '| Constants :' . PHP_EOL .
                        '|   CONST1   : string(6) "const1"' . PHP_EOL .
                        '|   CONSTANT2: string(9) "constant2"' . PHP_EOL .
                        '| Properties:' . PHP_EOL .
                        '|   private          $privatePropertyWithoutDefaultValue' . PHP_EOL .
                        '|     Current : string(9) "construct"' . PHP_EOL .
                        '|   protected        $protectedPropertyWithoutDefaultValue' . PHP_EOL .
                        '|     Current : string(9) "construct"' . PHP_EOL .
                        '|   public           $publicPropertyWithoutDefaultValue' . PHP_EOL .
                        '|     Current : string(9) "construct"' . PHP_EOL .
                        '|   private          $privatePropertyWithDefaultValue' . PHP_EOL .
                        '|     Default : string(7) "default"' . PHP_EOL .
                        '|     Current : string(9) "construct"' . PHP_EOL .
                        '|   protected        $protectedPropertyWithDefaultValue' . PHP_EOL .
                        '|     Default : string(7) "default"' . PHP_EOL .
                        '|     Current : string(9) "construct"' . PHP_EOL .
                        '|   public           $publicPropertyWithDefaultValue' . PHP_EOL .
                        '|     Default : string(7) "default"' . PHP_EOL .
                        '|     Current : object SampleClass2' . PHP_EOL .
                        '|               | extends abstract SampleAbstract1' . PHP_EOL .
                        '|               | implements SampleInterface1' . PHP_EOL .
                        '|   protected        $traitProperty' . PHP_EOL .
                        '|     Current : NULL' . PHP_EOL .
                        '|   private static   $staticPrivatePropertyWithoutDefaultValue' . PHP_EOL .
                        '|     Current : string(9) "construct"' . PHP_EOL .
                        '|   protected static $staticProtectedPropertyWithoutDefaultValue' . PHP_EOL .
                        '|     Current : string(9) "construct"' . PHP_EOL .
                        '|   public static    $staticPublicPropertyWithoutDefaultValue' . PHP_EOL .
                        '|     Current : string(9) "construct"' . PHP_EOL .
                        '|   private static   $staticPrivatePropertyWithDefaultValue' . PHP_EOL .
                        '|     Current : string(9) "construct"' . PHP_EOL .
                        '|   protected static $staticProtectedPropertyWithDefaultValue' . PHP_EOL .
                        '|     Current : string(9) "construct"' . PHP_EOL .
                        '|   public static    $staticPublicPropertyWithDefaultValue' . PHP_EOL .
                        '|     Current : string(9) "construct"' . PHP_EOL .
                        '| Methods :' . PHP_EOL .
                        '|   public    __construct()' . PHP_EOL .
                        '|   private   privateMethod($arg1, array &$arg2)' . PHP_EOL .
                        '|   protected protectedMethod($arg1, stdClass $arg2)' . PHP_EOL .
                        '|   public    publicMethod()' . PHP_EOL .
                        '|   public    traitMethod()' . PHP_EOL . PHP_EOL
                    )
        ;
        */
    }
}
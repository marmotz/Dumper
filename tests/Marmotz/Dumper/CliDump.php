<?php

namespace tests\units\Marmotz\Dumper;

use atoum;
use Marmotz\Dumper\CliDump as TestedClass;


class CliDump extends atoum
{
    public function testDumpArray()
    {
        $this
            ->if($dump = new TestedClass())
                ->output(
                    function() use($dump) {
                        $variable = array();
                        $dump->dump($variable);
                    }
                )
                    ->isEqualTo(
                        'array(0)' . PHP_EOL
                    )
                ->output(
                    function() use($dump) {
                        $variable = array(1);
                        $dump->dump($variable);
                    }
                )
                    ->isEqualTo(
                        'array(1)' . PHP_EOL .
                        '| 0: integer(1)' . PHP_EOL
                    )
                ->output(
                    function() use($dump) {
                        $variable = array(1, 'key' => 42);
                        $dump->dump($variable);
                    }
                )
                    ->isEqualTo(
                        'array(2)' . PHP_EOL .
                        '|     0: integer(1)' . PHP_EOL .
                        '| "key": integer(42)' . PHP_EOL
                    )
                ->output(
                    function() use($dump) {
                        $variable = array(1, 'key' => 42, array('dump'));
                        $dump->dump($variable);
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
                        $variable = array(1, 'key' => 42, array('dump', array('deep')));
                        $dump->dump($variable);
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
                ->output(
                    function() use($dump) {
                        $array = array(1, 2);
                        $array[] =& $array;

                        $dump->dump($array);
                    }
                )
                    ->isEqualTo(
                        'array(3)' . PHP_EOL .
                        '| 0: integer(1)' . PHP_EOL .
                        '| 1: integer(2)' . PHP_EOL .
                        '| 2: array(3)' . PHP_EOL .
                        '|    | 0: integer(1)' . PHP_EOL .
                        '|    | 1: integer(2)' . PHP_EOL .
                        '|    | 2: array(3)' . PHP_EOL .
                        '|    |    | 0: integer(1)' . PHP_EOL .
                        '|    |    | 1: integer(2)' . PHP_EOL .
                        '|    |    | 2: array(3)' . PHP_EOL .
                        '|    |    |    | 0: integer(1)' . PHP_EOL .
                        '|    |    |    | 1: integer(2)' . PHP_EOL .
                        '|    |    |    | 2: array(3)' . PHP_EOL .
                        '|    |    |    |    | 0: integer(1)' . PHP_EOL .
                        '|    |    |    |    | 1: integer(2)' . PHP_EOL .
                        '|    |    |    |    | 2: array(3)' . PHP_EOL .
                        '|    |    |    |    |    | 0: integer(1)' . PHP_EOL .
                        '|    |    |    |    |    | 1: integer(2)' . PHP_EOL .
                        '|    |    |    |    |    | 2: array(3)' . PHP_EOL .
                        '|    |    |    |    |    |    | 0: integer(1)' . PHP_EOL .
                        '|    |    |    |    |    |    | 1: integer(2)' . PHP_EOL .
                        '|    |    |    |    |    |    | 2: array(3)' . PHP_EOL .
                        '|    |    |    |    |    |    |    | 0: integer(1)' . PHP_EOL .
                        '|    |    |    |    |    |    |    | 1: integer(2)' . PHP_EOL .
                        '|    |    |    |    |    |    |    | 2: array(3)' . PHP_EOL .
                        '|    |    |    |    |    |    |    |    | 0: integer(1)' . PHP_EOL .
                        '|    |    |    |    |    |    |    |    | 1: integer(2)' . PHP_EOL .
                        '|    |    |    |    |    |    |    |    | 2: array(3)' . PHP_EOL .
                        '|    |    |    |    |    |    |    |    |    | 0: integer(1)' . PHP_EOL .
                        '|    |    |    |    |    |    |    |    |    | 1: integer(2)' . PHP_EOL .
                        '|    |    |    |    |    |    |    |    |    | 2: array *MAX LEVEL OF RECURSION*' . PHP_EOL
                    )
        ;
    }

    public function testDumpBoolean()
    {
        $this
            ->if($dump = new TestedClass)
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
            ->if($dump = new TestedClass)
                ->output(
                    function() use($dump) {
                        $variable = 1.2;
                        $dump->dump($variable);
                    }
                )
                    ->isEqualTo('float(1.2)' . PHP_EOL)
        ;
    }

    public function testDumpFloat()
    {
        $this
            ->if($dump = new TestedClass)
                ->output(
                    function() use($dump) {
                        $variable = 1.2;
                        $dump->dump($variable);
                    }
                )
                    ->isEqualTo('float(1.2)' . PHP_EOL)
        ;
    }

    public function testDumpInteger()
    {
        $this
            ->if($dump = new TestedClass)
                ->output(
                    function() use($dump) {
                        $variable = 42;
                        $dump->dump($variable, null, TestedClass::FORMAT_SHORT);
                    }
                )
                    ->isEqualTo('42')
                ->output(
                    function() use($dump) {
                        $variable = 42;
                        $dump->dump($variable, null, TestedClass::FORMAT_COMPLETE);
                    }
                )
                    ->isEqualTo('integer(42)' . PHP_EOL)
        ;
    }

    public function testDumpNull()
    {
        $this
            ->if($dump = new TestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dumpNull($dump->createOutput(), TestedClass::FORMAT_SHORT);
                    }
                )
                    ->isEqualTo('NULL')
                ->output(
                    function() use($dump) {
                        $dump->dumpNull($dump->createOutput(), TestedClass::FORMAT_COMPLETE);
                    }
                )
                    ->isEqualTo('NULL' . PHP_EOL)
        ;
    }

    /**
     * @php >= 5.4
     */
    public function testDumpObject()
    {
        require_once __DIR__ . '/../../../resources/classes/SampleClass1.php';
        require_once __DIR__ . '/../../../resources/classes/SampleClass3.php';
        require_once __DIR__ . '/../../../resources/classes/SampleClass4.php';

        $this
            ->if($dump = new TestedClass())
                ->output(
                    function() use($dump) {
                        $dump->dump(new \SampleClass1);
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
                        '| Properties :' . PHP_EOL .
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
                        '|   protected protectedMethod($arg1, stdClass $arg2, $arg3 = NULL, $arg4 = 42, $arg5 = "foobar")' . PHP_EOL .
                        '|   public    publicMethod()' . PHP_EOL .
                        '|   public    traitMethod()' . PHP_EOL
                    )

                ->output(
                    function() use($dump) {
                        $object1 = new \SampleClass3;
                        $object2 = new \SampleClass4;

                        $object1->object = $object2;
                        $object2->object = $object1;

                        $dump->dump($object1);
                    }
                )
                    ->isEqualTo(
                        'object SampleClass3' . PHP_EOL .
                        '| Properties :' . PHP_EOL .
                        '|   public $object' . PHP_EOL .
                        '|     Current : object SampleClass4' . PHP_EOL .
                        '|               | Properties :' . PHP_EOL .
                        '|               |   public $object' . PHP_EOL .
                        '|               |     Current : *OBJECT ALREADY DUMPED*' . PHP_EOL
                    )
        ;
    }

    public function testDumpResource()
    {
        $this
            ->if($dump = new TestedClass)
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
            ->if($dump = new TestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dumpString('azerty', $dump->createOutput(), TestedClass::FORMAT_SHORT);
                    }
                )
                    ->isEqualTo('"azerty"')
                ->output(
                    function() use($dump) {
                        $dump->dumpString('azerty', $dump->createOutput(), TestedClass::FORMAT_COMPLETE);
                    }
                )
                    ->isEqualTo('string(6) "azerty"' . PHP_EOL)
        ;
    }

    /** @extensions mbstring */
    public function testDumpStringIUtf8()
    {
        $this
            ->if($dump = new TestedClass)
            ->and($variable = 'àâäéèêëîïôöùüŷÿ')
            ->and($variable = mb_convert_encoding($variable, 'UTF-8', mb_detect_encoding($variable)))
                ->output(
                    function() use($dump, $variable) {
                        $dump->dumpString($variable, $dump->createOutput(), TestedClass::FORMAT_SHORT);
                    }
                )
                    ->isEqualTo('"àâäéèêëîïôöùüŷÿ"')
                ->output(
                    function() use($dump, $variable) {
                        $dump->dumpString($variable, $dump->createOutput(), TestedClass::FORMAT_COMPLETE);
                    }
                )
                    ->isEqualTo('string(15) "àâäéèêëîïôöùüŷÿ"' . PHP_EOL)
        ;
    }
}
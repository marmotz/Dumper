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
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/array.empty.cli'
                    )
                ->output(
                    function() use($dump) {
                        $variable = array(1);
                        $dump->dump($variable);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/array.1.cli'
                    )
                ->output(
                    function() use($dump) {
                        $variable = array(1, 'key' => 42);
                        $dump->dump($variable);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/array.1.key_42.cli'
                    )
                ->output(
                    function() use($dump) {
                        $variable = array(1, 'key' => 42, array('dump'));
                        $dump->dump($variable);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/array.1.key_42.array.dump.cli'
                    )

            ->if(TestedClass::setMaxLevelOfRecursion(3))
                ->output(
                    function() use($dump) {
                        $array = array(1, 2);
                        $array[] =& $array;

                        $dump->dump($array);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/array.recursive.cli'
                    )
        ;
    }

    public function testDumpBoolean()
    {
        $this
            ->if($dump = new TestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dump(true);
                    }
                )
                    ->isEqualTo('boolean(true)' . PHP_EOL)
                ->output(
                    function() use($dump) {
                        $dump->dump(false);
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

    public function testDumpObject()
    {
        if (version_compare(PHP_VERSION, '5.4', '>=')) {
            require_once __DIR__ . '/../../../resources/classes/SampleClass1.php';

            $this
                ->if($dump = new TestedClass())
                    ->output(
                        function() use($dump) {
                            $dump->dump(new \SampleClass1);
                        }
                    )
                        ->isEqualToContentsOfFile(
                            __DIR__ . '/../../../resources/dumps/cli/object.sampleclass1.cli'
                        )
            ;
        }

        require_once __DIR__ . '/../../../resources/classes/SampleClass2.php';

        $this
            ->if($dump = new TestedClass())
                ->output(
                    function() use($dump) {
                        $dump->dump(new \SampleClass2);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/object.sampleclass2.cli'
                    )
        ;

        require_once __DIR__ . '/../../../resources/classes/SampleClass3.php';
        require_once __DIR__ . '/../../../resources/classes/SampleClass4.php';

        $this
            ->output(
                function() use($dump) {
                    $object1 = new \SampleClass3;
                    $object2 = new \SampleClass4;

                    $object1->object = $object2;
                    $object2->object = $object1;

                    $dump->dump($object1);
                }
            )
                ->isEqualToContentsOfFile(
                    __DIR__ . '/../../../resources/dumps/cli/object.recursive.cli'
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

    /**
     * @php >= 5.4
     */
    public function testDumpUnknown()
    {
        $this
            ->if($dump = new TestedClass)
            ->and($this->function->gettype = $type = uniqid())
                ->output(
                    function() use($dump) {
                        $dump->dump('unknown variable');
                    }
                )
                    ->isEqualTo('unknown type "' . $type . '" : string(16) "unknown variable"' . PHP_EOL)
        ;
    }
}
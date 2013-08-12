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
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/boolean.true.cli'
                    )
                ->output(
                    function() use($dump) {
                        $dump->dump(false);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/boolean.false.cli'
                    )
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
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/float.1.2.cli'
                    )
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
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/float.1.2.cli'
                    )
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
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/integer.42.short.cli'
                    )
                ->output(
                    function() use($dump) {
                        $variable = 42;
                        $dump->dump($variable, null, TestedClass::FORMAT_COMPLETE);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/integer.42.complete.cli'
                    )
        ;
    }

    public function testDumpNull()
    {
        $this
            ->if($dump = new TestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dump(null, null, TestedClass::FORMAT_SHORT);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/null.short.cli'
                    )
                ->output(
                    function() use($dump) {
                        $dump->dump(null, null, TestedClass::FORMAT_COMPLETE);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/null.complete.cli'
                    )
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
                        $dump->dump(fopen(__FILE__, 'r'));
                    }
                )
                    ->match('|^' . file_get_contents(__DIR__ . '/../../../resources/dumps/cli/resource.file.cli') . '$|')
        ;
    }

    public function testDumpString()
    {
        $this
            ->if($dump = new TestedClass)
                ->output(
                    function() use($dump) {
                        $dump->dump('azerty', null, TestedClass::FORMAT_SHORT);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/string.azerty.short.cli'
                    )
                ->output(
                    function() use($dump) {
                        $dump->dump('azerty', null, TestedClass::FORMAT_COMPLETE);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/string.azerty.complete.cli'
                    )
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
                        $dump->dump($variable, null, TestedClass::FORMAT_SHORT);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/stringutf8.aaaeeeeiioouuyy.short.cli'
                    )
                ->output(
                    function() use($dump, $variable) {
                        $dump->dump($variable, null, TestedClass::FORMAT_COMPLETE);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/stringutf8.aaaeeeeiioouuyy.complete.cli'
                    )
        ;
    }

    /**
     * @php >= 5.4
     */
    public function testDumpUnknown()
    {
        $this
            ->if($dump = new TestedClass)
            ->and($this->function->gettype = 'unknown')
                ->output(
                    function() use($dump) {
                        $dump->dump('unknown variable');
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/cli/unknown.cli'
                    )
        ;
    }
}
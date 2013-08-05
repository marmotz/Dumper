<?php

namespace tests\units\Marmotz\Dumper;

use atoum;
use Marmotz\Dumper\HtmlDump as TestedClass;



class HtmlDump extends atoum
{
    public function testDumpArray()
    {
        $this
            ->if($dump = new TestedClass())
            ->and($dump->setCssWritten(true))   // disable css for tests
                ->output(
                    function() use($dump) {
                        $variable = array();
                        $dump->dump($variable);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/array.empty.html'
                    )

                ->output(
                    function() use($dump) {
                        $variable = array(1);
                        $dump->dump($variable);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/array.1.html'
                    )

                ->output(
                    function() use($dump) {
                        $variable = array(1, 'key' => 42);
                        $dump->dump($variable);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/array.1.key_42.html'
                    )

                ->output(
                    function() use($dump) {
                        $variable = array(1, 'key' => 42, array('dump'));
                        $dump->dump($variable);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/array.1.key_42.array.dump.html'
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
                        __DIR__ . '/../../../resources/dumps/html/array.recursive.html'
                    )
        ;
    }

    public function testDumpObject()
    {
        if (version_compare(PHP_VERSION, '5.4', '>=')) {
            require_once __DIR__ . '/../../../resources/classes/SampleClass1.php';

            $this
                ->if($dump = new TestedClass())
                ->and($dump->setCssWritten(true))   // disable css for tests
                    ->output(
                        function() use($dump) {
                            $dump->dump(new \SampleClass1);
                        }
                    )
                        ->isEqualToContentsOfFile(
                            __DIR__ . '/../../../resources/dumps/html/object.sampleclass1.html'
                        )
            ;
        }

        require_once __DIR__ . '/../../../resources/classes/SampleClass2.php';

        $this
            ->if($dump = new TestedClass())
            ->and($dump->setCssWritten(true))   // disable css for tests
                ->output(
                    function() use($dump) {
                        $dump->dump(new \SampleClass2);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/object.sampleclass2.html'
                    )
        ;
    }
}
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
            ->and($dump->setJsWritten(true))    // disable js for tests
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

    public function testDumpBoolean()
    {
        $this
            ->if($dump = new TestedClass)
            ->and($dump->setCssWritten(true))   // disable css for tests
            ->and($dump->setJsWritten(true))    // disable js for tests
                ->output(
                    function() use($dump) {
                        $dump->dump(true);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/boolean.true.html'
                    )
                ->output(
                    function() use($dump) {
                        $dump->dump(false);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/boolean.false.html'
                    )
        ;
    }

    public function testDumpDouble()
    {
        $this
            ->if($dump = new TestedClass)
            ->and($dump->setCssWritten(true))   // disable css for tests
            ->and($dump->setJsWritten(true))    // disable js for tests
                ->output(
                    function() use($dump) {
                        $variable = 1.2;
                        $dump->dump($variable);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/float.1.2.html'
                    )
        ;
    }

    public function testDumpFloat()
    {
        $this
            ->if($dump = new TestedClass)
            ->and($dump->setCssWritten(true))   // disable css for tests
            ->and($dump->setJsWritten(true))    // disable js for tests
                ->output(
                    function() use($dump) {
                        $variable = 1.2;
                        $dump->dump($variable);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/float.1.2.html'
                    )
        ;
    }

    public function testDumpInteger()
    {
        $this
            ->if($dump = new TestedClass)
            ->and($dump->setCssWritten(true))   // disable css for tests
            ->and($dump->setJsWritten(true))    // disable js for tests
                ->output(
                    function() use($dump) {
                        $variable = 42;
                        $dump->dump($variable, null, TestedClass::FORMAT_SHORT);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/integer.42.short.html'
                    )
                ->output(
                    function() use($dump) {
                        $variable = 42;
                        $dump->dump($variable, null, TestedClass::FORMAT_COMPLETE);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/integer.42.complete.html'
                    )
        ;
    }

    public function testDumpNull()
    {
        $this
            ->if($dump = new TestedClass)
            ->and($dump->setCssWritten(true))   // disable css for tests
            ->and($dump->setJsWritten(true))    // disable js for tests
                ->output(
                    function() use($dump) {
                        $dump->dump(null, null, TestedClass::FORMAT_SHORT);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/null.short.html'
                    )
                ->output(
                    function() use($dump) {
                        $dump->dump(null, null, TestedClass::FORMAT_COMPLETE);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/null.complete.html'
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
                ->and($dump->setJsWritten(true))    // disable js for tests
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
            ->and($dump->setJsWritten(true))    // disable js for tests
                ->output(
                    function() use($dump) {
                        $dump->dump(new \SampleClass2);
                    }
                )
                    ->isEqualToContentsOfFile(
                        version_compare(PHP_VERSION, '5.4.6', '>=')
                            ? __DIR__ . '/../../../resources/dumps/html/object.sampleclass2.withconstantname.html'
                            : __DIR__ . '/../../../resources/dumps/html/object.sampleclass2.withoutconstantname.html'
                    )
        ;
    }

    public function testDumpResource()
    {
        $this
            ->if($dump = new TestedClass)
            ->and($dump->setCssWritten(true))   // disable css for tests
            ->and($dump->setJsWritten(true))    // disable js for tests
                ->output(
                    function() use($dump) {
                        $dump->dump(fopen(__FILE__, 'r'));
                    }
                )
                    ->match('|^' . file_get_contents(__DIR__ . '/../../../resources/dumps/html/resource.file.html') . '$|')
        ;
    }

    public function testWriteCss()
    {
        $this
            ->if($dump = new TestedClass)
                ->output(
                    function() use($dump) {
                        $dump->writeCss($dump->createOutput());
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/css.html'
                    )
                ->output(
                    function() use($dump) {
                        $dump->writeCss($dump->createOutput());
                    }
                )
                    ->isEmpty()
        ;
    }

    public function testWriteJs()
    {
        $this
            ->if($dump = new TestedClass)
                ->output(
                    function() use($dump) {
                        $dump->writeJs($dump->createOutput());
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/js.html'
                    )
                ->output(
                    function() use($dump) {
                        $dump->writeJs($dump->createOutput());
                    }
                )
                    ->isEmpty()
        ;
    }

    public function testDumpString()
    {
        $this
            ->if($dump = new TestedClass)
            ->and($dump->setCssWritten(true))   // disable css for tests
            ->and($dump->setJsWritten(true))    // disable js for tests
                ->output(
                    function() use($dump) {
                        $dump->dump('azerty', null, TestedClass::FORMAT_SHORT);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/string.azerty.short.html'
                    )
                ->output(
                    function() use($dump) {
                        $dump->dump('azerty', null, TestedClass::FORMAT_COMPLETE);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/string.azerty.complete.html'
                    )
        ;
    }

    /** @extensions mbstring */
    public function testDumpStringUtf8()
    {
        $this
            ->if($dump = new TestedClass)
            ->and($dump->setCssWritten(true))   // disable css for tests
            ->and($dump->setJsWritten(true))    // disable js for tests
            ->and($variable = 'àâäéèêëîïôöùüŷÿ')
            ->and($variable = mb_convert_encoding($variable, 'UTF-8', mb_detect_encoding($variable)))
                ->output(
                    function() use($dump, $variable) {
                        $dump->dump($variable, null, TestedClass::FORMAT_SHORT);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/stringutf8.aaaeeeeiioouuyy.short.html'
                    )
                ->output(
                    function() use($dump, $variable) {
                        $dump->dump($variable, null, TestedClass::FORMAT_COMPLETE);
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/stringutf8.aaaeeeeiioouuyy.complete.html'
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
            ->and($dump->setCssWritten(true))   // disable css for tests
            ->and($dump->setJsWritten(true))    // disable js for tests
            ->and($this->function->gettype = 'unknown')
                ->output(
                    function() use($dump) {
                        $dump->dump('unknown variable');
                    }
                )
                    ->isEqualToContentsOfFile(
                        __DIR__ . '/../../../resources/dumps/html/unknown.html'
                    )
        ;
    }
}
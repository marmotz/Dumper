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

    /**
     * @php >= 5.4
     */
    public function testDumpObject()
    {
        require_once __DIR__ . '/../../../resources/classes/SampleClass1.php';

        $this
            ->if($dump = new TestedClass())
                ->output(
                    function() use($dump) {
                        $dump->dump(new \SampleClass1);
                    }
                )
                    ->isEqualTo(
                        '<div class="dumper">' . PHP_EOL .
                        '    <table class="object">' . PHP_EOL .
                        '        <thead>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th>object SampleClass1</th>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </thead>' . PHP_EOL .
                        '        <tbody class="classAttributes parent">' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>extends <span class="class">SampleClass2</span></td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>extends abstract <span class="class">SampleAbstract1</span></td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </tbody>' . PHP_EOL .
                        '        <tbody class="classAttributes interface">' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>implements <span class="class">SampleInterface1</span></td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </tbody>' . PHP_EOL .
                        '        <tbody class="classAttributes trait">' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>use trait <span class="class">SampleTrait1</span></td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </tbody>' . PHP_EOL .
                        '        <tbody class="constants">' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th>Constants :</th>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>' . PHP_EOL .
                        '                    <table>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td>CONST1</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(6) "const1"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td>CONSTANT2</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(9) "constant2"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                    </table>' . PHP_EOL .
                        '                </td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </tbody>' . PHP_EOL .
                        '        <tbody class="properties">' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th>Properties :</th>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>' . PHP_EOL .
                        '                    <table>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility">private</span> $privatePropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(9) "construct"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility">protected</span> $protectedPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(9) "construct"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility">public</span> $publicPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(9) "construct"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr class="default">' . PHP_EOL .
                        '                            <td rowspan="2"><span class="visibility">private</span> $privatePropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td>Default:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(7) "default"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(9) "construct"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr class="default">' . PHP_EOL .
                        '                            <td rowspan="2"><span class="visibility">protected</span> $protectedPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td>Default:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(7) "default"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(9) "construct"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr class="default">' . PHP_EOL .
                        '                            <td rowspan="2"><span class="visibility">public</span> $publicPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td>Default:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(7) "default"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <table class="object">' . PHP_EOL .
                        '                                    <thead>' . PHP_EOL .
                        '                                        <tr>' . PHP_EOL .
                        '                                            <th>object SampleClass3</th>' . PHP_EOL .
                        '                                        </tr>' . PHP_EOL .
                        '                                    </thead>' . PHP_EOL .
                        '                                    <tbody class="properties">' . PHP_EOL .
                        '                                        <tr>' . PHP_EOL .
                        '                                            <th>Properties :</th>' . PHP_EOL .
                        '                                        </tr>' . PHP_EOL .
                        '                                        <tr>' . PHP_EOL .
                        '                                            <td>' . PHP_EOL .
                        '                                                <table>' . PHP_EOL .
                        '                                                    <tr>' . PHP_EOL .
                        '                                                        <td><span class="visibility">public</span> $object</td>' . PHP_EOL .
                        '                                                        <td>Current:</td>' . PHP_EOL .
                        '                                                        <td>' . PHP_EOL .
                        '                                                            <table class="array">' . PHP_EOL .
                        '                                                                <thead>' . PHP_EOL .
                        '                                                                    <tr>' . PHP_EOL .
                        '                                                                        <th colspan="2">array(10)</th>' . PHP_EOL .
                        '                                                                    </tr>' . PHP_EOL .
                        '                                                                </thead>' . PHP_EOL .
                        '                                                                <tbody>' . PHP_EOL .
                        '                                                                    <tr>' . PHP_EOL .
                        '                                                                        <th>' . PHP_EOL .
                        '                                                                            0' . PHP_EOL .
                        '                                                                        </th>' . PHP_EOL .
                        '                                                                        <td>' . PHP_EOL .
                        '                                                                            integer(1)' . PHP_EOL .
                        '                                                                        </td>' . PHP_EOL .
                        '                                                                    </tr>' . PHP_EOL .
                        '                                                                    <tr>' . PHP_EOL .
                        '                                                                        <th>' . PHP_EOL .
                        '                                                                            1' . PHP_EOL .
                        '                                                                        </th>' . PHP_EOL .
                        '                                                                        <td>' . PHP_EOL .
                        '                                                                            integer(2)' . PHP_EOL .
                        '                                                                        </td>' . PHP_EOL .
                        '                                                                    </tr>' . PHP_EOL .
                        '                                                                    <tr>' . PHP_EOL .
                        '                                                                        <th>' . PHP_EOL .
                        '                                                                            2' . PHP_EOL .
                        '                                                                        </th>' . PHP_EOL .
                        '                                                                        <td>' . PHP_EOL .
                        '                                                                            integer(3)' . PHP_EOL .
                        '                                                                        </td>' . PHP_EOL .
                        '                                                                    </tr>' . PHP_EOL .
                        '                                                                    <tr>' . PHP_EOL .
                        '                                                                        <th>' . PHP_EOL .
                        '                                                                            3' . PHP_EOL .
                        '                                                                        </th>' . PHP_EOL .
                        '                                                                        <td>' . PHP_EOL .
                        '                                                                            integer(4)' . PHP_EOL .
                        '                                                                        </td>' . PHP_EOL .
                        '                                                                    </tr>' . PHP_EOL .
                        '                                                                    <tr>' . PHP_EOL .
                        '                                                                        <th>' . PHP_EOL .
                        '                                                                            4' . PHP_EOL .
                        '                                                                        </th>' . PHP_EOL .
                        '                                                                        <td>' . PHP_EOL .
                        '                                                                            integer(5)' . PHP_EOL .
                        '                                                                        </td>' . PHP_EOL .
                        '                                                                    </tr>' . PHP_EOL .
                        '                                                                    <tr>' . PHP_EOL .
                        '                                                                        <th>' . PHP_EOL .
                        '                                                                            5' . PHP_EOL .
                        '                                                                        </th>' . PHP_EOL .
                        '                                                                        <td>' . PHP_EOL .
                        '                                                                            integer(6)' . PHP_EOL .
                        '                                                                        </td>' . PHP_EOL .
                        '                                                                    </tr>' . PHP_EOL .
                        '                                                                    <tr>' . PHP_EOL .
                        '                                                                        <th>' . PHP_EOL .
                        '                                                                            6' . PHP_EOL .
                        '                                                                        </th>' . PHP_EOL .
                        '                                                                        <td>' . PHP_EOL .
                        '                                                                            integer(7)' . PHP_EOL .
                        '                                                                        </td>' . PHP_EOL .
                        '                                                                    </tr>' . PHP_EOL .
                        '                                                                    <tr>' . PHP_EOL .
                        '                                                                        <th>' . PHP_EOL .
                        '                                                                            7' . PHP_EOL .
                        '                                                                        </th>' . PHP_EOL .
                        '                                                                        <td>' . PHP_EOL .
                        '                                                                            integer(8)' . PHP_EOL .
                        '                                                                        </td>' . PHP_EOL .
                        '                                                                    </tr>' . PHP_EOL .
                        '                                                                    <tr>' . PHP_EOL .
                        '                                                                        <th>' . PHP_EOL .
                        '                                                                            8' . PHP_EOL .
                        '                                                                        </th>' . PHP_EOL .
                        '                                                                        <td>' . PHP_EOL .
                        '                                                                            integer(9)' . PHP_EOL .
                        '                                                                        </td>' . PHP_EOL .
                        '                                                                    </tr>' . PHP_EOL .
                        '                                                                    <tr>' . PHP_EOL .
                        '                                                                        <th>' . PHP_EOL .
                        '                                                                            9' . PHP_EOL .
                        '                                                                        </th>' . PHP_EOL .
                        '                                                                        <td>' . PHP_EOL .
                        '                                                                            integer(10)' . PHP_EOL .
                        '                                                                        </td>' . PHP_EOL .
                        '                                                                    </tr>' . PHP_EOL .
                        '                                                                </tbody>' . PHP_EOL .
                        '                                                            </table>' . PHP_EOL .
                        '                                                        </td>' . PHP_EOL .
                        '                                                    </tr>' . PHP_EOL .
                        '                                                </table>' . PHP_EOL .
                        '                                            </td>' . PHP_EOL .
                        '                                        </tr>' . PHP_EOL .
                        '                                    </tbody>' . PHP_EOL .
                        '                                </table>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility">protected</span> $traitProperty</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                NULL' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility"><span class="static">static</span> protected</span> $staticProtectedPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(9) "construct"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility"><span class="static">static</span> public</span> $staticPublicPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(9) "construct"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility"><span class="static">static</span> protected</span> $staticProtectedPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(9) "construct"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility"><span class="static">static</span> public</span> $staticPublicPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(9) "construct"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                    </table>' . PHP_EOL .
                        '                </td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </tbody>' . PHP_EOL .
                        '        <tbody class="methods">' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th>Methods :</th>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td><span class="visibility">public</span> __construct()</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td><span class="visibility">private</span> privateMethod(<span class="arguments"><span class="name">$arg1</span>, <span class="type">array</span> &<span class="name">$arg2</span></span>)</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td><span class="visibility">protected</span> protectedMethod(<span class="arguments"><span class="name">$arg1</span>, <span class="type">stdClass</span> <span class="name">$arg2</span>, <span class="name">$arg3</span> = <span class="value">NULL</span>, <span class="name">$arg4</span> = <span class="value">42</span>, <span class="name">$arg5</span> = <span class="value">"foobar"</span></span>)</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td><span class="visibility">public</span> publicMethod()</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td><span class="visibility">public</span> traitMethod()</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </tbody>' . PHP_EOL .
                        '    </table>' . PHP_EOL .
                        '</div>' . PHP_EOL .
                        $this->getCss()
                    )
        ;
    }
}
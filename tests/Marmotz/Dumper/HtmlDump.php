<?php

namespace tests\units\Marmotz\Dumper;

use atoum;
use Marmotz\Dumper\HtmlDump as TestedClass;

require_once __DIR__ . '/../../resources/classes/SampleClass1.php';


class HtmlDump extends atoum
{
    private function getCss()
    {
        return
            '<style type="text/css">' . PHP_EOL .
            '    .dumper, .dumper table {' . PHP_EOL .
            '        background-color: white;' . PHP_EOL .
            '        color: black;' . PHP_EOL .
            '        font-family: sans-serif;' . PHP_EOL .
            '        font-size: 12px;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table {' . PHP_EOL .
            '        border-spacing: 1px;' . PHP_EOL .
            '        background-color: white;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table tbody th {' . PHP_EOL .
            '        text-align: left;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table tbody td {' . PHP_EOL .
            '        background: #EEE;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper > table.array, .dumper > table.object {' . PHP_EOL .
            '        margin: 10px 0;' . PHP_EOL .
            '        box-shadow: 2px 2px 10px black;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.array, .dumper table.object {' . PHP_EOL .
            '        border: 1px solid black;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.array {' . PHP_EOL .
            '        border-color: #345678;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.array thead {' . PHP_EOL .
            '        background-color: #345678;' . PHP_EOL .
            '        color: white;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.array tbody > tr > th {' . PHP_EOL .
            '        background-color: #56789A;' . PHP_EOL .
            '        color: white;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object {' . PHP_EOL .
            '        border-color: #347856;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object thead {' . PHP_EOL .
            '        background-color: #347856;' . PHP_EOL .
            '        color: white;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object tbody > tr > th {' . PHP_EOL .
            '        background-color: #569A78;' . PHP_EOL .
            '        color: white;' . PHP_EOL .
            '    }' . PHP_EOL .
            '</style>' . PHP_EOL
        ;
    }

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
                        '<div class="dumper">' . PHP_EOL .
                        '    <table class="array">' . PHP_EOL .
                        '        <thead>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th colspan="2">array(0)</th>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </thead>' . PHP_EOL .
                        '    </table>' . PHP_EOL .
                        '</div>' . PHP_EOL .
                        $this->getCss()
                    )

                ->output(
                    function() use($dump) {
                        $variable = array(1);
                        $dump->dump($variable);
                    }
                )
                    ->isEqualTo(
                        '<div class="dumper">' . PHP_EOL .
                        '    <table class="array">' . PHP_EOL .
                        '        <thead>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th colspan="2">array(1)</th>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </thead>' . PHP_EOL .
                        '        <tbody>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th>' . PHP_EOL .
                        '                    <span class="integer">0</span>' . PHP_EOL .
                        '                </th>' . PHP_EOL .
                        '                <td>' . PHP_EOL .
                        '                    <span class="integer">integer(1)</span>' . PHP_EOL .
                        '                </td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </tbody>' . PHP_EOL .
                        '    </table>' . PHP_EOL .
                        '</div>' . PHP_EOL
                    )

                ->output(
                    function() use($dump) {
                        $variable = array(1, 'key' => 42);
                        $dump->dump($variable);
                    }
                )
                    ->isEqualTo(
                        '<div class="dumper">' . PHP_EOL .
                        '    <table class="array">' . PHP_EOL .
                        '        <thead>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th colspan="2">array(2)</th>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </thead>' . PHP_EOL .
                        '        <tbody>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th>' . PHP_EOL .
                        '                    <span class="integer">0</span>' . PHP_EOL .
                        '                </th>' . PHP_EOL .
                        '                <td>' . PHP_EOL .
                        '                    <span class="integer">integer(1)</span>' . PHP_EOL .
                        '                </td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th>' . PHP_EOL .
                        '                    <span class="string">"key"</span>' . PHP_EOL .
                        '                </th>' . PHP_EOL .
                        '                <td>' . PHP_EOL .
                        '                    <span class="integer">integer(42)</span>' . PHP_EOL .
                        '                </td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </tbody>' . PHP_EOL .
                        '    </table>' . PHP_EOL .
                        '</div>' . PHP_EOL
                    )

                ->output(
                    function() use($dump) {
                        $variable = array(1, 'key' => 42, array('dump'));
                        $dump->dump($variable);
                    }
                )
                    ->isEqualTo(
                        '<div class="dumper">' . PHP_EOL .
                        '    <table class="array">' . PHP_EOL .
                        '        <thead>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th colspan="2">array(3)</th>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </thead>' . PHP_EOL .
                        '        <tbody>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th>' . PHP_EOL .
                        '                    <span class="integer">0</span>' . PHP_EOL .
                        '                </th>' . PHP_EOL .
                        '                <td>' . PHP_EOL .
                        '                    <span class="integer">integer(1)</span>' . PHP_EOL .
                        '                </td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th>' . PHP_EOL .
                        '                    <span class="string">"key"</span>' . PHP_EOL .
                        '                </th>' . PHP_EOL .
                        '                <td>' . PHP_EOL .
                        '                    <span class="integer">integer(42)</span>' . PHP_EOL .
                        '                </td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th>' . PHP_EOL .
                        '                    <span class="integer">1</span>' . PHP_EOL .
                        '                </th>' . PHP_EOL .
                        '                <td>' . PHP_EOL .
                        '                    <table class="array">' . PHP_EOL .
                        '                        <thead>' . PHP_EOL .
                        '                            <tr>' . PHP_EOL .
                        '                                <th colspan="2">array(1)</th>' . PHP_EOL .
                        '                            </tr>' . PHP_EOL .
                        '                        </thead>' . PHP_EOL .
                        '                        <tbody>' . PHP_EOL .
                        '                            <tr>' . PHP_EOL .
                        '                                <th>' . PHP_EOL .
                        '                                    <span class="integer">0</span>' . PHP_EOL .
                        '                                </th>' . PHP_EOL .
                        '                                <td>' . PHP_EOL .
                        '                                    <span class="string">string(4) "dump"</span>' . PHP_EOL .
                        '                                </td>' . PHP_EOL .
                        '                            </tr>' . PHP_EOL .
                        '                        </tbody>' . PHP_EOL .
                        '                    </table>' . PHP_EOL .
                        '                </td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </tbody>' . PHP_EOL .
                        '    </table>' . PHP_EOL .
                        '</div>' . PHP_EOL
                    )
        ;
    }

    public function testDumpObject()
    {
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
                        '                <td>extends SampleClass2</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>extends abstract SampleAbstract1</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </tbody>' . PHP_EOL .
                        '        <tbody class="classAttributes interface">' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>implements SampleInterface1</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </tbody>' . PHP_EOL .
                        '        <tbody class="classAttributes trait">' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>use trait SampleTrait1</td>' . PHP_EOL .
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
                        '                            <td class="name">CONST1</td>' . PHP_EOL .
                        '                            <td class="value">' . PHP_EOL .
                        '                                <span class="string">string(6) "const1"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name">CONSTANT2</td>' . PHP_EOL .
                        '                            <td class="value">' . PHP_EOL .
                        '                                <span class="string">string(9) "constant2"</span>' . PHP_EOL .
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
                        '                            <td class="name">private $privatePropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name">protected $protectedPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name">public $publicPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name" rowspan="2">private $privatePropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td class="type">Default:</td>' . PHP_EOL .
                        '                            <td class="value default">' . PHP_EOL .
                        '                                <span class="string">string(7) "default"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name" rowspan="2">protected $protectedPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td class="type">Default:</td>' . PHP_EOL .
                        '                            <td class="value default">' . PHP_EOL .
                        '                                <span class="string">string(7) "default"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name" rowspan="2">public $publicPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td class="type">Default:</td>' . PHP_EOL .
                        '                            <td class="value default">' . PHP_EOL .
                        '                                <span class="string">string(7) "default"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <table class="object">' . PHP_EOL .
                        '                                    <thead>' . PHP_EOL .
                        '                                        <tr>' . PHP_EOL .
                        '                                            <th>object SampleClass2</th>' . PHP_EOL .
                        '                                        </tr>' . PHP_EOL .
                        '                                    </thead>' . PHP_EOL .
                        '                                    <tbody class="classAttributes parent">' . PHP_EOL .
                        '                                        <tr>' . PHP_EOL .
                        '                                            <td>extends abstract SampleAbstract1</td>' . PHP_EOL .
                        '                                        </tr>' . PHP_EOL .
                        '                                    </tbody>' . PHP_EOL .
                        '                                    <tbody class="classAttributes interface">' . PHP_EOL .
                        '                                        <tr>' . PHP_EOL .
                        '                                            <td>implements SampleInterface1</td>' . PHP_EOL .
                        '                                        </tr>' . PHP_EOL .
                        '                                    </tbody>' . PHP_EOL .
                        '                                </table>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name">protected $traitProperty</td>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <span class="null">NULL</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name">static private $staticPrivatePropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name">static protected $staticProtectedPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name">static public $staticPublicPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name">static private $staticPrivatePropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name">static protected $staticProtectedPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td class="name">static public $staticPublicPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td class="type">Current:</td>' . PHP_EOL .
                        '                            <td class="value current">' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
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
                        '                <td>public __construct()</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>private privateMethod($arg1, array &$arg2)</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>protected protectedMethod($arg1, stdClass $arg2, $arg3 = <span class="null">NULL</span>, $arg4 = <span class="integer">42</span>, $arg5 = <span class="string">"foobar"</span>)</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>public publicMethod()</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td>public traitMethod()</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '        </tbody>' . PHP_EOL .
                        '    </table>' . PHP_EOL .
                        '</div>' . PHP_EOL .
                        $this->getCss()
                    )
        ;
    }
}
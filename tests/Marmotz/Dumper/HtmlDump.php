<?php

namespace tests\units\Marmotz\Dumper;

use atoum;
use Marmotz\Dumper\HtmlDump as TestedClass;

require_once __DIR__ . '/../../resources/classes/SampleClass1.php';


class HtmlDump extends atoum
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
                        '<table class="dumper array">' . PHP_EOL .
                        '    <thead>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th colspan="2">array(0)</th>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </thead>' . PHP_EOL .
                        '</table>' . PHP_EOL
                    )
                ->output(
                    function() use($dump) {
                        $dump->dumpArray(array(1), $dump->createOutput());
                    }
                )
                    ->isEqualTo(
                        '<table class="dumper array">' . PHP_EOL .
                        '    <thead>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th colspan="2">array(1)</th>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </thead>' . PHP_EOL .
                        '    <tbody>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>0</th>' . PHP_EOL .
                        '            <td>' . PHP_EOL .
                        '                integer(1)' . PHP_EOL .
                        '            </td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '</table>' . PHP_EOL
                    )
                ->output(
                    function() use($dump) {
                        $dump->dumpArray(array(1, 'key' => 42), $dump->createOutput());
                    }
                )
                    ->isEqualTo(
                        '<table class="dumper array">' . PHP_EOL .
                        '    <thead>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th colspan="2">array(2)</th>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </thead>' . PHP_EOL .
                        '    <tbody>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>0</th>' . PHP_EOL .
                        '            <td>' . PHP_EOL .
                        '                integer(1)' . PHP_EOL .
                        '            </td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>"key"</th>' . PHP_EOL .
                        '            <td>' . PHP_EOL .
                        '                integer(42)' . PHP_EOL .
                        '            </td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '</table>' . PHP_EOL
                    )
                ->output(
                    function() use($dump) {
                        $dump->dumpArray(array(1, 'key' => 42, array('dump')), $dump->createOutput());
                    }
                )
                    ->isEqualTo(
                        '<table class="dumper array">' . PHP_EOL .
                        '    <thead>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th colspan="2">array(3)</th>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </thead>' . PHP_EOL .
                        '    <tbody>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>0</th>' . PHP_EOL .
                        '            <td>' . PHP_EOL .
                        '                integer(1)' . PHP_EOL .
                        '            </td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>"key"</th>' . PHP_EOL .
                        '            <td>' . PHP_EOL .
                        '                integer(42)' . PHP_EOL .
                        '            </td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>1</th>' . PHP_EOL .
                        '            <td>' . PHP_EOL .
                        '                <table class="dumper array">' . PHP_EOL .
                        '                    <thead>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <th colspan="2">array(1)</th>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                    </thead>' . PHP_EOL .
                        '                    <tbody>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <th>0</th>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                string(4) "dump"' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                    </tbody>' . PHP_EOL .
                        '                </table>' . PHP_EOL .
                        '            </td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '</table>' . PHP_EOL
                    )
        ;
    }

    public function testDumpObject()
    {
        $this
            ->if($dump = new TestedClass())
                ->output(
                    function() use($dump) {
                        $dump->dumpObject(new \SampleClass1, $dump->createOutput());
                    }
                )
                    ->isEqualTo(
                        '<table class="dumper object">' . PHP_EOL .
                        '    <thead>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>object SampleClass1</th>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </thead>' . PHP_EOL .
                        '    <tbody class="classAttributes parent">' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td>extends SampleClass2</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td>extends abstract SampleAbstract1</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '    <tbody class="classAttributes interface">' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td>implements SampleInterface1</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '    <tbody class="classAttributes trait">' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td>use trait SampleTrait1</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '    <tbody class="constants">' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>Constants :</th>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td>' . PHP_EOL .
                        '                <table>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name">CONST1</td>' . PHP_EOL .
                        '                        <td class="value">' . PHP_EOL .
                        '                            string(6) "const1"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name">CONSTANT2</td>' . PHP_EOL .
                        '                        <td class="value">' . PHP_EOL .
                        '                            string(9) "constant2"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                </table>' . PHP_EOL .
                        '            </td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '    <tbody class="properties">' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>Properties :</th>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td>' . PHP_EOL .
                        '                <table>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name">private $privatePropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            string(9) "construct"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name">protected $protectedPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            string(9) "construct"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name">public $publicPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            string(9) "construct"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name" rowspan="2">private $privatePropertyWithDefaultValue</td>' . PHP_EOL .
                        '                        <td class="type">Default:</td>' . PHP_EOL .
                        '                        <td class="value default">' . PHP_EOL .
                        '                            string(7) "default"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            string(9) "construct"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name" rowspan="2">protected $protectedPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                        <td class="type">Default:</td>' . PHP_EOL .
                        '                        <td class="value default">' . PHP_EOL .
                        '                            string(7) "default"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            string(9) "construct"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name" rowspan="2">public $publicPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                        <td class="type">Default:</td>' . PHP_EOL .
                        '                        <td class="value default">' . PHP_EOL .
                        '                            string(7) "default"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            <table class="dumper object">' . PHP_EOL .
                        '                                <thead>' . PHP_EOL .
                        '                                    <tr>' . PHP_EOL .
                        '                                        <th>object SampleClass2</th>' . PHP_EOL .
                        '                                    </tr>' . PHP_EOL .
                        '                                </thead>' . PHP_EOL .
                        '                                <tbody class="classAttributes parent">' . PHP_EOL .
                        '                                    <tr>' . PHP_EOL .
                        '                                        <td>extends abstract SampleAbstract1</td>' . PHP_EOL .
                        '                                    </tr>' . PHP_EOL .
                        '                                </tbody>' . PHP_EOL .
                        '                                <tbody class="classAttributes interface">' . PHP_EOL .
                        '                                    <tr>' . PHP_EOL .
                        '                                        <td>implements SampleInterface1</td>' . PHP_EOL .
                        '                                    </tr>' . PHP_EOL .
                        '                                </tbody>' . PHP_EOL .
                        '                            </table>' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name">protected $traitProperty</td>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            NULL' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name">static private $staticPrivatePropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            string(9) "construct"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name">static protected $staticProtectedPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            string(9) "construct"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name">static public $staticPublicPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            string(9) "construct"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name">static private $staticPrivatePropertyWithDefaultValue</td>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            string(9) "construct"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name">static protected $staticProtectedPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            string(9) "construct"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                    <tr>' . PHP_EOL .
                        '                        <td class="name">static public $staticPublicPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                        <td class="type">Current:</td>' . PHP_EOL .
                        '                        <td class="value current">' . PHP_EOL .
                        '                            string(9) "construct"' . PHP_EOL .
                        '                        </td>' . PHP_EOL .
                        '                    </tr>' . PHP_EOL .
                        '                </table>' . PHP_EOL .
                        '            </td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '    <tbody class="methods">' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>Methods :</th>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td>public __construct()</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td>private privateMethod($arg1, array &$arg2)</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td>protected protectedMethod($arg1, stdClass $arg2)</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td>public publicMethod()</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td>public traitMethod()</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '</table>' . PHP_EOL
                    )
        ;
    }
}
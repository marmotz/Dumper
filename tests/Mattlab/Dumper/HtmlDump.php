<?php

namespace tests\units\Mattlab\Dumper;

use atoum;
use Mattlab\Dumper\HtmlDump as TestedClass;

require_once __DIR__ . '/../../resources/classes/SampleClass1.php';


class HtmlDump extends atoum
{
    public function testDumpArray()
    {
        $this
            ->if($dump = new TestedClass())
                ->string($dump->dumpArray(array()))
                    ->isEqualTo(
                        '<table class="dumper array">' . PHP_EOL .
                        '    <thead>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th colspan="2">array(0)</th>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </thead>' . PHP_EOL .
                        '</table>' . PHP_EOL . PHP_EOL
                    )
                ->string($dump->dumpArray(array(1)))
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
                        '            <td>integer(1)</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '</table>' . PHP_EOL . PHP_EOL
                    )
                ->string($dump->dumpArray(array(1, 'key' => 42)))
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
                        '            <td>integer(1)</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>"key"</th>' . PHP_EOL .
                        '            <td>integer(42)</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '</table>' . PHP_EOL . PHP_EOL
                    )
                ->string($d = $dump->dumpArray(array(1, 'key' => 42, array('dump'))))
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
                        '            <td>integer(1)</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>"key"</th>' . PHP_EOL .
                        '            <td>integer(42)</td>' . PHP_EOL .
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
                        '                            <td>string(4) "dump"</td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                    </tbody>' . PHP_EOL .
                        '                </table>' . PHP_EOL .
                        '            </td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '</table>' . PHP_EOL . PHP_EOL
                    )
        ;
    }

    public function testDumpObject()
    {
        $this
            ->if($dump = new TestedClass())
                ->string($dump->dumpObject(new \SampleClass1))
                    ->isEqualTo(
                        '<table class="dumper object">' . PHP_EOL .
                        '    <thead>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th colspan="3">object SampleClass1<th>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </thead>' . PHP_EOL .
                        '    <tbody class="classAttributes parent">' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td colspan="3">extends SampleClass2<td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td colspan="3">extends abstract SampleAbstract1<td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '    <tbody class="classAttributes interface">' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td colspan="3">implements SampleInterface1<td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '    <tbody class="classAttributes trait">' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td colspan="3" class="trait">use trait SampleTrait1<td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '    <tbody class="constants">' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name">CONST1</td>' . PHP_EOL .
                        '            <td class="value">string(6) "const1"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name">CONSTANT2</td>' . PHP_EOL .
                        '            <td class="value">string(9) "constant2"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '    <tbody class="properties">' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name">private $privatePropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">string(9) "construct"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name">protected $protectedPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">string(9) "construct"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name">public $publicPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">string(9) "construct"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name" rowspan="2">private $privatePropertyWithDefaultValue</td>' . PHP_EOL .
                        '            <td class="type">Default:</td>' . PHP_EOL .
                        '            <td class="value default">string(7) "default"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">string(9) "construct"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name" rowspan="2">protected $protectedPropertyWithDefaultValue</td>' . PHP_EOL .
                        '            <td class="type">Default:</td>' . PHP_EOL .
                        '            <td class="value default">string(7) "default"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">string(9) "construct"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name" rowspan="2">public $publicPropertyWithDefaultValue</td>' . PHP_EOL .
                        '            <td class="type">Default:</td>' . PHP_EOL .
                        '            <td class="value default">string(7) "default"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">' . PHP_EOL .
                        '                <table class="dumper object">' . PHP_EOL .
                        '                    <thead>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <th colspan="3">object SampleClass2<th>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                    </thead>' . PHP_EOL .
                        '                    <tbody class="classAttributes parent">' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td colspan="3">extends abstract SampleAbstract1<td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                    </tbody>' . PHP_EOL .
                        '                    <tbody class="classAttributes interface">' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td colspan="3">implements SampleInterface1<td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                    </tbody>' . PHP_EOL .
                        '                </table>' . PHP_EOL .
                        '            </td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name">protected $traitProperty</td>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">NULL</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name">static private $staticPrivatePropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">string(9) "construct"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name">static protected $staticProtectedPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">string(9) "construct"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name">static public $staticPublicPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">string(9) "construct"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name">static private $staticPrivatePropertyWithDefaultValue</td>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">string(9) "construct"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name">static protected $staticProtectedPropertyWithDefaultValue</td>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">string(9) "construct"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td class="name">static public $staticPublicPropertyWithDefaultValue</td>' . PHP_EOL .
                        '            <td class="type">Current:</td>' . PHP_EOL .
                        '            <td class="value current">string(9) "construct"</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '    <tbody class="methods">' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td colspan="3">public __construct()</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td colspan="3">private privateMethod($arg1, array &$arg2)</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td colspan="3">protected protectedMethod($arg1, stdClass $arg2)</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td colspan="3">public publicMethod()</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <td colspan="3">public traitMethod()</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '</table>' . PHP_EOL . PHP_EOL
                    )
        ;
    }
}
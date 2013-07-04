<?php

namespace tests\units\Mattlab\Dumper;

use atoum;
use Mattlab\Dumper\HtmlDump as TestedClass;


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
                        '            <th>array(0)</th>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </thead>' . PHP_EOL .
                        '</table>' . PHP_EOL
                    )
                ->string($dump->dumpArray(array(1)))
                    ->isEqualTo(
                        '<table class="dumper array">' . PHP_EOL .
                        '    <thead>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>array(1)</th>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </thead>' . PHP_EOL .
                        '    <tbody>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>0</th>' . PHP_EOL .
                        '            <td>integer(1)</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '</table>' . PHP_EOL
                    )
                ->string($dump->dumpArray(array(1, 'key' => 42)))
                    ->isEqualTo(
                        '<table class="dumper array">' . PHP_EOL .
                        '    <thead>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>array(2)</th>' . PHP_EOL .
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
                        '</table>' . PHP_EOL
                    )
                ->string($d = $dump->dumpArray(array(1, 'key' => 42, array('dump'))))
                    ->isEqualTo(
                        '<table class="dumper array">' . PHP_EOL .
                        '    <thead>' . PHP_EOL .
                        '        <tr>' . PHP_EOL .
                        '            <th>array(3)</th>' . PHP_EOL .
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
                        '            <td>' .
                                        '<table class="dumper array">' . PHP_EOL .
                                        '    <thead>' . PHP_EOL .
                                        '        <tr>' . PHP_EOL .
                                        '            <th>array(1)</th>' . PHP_EOL .
                                        '        </tr>' . PHP_EOL .
                                        '    </thead>' . PHP_EOL .
                                        '    <tbody>' . PHP_EOL .
                                        '        <tr>' . PHP_EOL .
                                        '            <th>0</th>' . PHP_EOL .
                                        '            <td>string(4) "dump"</td>' . PHP_EOL .
                                        '        </tr>' . PHP_EOL .
                                        '    </tbody>' . PHP_EOL .
                                        '</table>' . PHP_EOL .
                                    '</td>' . PHP_EOL .
                        '        </tr>' . PHP_EOL .
                        '    </tbody>' . PHP_EOL .
                        '</table>' . PHP_EOL
                    )
        ;
    }

    public function testPrepareArray()
    {
        $this
            ->if($dump = new TestedClass())
                ->array(
                    $dump->prepareArray(
                        array(
                            1,
                            'key' => 42,
                            array('dump')
                        )
                    )
                )
                    ->isIdenticalTo(
                        array(
                            $dump->dump(0,     TestedClass::FORMAT_KEY) => $dump->dump(1),
                            $dump->dump('key', TestedClass::FORMAT_KEY) => $dump->dump(42),
                            $dump->dump(1,     TestedClass::FORMAT_KEY) => $dump->dump(array('dump')),
                        )
                    )
        ;
    }

}
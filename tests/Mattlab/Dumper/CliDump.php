<?php

namespace tests\units\Mattlab\Dumper;

use atoum;
use Mattlab\Dumper\CliDump as TestedClass;


class CliDump extends atoum
{
    public function testDumpArray()
    {
        $this
            ->if($dump = new TestedClass())
                ->string($dump->dumpArray(array()))
                    ->isEqualTo(
                        'array(0)' . PHP_EOL
                    )
                ->string($dump->dumpArray(array(1)))
                    ->isEqualTo(
                        'array(1)' . PHP_EOL .
                        '0: integer(1)' . PHP_EOL
                    )
                ->string($dump->dumpArray(array(1, 'key' => 42)))
                    ->isEqualTo(
                        'array(2)' . PHP_EOL .
                        '    0: integer(1)' . PHP_EOL .
                        '"key": integer(42)' . PHP_EOL
                    )
                ->string($d = $dump->dumpArray(array(1, 'key' => 42, array('dump'))))
                    ->isEqualTo(
                        'array(3)' . PHP_EOL .
                        '    0: integer(1)' . PHP_EOL .
                        '"key": integer(42)' . PHP_EOL .
                        '    1: array(1)' . PHP_EOL .
                        '       0: string(4) "dump"' . PHP_EOL
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
<?php

namespace tests\units\Mattlab\Dumper;

use atoum;
use Mattlab\Dumper\CliDump as TestedClass;

require_once __DIR__ . '/../../resources/classes/SampleClass1.php';


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
                        '| 0: integer(1)' . PHP_EOL
                    )
                ->string($dump->dumpArray(array(1, 'key' => 42)))
                    ->isEqualTo(
                        'array(2)' . PHP_EOL .
                        '|     0: integer(1)' . PHP_EOL .
                        '| "key": integer(42)' . PHP_EOL
                    )
                ->string($d = $dump->dumpArray(array(1, 'key' => 42, array('dump'))))
                    ->isEqualTo(
                        'array(3)' . PHP_EOL .
                        '|     0: integer(1)' . PHP_EOL .
                        '| "key": integer(42)' . PHP_EOL .
                        '|     1: array(1)' . PHP_EOL .
                        '|        | 0: string(4) "dump"' . PHP_EOL
                    )
                ->string($d = $dump->dumpArray(array(1, 'key' => 42, array('dump', array('deep')))))
                    ->isEqualTo(
                        'array(3)' . PHP_EOL .
                        '|     0: integer(1)' . PHP_EOL .
                        '| "key": integer(42)' . PHP_EOL .
                        '|     1: array(2)' . PHP_EOL .
                        '|        | 0: string(4) "dump"' . PHP_EOL .
                        '|        | 1: array(1)' . PHP_EOL .
                        '|        |    | 0: string(4) "deep"' . PHP_EOL
                    )
        ;
    }

    public function testDumpObject()
    {
        $this
            ->if($dump = new TestedClass())
                ->string($dump->dumpObject(new \SampleClass1))
        ;
    }
}
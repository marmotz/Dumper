<?php

namespace tests\units\Mattlab\Dumper\Proxy;

use atoum;
use Mattlab\Dumper\Proxy\ArrayProxy as TestedClass;

use Mattlab\Dumper\CliDump;
use Mattlab\Dumper\HtmlDump;
use Mattlab\Dumper\Dump;
use mock\Mattlab\Dumper\Dump as mockDump;


class ArrayProxy extends atoum
{
    public function testProxy($array, $withMock)
    {
        if ($withMock) {
            $dumpers = array(
                new mockDump
            );
        } else {
            $dumpers = array(
                new CliDump,
                new HtmlDump,
            );
        }

        foreach ($dumpers as $key => $dumper) {
            $maxLength = 0;
            $count     = 0;

            reset($array);

            $this
                ->object($proxy = new TestedClass($dumper, $array))
                    ->foreach(
                        $proxy,
                        function($assert, $value, $key) use($dumper, &$maxLength, &$array, &$count) {
                            $assert
                                ->variable($key)
                                    ->isEqualTo($dumper->dump(key($array), Dump::FORMAT_KEY))
                                ->string($value)
                                    ->isEqualTo($dumper->dump(current($array)))
                            ;

                            $maxLength = max($maxLength, strlen($key));
                            $count++;
                            next($array);
                        }
                    )
                ->integer($proxy->getMaxLengthKey())
                    ->isEqualTo($maxLength)
                ->integer($proxy->size())
                    ->isEqualTo($count)
            ;
        }
    }


    protected function testProxyDataProvider()
    {
        return array(
            array(
                array(1),
                true
            ),
            array(
                array(1, 'key' => 42),
                true
            ),
            array(
                array(1, 'key' => 42, array('dump')),
                false
            ),
        );
    }
}
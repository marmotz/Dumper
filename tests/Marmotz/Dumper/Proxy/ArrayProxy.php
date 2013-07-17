<?php

namespace tests\units\Marmotz\Dumper\Proxy;

use atoum;
use Marmotz\Dumper\Proxy\ArrayProxy as TestedClass;

use Marmotz\Dumper\CliDump;
use Marmotz\Dumper\HtmlDump;
use Marmotz\Dumper\Dump;
use mock\Marmotz\Dumper\Dump as mockDump;


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
                                    ->isEqualTo($dumper->getDump(key($array), null, Dump::FORMAT_KEY))
                                ->variable($value)
                                    ->isEqualTo(current($array))
                            ;

                            $maxLength = max($maxLength, strlen($key));
                            $count++;
                            next($array);
                        }
                    )
                ->integer($proxy->getMaxKeyLength())
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
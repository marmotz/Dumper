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
    public function testProxy(array $array, $withMock)
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
            $maxLength   = 0;
            $count       = 0;
            $arrayKeys   = array_keys($array);
            $arrayValues = array_values($array);

            $this
                ->object($proxy = new TestedClass($array, $dumper))
                    ->foreach(
                        $proxy,
                        function($assert, $value, $key) use($dumper, &$maxLength, $arrayKeys, $arrayValues, &$count) {

                            $assert
                                ->variable($key)
                                    ->isEqualTo($dumper->getDump($arrayKeys[$count], null, Dump::FORMAT_KEY))
                                ->variable($value)
                                    ->isEqualTo($arrayValues[$count])
                            ;

                            $maxLength = max($maxLength, strlen($key));
                            $count++;
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
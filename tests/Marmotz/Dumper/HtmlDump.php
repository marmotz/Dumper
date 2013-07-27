<?php

namespace tests\units\Marmotz\Dumper;

use atoum;
use Marmotz\Dumper\HtmlDump as TestedClass;



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
            '        background:    -moz-linear-gradient(top, #345678 0%, #56789A 100%);' . PHP_EOL .
            '        background: -webkit-linear-gradient(top, #345678 0%, #56789A 100%);' . PHP_EOL .
            '        background:      -o-linear-gradient(top, #345678 0%, #56789A 100%);' . PHP_EOL .
            '        background:     -ms-linear-gradient(top, #345678 0%, #56789A 100%);' . PHP_EOL .
            '        background:         linear-gradient(top, #345678 0%, #56789A 100%);' . PHP_EOL .
            '        color: white;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.array thead th {' . PHP_EOL .
            '        text-align: center;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.array tbody > tr > th {' . PHP_EOL .
            '        background-color: #56789A;' . PHP_EOL .
            '        background:    -moz-linear-gradient(left, #56789A 0%, #89ABCD 100%);' . PHP_EOL .
            '        background: -webkit-linear-gradient(left, #56789A 0%, #89ABCD 100%);' . PHP_EOL .
            '        background:      -o-linear-gradient(left, #56789A 0%, #89ABCD 100%);' . PHP_EOL .
            '        background:     -ms-linear-gradient(left, #56789A 0%, #89ABCD 100%);' . PHP_EOL .
            '        background:         linear-gradient(left, #56789A 0%, #89ABCD 100%);' . PHP_EOL .
            '        color: white;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object {' . PHP_EOL .
            '        border-color: #347856;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object thead {' . PHP_EOL .
            '        background-color: #347856;' . PHP_EOL .
            '        background:    -moz-linear-gradient(top, #347856 0%, #569A78 100%);' . PHP_EOL .
            '        background: -webkit-linear-gradient(top, #347856 0%, #569A78 100%);' . PHP_EOL .
            '        background:      -o-linear-gradient(top, #347856 0%, #569A78 100%);' . PHP_EOL .
            '        background:     -ms-linear-gradient(top, #347856 0%, #569A78 100%);' . PHP_EOL .
            '        background:         linear-gradient(top, #347856 0%, #569A78 100%);' . PHP_EOL .
            '        color: white;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object thead th {' . PHP_EOL .
            '        text-align: center;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object tbody > tr > th {' . PHP_EOL .
            '        background-color: #569A78;' . PHP_EOL .
            '        background:    -moz-linear-gradient(left, #569A78 0%, #89CDAB 100%);' . PHP_EOL .
            '        background: -webkit-linear-gradient(left, #569A78 0%, #89CDAB 100%);' . PHP_EOL .
            '        background:      -o-linear-gradient(left, #569A78 0%, #89CDAB 100%);' . PHP_EOL .
            '        background:     -ms-linear-gradient(left, #569A78 0%, #89CDAB 100%);' . PHP_EOL .
            '        background:         linear-gradient(left, #569A78 0%, #89CDAB 100%);' . PHP_EOL .
            '        color: white;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object tbody.classAttributes {' . PHP_EOL .
            '        font-style: italic;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object tbody.classAttributes td span.class {' . PHP_EOL .
            '        font-weight: bold;' . PHP_EOL .
            '        font-style: normal;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object tbody.constants table {' . PHP_EOL .
            '        width: 100%;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object tbody.properties .visibility,' . PHP_EOL .
            '    .dumper table.object tbody.methods .visibility {' . PHP_EOL .
            '        color: #258FD9;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object tbody.properties .static,' . PHP_EOL .
            '    .dumper table.object tbody.methods .static {' . PHP_EOL .
            '        color: #25A96F;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object tbody.properties tr.default td:nth-child(n+2) {' . PHP_EOL .
            '        color: #666;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object tbody.methods span.arguments .type {' . PHP_EOL .
            '        color: #550;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object tbody.methods span.arguments .name {' . PHP_EOL .
            '        color: #500;' . PHP_EOL .
            '    }' . PHP_EOL .
            '    .dumper table.object tbody.methods span.arguments .value {' . PHP_EOL .
            '        color: #055;' . PHP_EOL .
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

                ->output(
                    function() use($dump) {
                        $array = array(1, 2);
                        $array[] =& $array;

                        $dump->dump($array);
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
                        '                    <span class="integer">1</span>' . PHP_EOL .
                        '                </th>' . PHP_EOL .
                        '                <td>' . PHP_EOL .
                        '                    <span class="integer">integer(2)</span>' . PHP_EOL .
                        '                </td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <th>' . PHP_EOL .
                        '                    <span class="integer">2</span>' . PHP_EOL .
                        '                </th>' . PHP_EOL .
                        '                <td>' . PHP_EOL .
                        '                    <table class="array">' . PHP_EOL .
                        '                        <thead>' . PHP_EOL .
                        '                            <tr>' . PHP_EOL .
                        '                                <th colspan="2">array(3)</th>' . PHP_EOL .
                        '                            </tr>' . PHP_EOL .
                        '                        </thead>' . PHP_EOL .
                        '                        <tbody>' . PHP_EOL .
                        '                            <tr>' . PHP_EOL .
                        '                                <th>' . PHP_EOL .
                        '                                    <span class="integer">0</span>' . PHP_EOL .
                        '                                </th>' . PHP_EOL .
                        '                                <td>' . PHP_EOL .
                        '                                    <span class="integer">integer(1)</span>' . PHP_EOL .
                        '                                </td>' . PHP_EOL .
                        '                            </tr>' . PHP_EOL .
                        '                            <tr>' . PHP_EOL .
                        '                                <th>' . PHP_EOL .
                        '                                    <span class="integer">1</span>' . PHP_EOL .
                        '                                </th>' . PHP_EOL .
                        '                                <td>' . PHP_EOL .
                        '                                    <span class="integer">integer(2)</span>' . PHP_EOL .
                        '                                </td>' . PHP_EOL .
                        '                            </tr>' . PHP_EOL .
                        '                            <tr>' . PHP_EOL .
                        '                                <th>' . PHP_EOL .
                        '                                    <span class="integer">2</span>' . PHP_EOL .
                        '                                </th>' . PHP_EOL .
                        '                                <td>' . PHP_EOL .
                        '                                    <table class="array">' . PHP_EOL .
                        '                                        <thead>' . PHP_EOL .
                        '                                            <tr>' . PHP_EOL .
                        '                                                <th colspan="2">array(3)</th>' . PHP_EOL .
                        '                                            </tr>' . PHP_EOL .
                        '                                        </thead>' . PHP_EOL .
                        '                                        <tbody>' . PHP_EOL .
                        '                                            <tr>' . PHP_EOL .
                        '                                                <th>' . PHP_EOL .
                        '                                                    <span class="integer">0</span>' . PHP_EOL .
                        '                                                </th>' . PHP_EOL .
                        '                                                <td>' . PHP_EOL .
                        '                                                    <span class="integer">integer(1)</span>' . PHP_EOL .
                        '                                                </td>' . PHP_EOL .
                        '                                            </tr>' . PHP_EOL .
                        '                                            <tr>' . PHP_EOL .
                        '                                                <th>' . PHP_EOL .
                        '                                                    <span class="integer">1</span>' . PHP_EOL .
                        '                                                </th>' . PHP_EOL .
                        '                                                <td>' . PHP_EOL .
                        '                                                    <span class="integer">integer(2)</span>' . PHP_EOL .
                        '                                                </td>' . PHP_EOL .
                        '                                            </tr>' . PHP_EOL .
                        '                                            <tr>' . PHP_EOL .
                        '                                                <th>' . PHP_EOL .
                        '                                                    <span class="integer">2</span>' . PHP_EOL .
                        '                                                </th>' . PHP_EOL .
                        '                                                <td>' . PHP_EOL .
                        '                                                    <table class="array">' . PHP_EOL .
                        '                                                        <thead>' . PHP_EOL .
                        '                                                            <tr>' . PHP_EOL .
                        '                                                                <th colspan="2">array(3)</th>' . PHP_EOL .
                        '                                                            </tr>' . PHP_EOL .
                        '                                                        </thead>' . PHP_EOL .
                        '                                                        <tbody>' . PHP_EOL .
                        '                                                            <tr>' . PHP_EOL .
                        '                                                                <th>' . PHP_EOL .
                        '                                                                    <span class="integer">0</span>' . PHP_EOL .
                        '                                                                </th>' . PHP_EOL .
                        '                                                                <td>' . PHP_EOL .
                        '                                                                    <span class="integer">integer(1)</span>' . PHP_EOL .
                        '                                                                </td>' . PHP_EOL .
                        '                                                            </tr>' . PHP_EOL .
                        '                                                            <tr>' . PHP_EOL .
                        '                                                                <th>' . PHP_EOL .
                        '                                                                    <span class="integer">1</span>' . PHP_EOL .
                        '                                                                </th>' . PHP_EOL .
                        '                                                                <td>' . PHP_EOL .
                        '                                                                    <span class="integer">integer(2)</span>' . PHP_EOL .
                        '                                                                </td>' . PHP_EOL .
                        '                                                            </tr>' . PHP_EOL .
                        '                                                            <tr>' . PHP_EOL .
                        '                                                                <th>' . PHP_EOL .
                        '                                                                    <span class="integer">2</span>' . PHP_EOL .
                        '                                                                </th>' . PHP_EOL .
                        '                                                                <td>' . PHP_EOL .
                        '                                                                    <table class="array">' . PHP_EOL .
                        '                                                                        <thead>' . PHP_EOL .
                        '                                                                            <tr>' . PHP_EOL .
                        '                                                                                <th colspan="2">array(3)</th>' . PHP_EOL .
                        '                                                                            </tr>' . PHP_EOL .
                        '                                                                        </thead>' . PHP_EOL .
                        '                                                                        <tbody>' . PHP_EOL .
                        '                                                                            <tr>' . PHP_EOL .
                        '                                                                                <th>' . PHP_EOL .
                        '                                                                                    <span class="integer">0</span>' . PHP_EOL .
                        '                                                                                </th>' . PHP_EOL .
                        '                                                                                <td>' . PHP_EOL .
                        '                                                                                    <span class="integer">integer(1)</span>' . PHP_EOL .
                        '                                                                                </td>' . PHP_EOL .
                        '                                                                            </tr>' . PHP_EOL .
                        '                                                                            <tr>' . PHP_EOL .
                        '                                                                                <th>' . PHP_EOL .
                        '                                                                                    <span class="integer">1</span>' . PHP_EOL .
                        '                                                                                </th>' . PHP_EOL .
                        '                                                                                <td>' . PHP_EOL .
                        '                                                                                    <span class="integer">integer(2)</span>' . PHP_EOL .
                        '                                                                                </td>' . PHP_EOL .
                        '                                                                            </tr>' . PHP_EOL .
                        '                                                                            <tr>' . PHP_EOL .
                        '                                                                                <th>' . PHP_EOL .
                        '                                                                                    <span class="integer">2</span>' . PHP_EOL .
                        '                                                                                </th>' . PHP_EOL .
                        '                                                                                <td>' . PHP_EOL .
                        '                                                                                    <table class="array">' . PHP_EOL .
                        '                                                                                        <thead>' . PHP_EOL .
                        '                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                <th colspan="2">array(3)</th>' . PHP_EOL .
                        '                                                                                            </tr>' . PHP_EOL .
                        '                                                                                        </thead>' . PHP_EOL .
                        '                                                                                        <tbody>' . PHP_EOL .
                        '                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                <th>' . PHP_EOL .
                        '                                                                                                    <span class="integer">0</span>' . PHP_EOL .
                        '                                                                                                </th>' . PHP_EOL .
                        '                                                                                                <td>' . PHP_EOL .
                        '                                                                                                    <span class="integer">integer(1)</span>' . PHP_EOL .
                        '                                                                                                </td>' . PHP_EOL .
                        '                                                                                            </tr>' . PHP_EOL .
                        '                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                <th>' . PHP_EOL .
                        '                                                                                                    <span class="integer">1</span>' . PHP_EOL .
                        '                                                                                                </th>' . PHP_EOL .
                        '                                                                                                <td>' . PHP_EOL .
                        '                                                                                                    <span class="integer">integer(2)</span>' . PHP_EOL .
                        '                                                                                                </td>' . PHP_EOL .
                        '                                                                                            </tr>' . PHP_EOL .
                        '                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                <th>' . PHP_EOL .
                        '                                                                                                    <span class="integer">2</span>' . PHP_EOL .
                        '                                                                                                </th>' . PHP_EOL .
                        '                                                                                                <td>' . PHP_EOL .
                        '                                                                                                    <table class="array">' . PHP_EOL .
                        '                                                                                                        <thead>' . PHP_EOL .
                        '                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                <th colspan="2">array(3)</th>' . PHP_EOL .
                        '                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                        </thead>' . PHP_EOL .
                        '                                                                                                        <tbody>' . PHP_EOL .
                        '                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                <th>' . PHP_EOL .
                        '                                                                                                                    <span class="integer">0</span>' . PHP_EOL .
                        '                                                                                                                </th>' . PHP_EOL .
                        '                                                                                                                <td>' . PHP_EOL .
                        '                                                                                                                    <span class="integer">integer(1)</span>' . PHP_EOL .
                        '                                                                                                                </td>' . PHP_EOL .
                        '                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                <th>' . PHP_EOL .
                        '                                                                                                                    <span class="integer">1</span>' . PHP_EOL .
                        '                                                                                                                </th>' . PHP_EOL .
                        '                                                                                                                <td>' . PHP_EOL .
                        '                                                                                                                    <span class="integer">integer(2)</span>' . PHP_EOL .
                        '                                                                                                                </td>' . PHP_EOL .
                        '                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                <th>' . PHP_EOL .
                        '                                                                                                                    <span class="integer">2</span>' . PHP_EOL .
                        '                                                                                                                </th>' . PHP_EOL .
                        '                                                                                                                <td>' . PHP_EOL .
                        '                                                                                                                    <table class="array">' . PHP_EOL .
                        '                                                                                                                        <thead>' . PHP_EOL .
                        '                                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                                <th colspan="2">array(3)</th>' . PHP_EOL .
                        '                                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                                        </thead>' . PHP_EOL .
                        '                                                                                                                        <tbody>' . PHP_EOL .
                        '                                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                                <th>' . PHP_EOL .
                        '                                                                                                                                    <span class="integer">0</span>' . PHP_EOL .
                        '                                                                                                                                </th>' . PHP_EOL .
                        '                                                                                                                                <td>' . PHP_EOL .
                        '                                                                                                                                    <span class="integer">integer(1)</span>' . PHP_EOL .
                        '                                                                                                                                </td>' . PHP_EOL .
                        '                                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                                <th>' . PHP_EOL .
                        '                                                                                                                                    <span class="integer">1</span>' . PHP_EOL .
                        '                                                                                                                                </th>' . PHP_EOL .
                        '                                                                                                                                <td>' . PHP_EOL .
                        '                                                                                                                                    <span class="integer">integer(2)</span>' . PHP_EOL .
                        '                                                                                                                                </td>' . PHP_EOL .
                        '                                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                                <th>' . PHP_EOL .
                        '                                                                                                                                    <span class="integer">2</span>' . PHP_EOL .
                        '                                                                                                                                </th>' . PHP_EOL .
                        '                                                                                                                                <td>' . PHP_EOL .
                        '                                                                                                                                    <table class="array">' . PHP_EOL .
                        '                                                                                                                                        <thead>' . PHP_EOL .
                        '                                                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                                                <th colspan="2">array(3)</th>' . PHP_EOL .
                        '                                                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                                                        </thead>' . PHP_EOL .
                        '                                                                                                                                        <tbody>' . PHP_EOL .
                        '                                                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                                                <th>' . PHP_EOL .
                        '                                                                                                                                                    <span class="integer">0</span>' . PHP_EOL .
                        '                                                                                                                                                </th>' . PHP_EOL .
                        '                                                                                                                                                <td>' . PHP_EOL .
                        '                                                                                                                                                    <span class="integer">integer(1)</span>' . PHP_EOL .
                        '                                                                                                                                                </td>' . PHP_EOL .
                        '                                                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                                                <th>' . PHP_EOL .
                        '                                                                                                                                                    <span class="integer">1</span>' . PHP_EOL .
                        '                                                                                                                                                </th>' . PHP_EOL .
                        '                                                                                                                                                <td>' . PHP_EOL .
                        '                                                                                                                                                    <span class="integer">integer(2)</span>' . PHP_EOL .
                        '                                                                                                                                                </td>' . PHP_EOL .
                        '                                                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                                                <th>' . PHP_EOL .
                        '                                                                                                                                                    <span class="integer">2</span>' . PHP_EOL .
                        '                                                                                                                                                </th>' . PHP_EOL .
                        '                                                                                                                                                <td>' . PHP_EOL .
                        '                                                                                                                                                    <table class="array">' . PHP_EOL .
                        '                                                                                                                                                        <thead>' . PHP_EOL .
                        '                                                                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                                                                <th colspan="2">array(3)</th>' . PHP_EOL .
                        '                                                                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                                                                        </thead>' . PHP_EOL .
                        '                                                                                                                                                        <tbody>' . PHP_EOL .
                        '                                                                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                                                                <th>' . PHP_EOL .
                        '                                                                                                                                                                    <span class="integer">0</span>' . PHP_EOL .
                        '                                                                                                                                                                </th>' . PHP_EOL .
                        '                                                                                                                                                                <td>' . PHP_EOL .
                        '                                                                                                                                                                    <span class="integer">integer(1)</span>' . PHP_EOL .
                        '                                                                                                                                                                </td>' . PHP_EOL .
                        '                                                                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                                                                <th>' . PHP_EOL .
                        '                                                                                                                                                                    <span class="integer">1</span>' . PHP_EOL .
                        '                                                                                                                                                                </th>' . PHP_EOL .
                        '                                                                                                                                                                <td>' . PHP_EOL .
                        '                                                                                                                                                                    <span class="integer">integer(2)</span>' . PHP_EOL .
                        '                                                                                                                                                                </td>' . PHP_EOL .
                        '                                                                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                                                                            <tr>' . PHP_EOL .
                        '                                                                                                                                                                <th>' . PHP_EOL .
                        '                                                                                                                                                                    <span class="integer">2</span>' . PHP_EOL .
                        '                                                                                                                                                                </th>' . PHP_EOL .
                        '                                                                                                                                                                <td>' . PHP_EOL .
                        '                                                                                                                                                                    array *MAX LEVEL OF RECURSION*' . PHP_EOL .
                        '                                                                                                                                                                </td>' . PHP_EOL .
                        '                                                                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                                                                        </tbody>' . PHP_EOL .
                        '                                                                                                                                                    </table>' . PHP_EOL .
                        '                                                                                                                                                </td>' . PHP_EOL .
                        '                                                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                                                        </tbody>' . PHP_EOL .
                        '                                                                                                                                    </table>' . PHP_EOL .
                        '                                                                                                                                </td>' . PHP_EOL .
                        '                                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                                        </tbody>' . PHP_EOL .
                        '                                                                                                                    </table>' . PHP_EOL .
                        '                                                                                                                </td>' . PHP_EOL .
                        '                                                                                                            </tr>' . PHP_EOL .
                        '                                                                                                        </tbody>' . PHP_EOL .
                        '                                                                                                    </table>' . PHP_EOL .
                        '                                                                                                </td>' . PHP_EOL .
                        '                                                                                            </tr>' . PHP_EOL .
                        '                                                                                        </tbody>' . PHP_EOL .
                        '                                                                                    </table>' . PHP_EOL .
                        '                                                                                </td>' . PHP_EOL .
                        '                                                                            </tr>' . PHP_EOL .
                        '                                                                        </tbody>' . PHP_EOL .
                        '                                                                    </table>' . PHP_EOL .
                        '                                                                </td>' . PHP_EOL .
                        '                                                            </tr>' . PHP_EOL .
                        '                                                        </tbody>' . PHP_EOL .
                        '                                                    </table>' . PHP_EOL .
                        '                                                </td>' . PHP_EOL .
                        '                                            </tr>' . PHP_EOL .
                        '                                        </tbody>' . PHP_EOL .
                        '                                    </table>' . PHP_EOL .
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
                        '                                <span class="string">string(6) "const1"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td>CONSTANT2</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
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
                        '                            <td><span class="visibility">private</span> $privatePropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility">protected</span> $protectedPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility">public</span> $publicPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr class="default">' . PHP_EOL .
                        '                            <td rowspan="2"><span class="visibility">private</span> $privatePropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td>Default:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(7) "default"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr class="default">' . PHP_EOL .
                        '                            <td rowspan="2"><span class="visibility">protected</span> $protectedPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td>Default:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(7) "default"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr class="default">' . PHP_EOL .
                        '                            <td rowspan="2"><span class="visibility">public</span> $publicPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td>Default:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(7) "default"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <table class="object">' . PHP_EOL .
                        '                                    <thead>' . PHP_EOL .
                        '                                        <tr>' . PHP_EOL .
                        '                                            <th>object SampleClass2</th>' . PHP_EOL .
                        '                                        </tr>' . PHP_EOL .
                        '                                    </thead>' . PHP_EOL .
                        '                                    <tbody class="classAttributes parent">' . PHP_EOL .
                        '                                        <tr>' . PHP_EOL .
                        '                                            <td>extends abstract <span class="class">SampleAbstract1</span></td>' . PHP_EOL .
                        '                                        </tr>' . PHP_EOL .
                        '                                    </tbody>' . PHP_EOL .
                        '                                    <tbody class="classAttributes interface">' . PHP_EOL .
                        '                                        <tr>' . PHP_EOL .
                        '                                            <td>implements <span class="class">SampleInterface1</span></td>' . PHP_EOL .
                        '                                        </tr>' . PHP_EOL .
                        '                                    </tbody>' . PHP_EOL .
                        '                                </table>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility">protected</span> $traitProperty</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="null">NULL</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility"><span class="static">static</span> private</span> $staticPrivatePropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility"><span class="static">static</span> protected</span> $staticProtectedPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility"><span class="static">static</span> public</span> $staticPublicPropertyWithoutDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility"><span class="static">static</span> private</span> $staticPrivatePropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility"><span class="static">static</span> protected</span> $staticProtectedPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
                        '                                <span class="string">string(9) "construct"</span>' . PHP_EOL .
                        '                            </td>' . PHP_EOL .
                        '                        </tr>' . PHP_EOL .
                        '                        <tr>' . PHP_EOL .
                        '                            <td><span class="visibility"><span class="static">static</span> public</span> $staticPublicPropertyWithDefaultValue</td>' . PHP_EOL .
                        '                            <td>Current:</td>' . PHP_EOL .
                        '                            <td>' . PHP_EOL .
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
                        '                <td><span class="visibility">public</span> __construct()</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td><span class="visibility">private</span> privateMethod(<span class="arguments"><span class="name">$arg1</span>, <span class="type">array</span> &<span class="name">$arg2</span></span>)</td>' . PHP_EOL .
                        '            </tr>' . PHP_EOL .
                        '            <tr>' . PHP_EOL .
                        '                <td><span class="visibility">protected</span> protectedMethod(<span class="arguments"><span class="name">$arg1</span>, <span class="type">stdClass</span> <span class="name">$arg2</span>, <span class="name">$arg3</span> = <span class="value"><span class="null">NULL</span></span>, <span class="name">$arg4</span> = <span class="value"><span class="integer">42</span></span>, <span class="name">$arg5</span> = <span class="value"><span class="string">"foobar"</span></span></span>)</td>' . PHP_EOL .
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
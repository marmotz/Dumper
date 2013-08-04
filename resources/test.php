<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/classes/SampleClass1.php';

    /*
    $dumper = Marmotz\Dumper\Dump::factory('cli');
    /*/
    $dumper = Marmotz\Dumper\Dump::factory('apache2');
    //*/

    $dumper->dump(
        array(1, 'key' => 42, array('dump', array('deep')))
    );

    $dumper->dump(
        new SampleClass1
    );
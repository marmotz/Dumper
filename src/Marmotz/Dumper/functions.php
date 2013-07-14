<?php

/**
 * helper to dump variables
 *
 * @return string
 */
function dump()
{
    $dumper = Marmotz\Dumper\Dump::factory();

    foreach (func_get_args() as $variable) {
        $dumper->dump($variable);
        echo PHP_EOL;
    }
}
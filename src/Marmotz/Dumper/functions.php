<?php

/**
 * helper to dump variables
 *
 * @return string
 */
function dump(&$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null,
              &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null,
              &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null,
              &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null,
              &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null)
{
    $dumper = Marmotz\Dumper\Dump::factory();

    $args = debug_backtrace();
    $args = $args[0]['args'];

    foreach (array_keys($args) as $key) {
        $dumper->dump($args[$key]);
        echo PHP_EOL;
    }
}
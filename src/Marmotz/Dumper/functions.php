<?php

/**
 * helper to dump variables
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

/**
 * helper to dump variables and die
 */
function dumpd(&$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null,
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

    die;
}

/**
 * helper to get variables dump
 *
 * @return string
 */
function getDump(&$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null,
              &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null,
              &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null,
              &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null,
              &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null, &$arg = null)
{
    $dumper = Marmotz\Dumper\Dump::factory();

    $args = debug_backtrace();
    $args = $args[0]['args'];

    $dump = '';

    foreach (array_keys($args) as $key) {
        $dump .= $dumper->getDump($args[$key]) . PHP_EOL;
    }

    return $dump;
}
<?php

/**
 * helper to dump variables
 *
 * @return string
 */
function dump()
{
    echo Mattlab\Dumper\Dump::getDumps(
        func_get_args()
    );
}
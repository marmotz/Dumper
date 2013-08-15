<?php

require_once __DIR__ . '/SampleClass2.php';
require_once __DIR__ . '/SampleTrait1.php';

class SampleClass1 extends SampleClass2
{
    use SampleTrait1;

    public function withCallable(callable $arg1) {}
}
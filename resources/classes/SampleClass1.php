<?php

require_once __DIR__ . '/SampleClass2.php';
require_once __DIR__ . '/SampleTrait1.php';

class SampleClass1 extends SampleClass2
{
    use SampleTrait1;

    const CONST1    = 'const1';
    const CONSTANT2 = 'constant2';

    private   $privatePropertyWithoutDefaultValue;
    protected $protectedPropertyWithoutDefaultValue;
    public    $publicPropertyWithoutDefaultValue;

    private   $privatePropertyWithDefaultValue   = 'default';
    protected $protectedPropertyWithDefaultValue = 'default';
    public    $publicPropertyWithDefaultValue    = 'default';


    static private   $staticPrivatePropertyWithoutDefaultValue;
    static protected $staticProtectedPropertyWithoutDefaultValue;
    static public    $staticPublicPropertyWithoutDefaultValue;

    static private   $staticPrivatePropertyWithDefaultValue   = 'default';
    static protected $staticProtectedPropertyWithDefaultValue = 'default';
    static public    $staticPublicPropertyWithDefaultValue    = 'default';


    public function __construct()
    {
        $this->privatePropertyWithoutDefaultValue   = 'construct';
        $this->protectedPropertyWithoutDefaultValue = 'construct';
        $this->publicPropertyWithoutDefaultValue    = 'construct';

        $this->privatePropertyWithDefaultValue   = 'construct';
        $this->protectedPropertyWithDefaultValue = 'construct';
        $this->publicPropertyWithDefaultValue    = new SampleClass2;
        $this->publicPropertyWithDefaultValue->test = range(1, 10);


        self::$staticPrivatePropertyWithoutDefaultValue   = 'construct';
        self::$staticProtectedPropertyWithoutDefaultValue = 'construct';
        self::$staticPublicPropertyWithoutDefaultValue    = 'construct';

        self::$staticPrivatePropertyWithDefaultValue   = 'construct';
        self::$staticProtectedPropertyWithDefaultValue = 'construct';
        self::$staticPublicPropertyWithDefaultValue    = 'construct';
    }

    private   function privateMethod($arg1, array &$arg2) {}
    protected function protectedMethod($arg1, \stdClass $arg2, $arg3 = null, $arg4 = 42, $arg5 = 'foobar') {}
    public    function publicMethod() {}
}
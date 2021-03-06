<?php

require_once __DIR__ . '/SampleClass3.php';
require_once __DIR__ . '/SampleAbstract1.php';
require_once __DIR__ . '/SampleInterface1.php';

class SampleClass2 extends SampleAbstract1 implements SampleInterface1
{
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
        $this->publicPropertyWithDefaultValue    = new SampleClass3;
        $this->publicPropertyWithDefaultValue->property = range(1, 3);


        self::$staticPrivatePropertyWithoutDefaultValue   = 'construct';
        self::$staticProtectedPropertyWithoutDefaultValue = 'construct';
        self::$staticPublicPropertyWithoutDefaultValue    = 'construct';

        self::$staticPrivatePropertyWithDefaultValue   = 'construct';
        self::$staticProtectedPropertyWithDefaultValue = 'construct';
        self::$staticPublicPropertyWithDefaultValue    = 'construct';
    }

    static public function staticPublicMethod(array $arg1 = array()) {}

    public    function publicMethod() {}
    protected function protectedMethod($arg1, \stdClass $arg2, $arg3 = null, $arg4 = 42, $arg5 = 'foobar', $arg6 = self::CONST1) {}
    private   function privateMethod($arg1, array &$arg2) {}
}
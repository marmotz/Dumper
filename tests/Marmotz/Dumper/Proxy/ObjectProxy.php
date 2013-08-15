<?php

namespace tests\units\Marmotz\Dumper\Proxy;

use atoum;
use Marmotz\Dumper\Proxy\ObjectProxy as TestedClass;

if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
    require_once __DIR__ . '/../../../../resources/classes/SampleClass1.php';
}
require_once __DIR__ . '/../../../../resources/classes/SampleClass2.php';
require_once __DIR__ . '/../../../../resources/classes/SampleClass5.php';


class ObjectProxy extends atoum
{
    public function testConstructAndGetReflectionClass()
    {
        $this
            ->if($proxy = new TestedClass($object = new \stdClass))
                ->object($proxy->getReflectionClass())
                    ->isEqualTo(new \ReflectionObject($object))
                ->array($proxy->getParents())
                ->array($proxy->getProperties())
                ->array($proxy->getMethods())
        ;
    }

    public function testGetClassName()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->string($proxy->getClassName())
                    ->isEqualTo('stdClass')
            ->if($proxy = new TestedClass(new \foobar\SampleClass5))
                ->string($proxy->getClassName())
                    ->isEqualTo('foobar\SampleClass5')
        ;
    }

    public function testGetHasConstants()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->array($proxy->getConstants())
                    ->isEmpty()
                ->boolean($proxy->hasConstants())
                    ->isFalse()

            ->if($proxy = new TestedClass(new \SampleClass2))
                ->array($proxy->getConstants())
                    ->isIdenticalTo(
                        array(
                            'CONST1'    => 'const1',
                            'CONSTANT2' => 'constant2',
                        )
                    )
                ->boolean($proxy->hasConstants())
                    ->isTrue()
        ;
    }

    public function testGetHasInterfaces()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->array($constants = $proxy->getInterfaces())
                    ->isEmpty()
                ->boolean($proxy->hasInterfaces())
                    ->isFalse()

            ->if($proxy = new TestedClass(new \SampleClass2))
                ->array($interfaces = $proxy->getInterfaces())
                    ->hasSize(1)

                ->given($i = 0)
                ->object($interface = $interfaces[$i])
                    ->isInstanceOf('ReflectionClass')
                ->string($interface->getName())
                    ->isEqualTo('SampleInterface1')
                ->boolean($proxy->hasInterfaces())
                    ->isTrue()
        ;
    }

    public function testGetHasParents()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->array($proxy->getParents())
                    ->isEmpty()
                ->boolean($proxy->hasParents())
                    ->isFalse()

            ->if($proxy = new TestedClass(new \SampleClass2))
                ->boolean($proxy->hasParents())
                    ->isTrue()
                ->array($parents = $proxy->getParents())
                    ->foreach(
                        $parents,
                        function($assert, $parent) {
                            $assert
                                ->object($parent)
                                    ->isInstanceOf('ReflectionClass')
                            ;
                        }
                    )

                    ->given($i = 0)
                    ->object($parent = $parents[$i])
                    ->string($parent->getName())
                        ->isEqualTo('SampleAbstract1')
        ;
    }

    public function testGetHasTraits()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->array($proxy->getTraits())
                    ->isEmpty()
                ->boolean($proxy->hasTraits())
                    ->isFalse()
        ;

        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            $this
                ->if($proxy = new TestedClass(new \SampleClass1))
                    ->boolean($proxy->hasTraits())
                        ->isTrue()
                    ->array($traits = $proxy->getTraits())
                        ->foreach(
                            $traits,
                            function($assert, $trait) {
                                $assert
                                    ->object($trait)
                                        ->isInstanceOf('ReflectionClass')
                                ;
                            }
                        )

                        ->given($i = 0)
                        ->object($trait = $traits[$i])
                        ->string($trait->getName())
                            ->isEqualTo('SampleTrait1')

                ->if($proxy = new TestedClass(new \SampleClass1))
                ->and($proxy->loadPhpVersion('1.2.3'))
                    ->boolean($proxy->hasTraits())
                        ->isFalse()
                    ->array($proxy->getTraits())
                        ->isEmpty()
            ;
        }
    }

    public function testIsMinPhpVersion()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
            ->and($proxy->loadPhpVersion('1.0.0'))
                ->boolean($proxy->isMinPhpVersion('0.9.9'))
                    ->isTrue()
                ->boolean($proxy->isMinPhpVersion('1.0.0'))
                    ->isTrue()
                ->boolean($proxy->isMinPhpVersion('1.0.1'))
                    ->isFalse()
        ;
    }

    public function testGetLoadPhpVersion()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->object($proxy->loadPhpVersion())
                    ->isIdenticalTo($proxy)
                ->string($proxy->getPhpVersion())
                    ->isIdenticalTo(PHP_VERSION)
                ->object($proxy->loadPhpVersion($version = '1.2.3'))
                    ->isIdenticalTo($proxy)
                ->string($proxy->getPhpVersion())
                    ->isIdenticalTo($version)
        ;
    }

    public function testGetMaxLengthConstantNames()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->integer($proxy->getMaxLengthConstantNames())
                    ->isEqualTo(0)

            ->if($proxy = new TestedClass(new \SampleClass2))
                ->integer($proxy->getMaxLengthConstantNames())
                    ->isEqualTo(9)
        ;
    }

    public function testGetMaxLengthMethodVisibilities()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->integer($proxy->getMaxLengthMethodVisibilities())
                    ->isEqualTo(0)

            ->if($proxy = new TestedClass(new \SampleClass2))
                ->integer($proxy->getMaxLengthMethodVisibilities())
                    ->isEqualTo(13) // static public
        ;
    }

    public function testGetMaxLengthPropertyVisibilities()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->integer($proxy->getMaxLengthPropertyVisibilities())
                    ->isEqualTo(0)

            ->if($proxy = new TestedClass(new \SampleClass2))
                ->integer($proxy->getMaxLengthPropertyVisibilities())
                    ->isEqualTo(16)
        ;
    }

    public function testGetMethods()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->array($proxy->getMethods())
                    ->isEmpty()
                ->boolean($proxy->hasMethods())
                    ->isFalse()

            ->if($proxy = new TestedClass(new \SampleClass2))
                ->array($methods = $proxy->getMethods())
                    ->hasSize(5)
                    ->foreach(
                        $methods,
                        function($assert, $method) {
                            $assert
                                ->array($method)
                                    ->keys
                                        ->isIdenticalTo(
                                            array(
                                                'method',
                                                'visibility',
                                                'arguments',
                                            )
                                        )
                                ->object($method['method'])
                                    ->isInstanceOf('ReflectionMethod')
                                ->string($method['visibility'])
                                ->array($method['arguments'])
                                    ->foreach(
                                        $method['arguments'],
                                        function($assert, $argument) {
                                            $assert
                                                ->array($argument)
                                                    ->hasKey('name')
                                                    ->hasKey('reference')
                                                    ->hasKey('type')
                                                ->string($argument['name'])
                                                ->string($argument['reference'])
                                                ->string($argument['type'])
                                            ;
                                        }
                                    )
                            ;
                        }
                    )

                    ->given($i = 0)
                    ->array($method = $methods[$i])
                    ->string($method['method']->getName())
                        ->isEqualTo('__construct')
                    ->string($method['visibility'])
                        ->isEqualTo('public')
                    ->array($method['arguments'])
                        ->hasSize(0)

                    ->given($i++)
                    ->array($method = $methods[$i])
                    ->string($method['method']->getName())
                        ->isEqualTo('privateMethod')
                    ->string($method['visibility'])
                        ->isEqualTo('private')
                    ->array($method['arguments'])
                        ->hasSize(2)
                        ->given($j = 0)
                        ->array($argument = $method['arguments'][$j])
                        ->string($argument['name'])
                            ->isEqualTo('$arg1')
                        ->string($argument['reference'])
                            ->isEqualTo('')
                        ->string($argument['type'])
                            ->isEqualTo('')

                        ->given($j++)
                        ->array($argument = $method['arguments'][$j])
                        ->string($argument['name'])
                            ->isEqualTo('$arg2')
                        ->string($argument['reference'])
                            ->isEqualTo('&')
                        ->string($argument['type'])
                            ->isEqualTo('array')

                    ->given($i++)
                    ->array($method = $methods[$i])
                    ->string($method['method']->getName())
                        ->isEqualTo('protectedMethod')
                    ->string($method['visibility'])
                        ->isEqualTo('protected')
                    ->array($method['arguments'])
                        ->hasSize(6)
                        ->given($j = 0)
                        ->array($argument = $method['arguments'][$j])
                            ->notHasKey('default')
                        ->string($argument['name'])
                            ->isEqualTo('$arg1')
                        ->string($argument['reference'])
                            ->isEqualTo('')
                        ->string($argument['type'])
                            ->isEqualTo('')

                        ->given($j++)
                        ->array($argument = $method['arguments'][$j])
                            ->notHasKey('default')
                        ->string($argument['name'])
                            ->isEqualTo('$arg2')
                        ->string($argument['reference'])
                            ->isEqualTo('')
                        ->string($argument['type'])
                            ->isEqualTo('stdClass')

                        ->given($j++)
                        ->array($argument = $method['arguments'][$j])
                            ->hasKey('default')
                        ->string($argument['name'])
                            ->isEqualTo('$arg3')
                        ->string($argument['reference'])
                            ->isEqualTo('')
                        ->string($argument['type'])
                            ->isEqualTo('')
                        ->variable($argument['default'])
                            ->isNull()

                        ->given($j++)
                        ->array($argument = $method['arguments'][$j])
                            ->hasKey('default')
                        ->string($argument['name'])
                            ->isEqualTo('$arg4')
                        ->string($argument['reference'])
                            ->isEqualTo('')
                        ->string($argument['type'])
                            ->isEqualTo('')
                        ->integer($argument['default'])
                            ->isEqualTo(42)

                        ->given($j++)
                        ->array($argument = $method['arguments'][$j])
                            ->hasKey('default')
                        ->string($argument['name'])
                            ->isEqualTo('$arg5')
                        ->string($argument['reference'])
                            ->isEqualTo('')
                        ->string($argument['type'])
                            ->isEqualTo('')
                        ->string($argument['default'])
                            ->isEqualTo('foobar')

                        ->given($j++)
                        ->array($argument = $method['arguments'][$j])
                            ->hasKey('default')
                        ->string($argument['name'])
                            ->isEqualTo('$arg6')
                        ->string($argument['reference'])
                            ->isEqualTo('')
                        ->string($argument['type'])
                            ->isEqualTo(version_compare(PHP_VERSION, '5.4.6', '>=') ? 'constant' : '')
                        ->string($argument['default'])
                            ->isEqualTo(version_compare(PHP_VERSION, '5.4.6', '>=') ? 'self::CONST1' : 'const1')

                    ->given($i++)
                    ->array($method = $methods[$i])
                    ->string($method['method']->getName())
                        ->isEqualTo('publicMethod')
                    ->string($method['visibility'])
                        ->isEqualTo('public')
                    ->array($method['arguments'])
                        ->hasSize(0)

                    ->given($i++)
                    ->array($method = $methods[$i])
                    ->string($method['method']->getName())
                        ->isEqualTo('staticPublicMethod')
                    ->string($method['visibility'])
                        ->isEqualTo('public')
                    ->array($method['arguments'])
                        ->hasSize(1)
                        ->given($j = 0)
                        ->array($argument = $method['arguments'][$j])
                            ->hasKey('default')
                        ->string($argument['name'])
                            ->isEqualTo('$arg1')
                        ->string($argument['reference'])
                            ->isEqualTo('')
                        ->string($argument['type'])
                            ->isEqualTo('array')
                        ->array($argument['default'])
                            ->isEmpty()
        ;

        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            $this
                ->if($proxy = new TestedClass(new \SampleClass1))
                    ->array($methods = $proxy->getMethods())
                        ->hasSize(7)

                        // only 2 last methods
                        ->given($i = 5)
                        ->array($method = $methods[$i])
                        ->string($method['method']->getName())
                            ->isEqualTo('traitMethod')
                        ->string($method['visibility'])
                            ->isEqualTo('public')
                        ->array($method['arguments'])
                            ->hasSize(0)

                        ->given($i++)
                        ->array($method = $methods[$i])
                        ->string($method['method']->getName())
                            ->isEqualTo('withCallable')
                        ->string($method['visibility'])
                            ->isEqualTo('public')
                        ->array($method['arguments'])
                            ->hasSize(1)
                            ->given($j = 0)
                            ->array($argument = $method['arguments'][$j])
                                ->notHasKey('default')
                            ->string($argument['name'])
                                ->isEqualTo('$arg1')
                            ->string($argument['reference'])
                                ->isEqualTo('')
                            ->string($argument['type'])
                                ->isEqualTo('callable')
            ;
        }
    }

    public function testGetVisibility()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
            ->and($this->getMockGenerator()->orphanize('__construct'))
            ->and($mockReflectionObject = new \mock\ReflectionProperty)
            ->and($this->calling($mockReflectionObject)->isPublic = true)
                ->string($proxy->getVisibility($mockReflectionObject))
                    ->isEqualTo('public')
            ->if($this->calling($mockReflectionObject)->isPublic     = false)
            ->and($this->calling($mockReflectionObject)->isProtected = true)
                ->string($proxy->getVisibility($mockReflectionObject))
                    ->isEqualTo('protected')
            ->if($this->calling($mockReflectionObject)->isProtected = false)
            ->and($this->calling($mockReflectionObject)->isPrivate  = true)
                ->string($proxy->getVisibility($mockReflectionObject))
                    ->isEqualTo('private')

            ->exception(
                function() use($proxy) {
                    $proxy->getVisibility(new \stdClass);
                }
            )
                ->isInstanceOf('InvalidArgumentException')
                ->hasMessage('Unable to get visibility of "stdClass" object. You must provide a \ReflectionProperty or a \ReflectionMethod object.')
        ;
    }

    public function testLoadGetHasProperties()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->array($proxy->getProperties())
                    ->isEmpty()
                ->boolean($proxy->hasProperties())
                    ->isFalse()

            ->if($proxy = new TestedClass(new \SampleClass2))
                ->boolean($proxy->hasProperties())
                    ->isTrue()
                ->array($properties = $proxy->getProperties())
                    ->foreach(
                        $properties,
                        function($assert, $property) {
                            $assert
                                ->array($property)
                                    ->hasKey('property')
                                    ->hasKey('isStatic')
                                    ->hasKey('visibility')
                                    ->hasKey('value')
                                ->object($property['property'])
                                    ->isInstanceOf('ReflectionProperty')
                                ->boolean($property['isStatic'])
                                ->string($property['visibility'])
                            ;

                            if ($property['isStatic'] === false) {
                                $assert
                                    ->array($property)
                                        ->hasKey('defaultValue')
                                ;
                            }
                        }
                    )

                    ->given($i = 0)
                    ->array($property = $properties[$i])
                        ->hasSize(5)
                    ->string($property['property']->getName())
                        ->isEqualTo('privatePropertyWithDefaultValue')
                    ->boolean($property['isStatic'])
                        ->isFalse()
                    ->string($property['visibility'])
                        ->isEqualTo('private')
                    ->string($property['value'])
                        ->isEqualTo('construct')
                    ->string($property['defaultValue'])
                        ->isEqualTo('default')

                    ->given($i++)
                    ->array($property = $properties[$i])
                        ->hasSize(5)
                    ->string($property['property']->getName())
                        ->isEqualTo('privatePropertyWithoutDefaultValue')
                    ->boolean($property['isStatic'])
                        ->isFalse()
                    ->string($property['visibility'])
                        ->isEqualTo('private')
                    ->string($property['value'])
                        ->isEqualTo('construct')
                    ->variable($property['defaultValue'])
                        ->isNull()

                    ->given($i++)
                    ->array($property = $properties[$i])
                        ->hasSize(5)
                    ->string($property['property']->getName())
                        ->isEqualTo('protectedPropertyWithDefaultValue')
                    ->boolean($property['isStatic'])
                        ->isFalse()
                    ->string($property['visibility'])
                        ->isEqualTo('protected')
                    ->string($property['value'])
                        ->isEqualTo('construct')
                    ->string($property['defaultValue'])
                        ->isEqualTo('default')

                    ->given($i++)
                    ->array($property = $properties[$i])
                        ->hasSize(5)
                    ->string($property['property']->getName())
                        ->isEqualTo('protectedPropertyWithoutDefaultValue')
                    ->boolean($property['isStatic'])
                        ->isFalse()
                    ->string($property['visibility'])
                        ->isEqualTo('protected')
                    ->string($property['value'])
                        ->isEqualTo('construct')
                    ->variable($property['defaultValue'])
                        ->isNull()

                    ->given($i++)
                    ->array($property = $properties[$i])
                        ->hasSize(5)
                    ->string($property['property']->getName())
                        ->isEqualTo('publicPropertyWithDefaultValue')
                    ->boolean($property['isStatic'])
                        ->isFalse()
                    ->string($property['visibility'])
                        ->isEqualTo('public')
                    ->object($property['value'])
                        ->isInstanceOf('SampleClass3')
                        ->array($property['value']->property)
                            ->isEqualTo(array(1, 2, 3))
                    ->string($property['defaultValue'])
                        ->isEqualTo('default')

                    ->given($i++)
                    ->array($property = $properties[$i])
                        ->hasSize(5)
                    ->string($property['property']->getName())
                        ->isEqualTo('publicPropertyWithoutDefaultValue')
                    ->boolean($property['isStatic'])
                        ->isFalse()
                    ->string($property['visibility'])
                        ->isEqualTo('public')
                    ->string($property['value'])
                        ->isEqualTo('construct')
                    ->variable($property['defaultValue'])
                        ->isNull()
        ;
    }

    public function testLoadMethods()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->object($proxy->loadMethods())
                    ->isIdenticalTo($proxy)
        ;
    }

    public function testLoadParents()
    {
        $this
            ->if($proxy = new TestedClass(new \stdClass))
                ->object($proxy->loadParents())
                    ->isIdenticalTo($proxy)
        ;
    }

    public function testLoadProperties()
    {
        $this
            ->if($proxy = new TestedClass($object = new \stdClass))
                ->object($proxy->loadProperties($object))
                    ->isIdenticalTo($proxy)
        ;
    }
}
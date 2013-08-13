<?php

namespace tests\units\Marmotz\Dumper\Proxy;

use atoum;
use Marmotz\Dumper\Proxy\ObjectProxy as TestedClass;

require_once __DIR__ . '/../../../../resources/classes/SampleClass2.php';
require_once __DIR__ . '/../../../../resources/classes/SampleClass5.php';


class ObjectProxy extends atoum
{
    public function testConstruct()
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
            ->if($proxy = new TestedClass($object = new \stdClass))
                ->string($proxy->getClassName())
                    ->isEqualTo('stdClass')
            ->if($proxy = new TestedClass($object = new \foobar\SampleClass5))
                ->string($proxy->getClassName())
                    ->isEqualTo('foobar\SampleClass5')
        ;
    }

    public function testGetConstants()
    {
        $this
            ->if($proxy = new TestedClass($object = new \SampleClass2))
                ->array($proxy->getConstants())
                    ->isIdenticalTo(
                        array(
                            'CONST1'    => 'const1',
                            'CONSTANT2' => 'constant2',
                        )
                    )
        ;
    }

    public function testGetInterfaces()
    {
        $this
            ->if($proxy = new TestedClass($object = new \stdClass))
                ->array($constants = $proxy->getInterfaces())
                    ->isEmpty()

            ->if($proxy = new TestedClass($object = new \SampleClass2))
                ->array($interfaces = $proxy->getInterfaces())
                    ->hasSize(1)

                ->given($i = 0)
                ->object($interface = $interfaces[$i])
                    ->isInstanceOf('ReflectionClass')
                ->string($interface->getName())
                    ->isEqualTo('SampleInterface1')
        ;
    }

    public function testGetMaxLengthConstantNames()
    {
        $this
            ->if($proxy = new TestedClass($object = new \stdClass))
                ->integer($proxy->getMaxLengthConstantNames())
                    ->isEqualTo(0)

            ->if($proxy = new TestedClass($object = new \SampleClass2))
                ->integer($proxy->getMaxLengthConstantNames())
                    ->isEqualTo(9)
        ;
    }

    public function testGetMaxLengthMethodVisibilities()
    {
        $this
            ->if($proxy = new TestedClass($object = new \stdClass))
                ->integer($proxy->getMaxLengthMethodVisibilities())
                    ->isEqualTo(0)

            ->if($proxy = new TestedClass($object = new \SampleClass2))
                ->integer($proxy->getMaxLengthMethodVisibilities())
                    ->isEqualTo(9)
        ;
    }

    public function testGetMaxLengthPropertyVisibilities()
    {
        $this
            ->if($proxy = new TestedClass($object = new \stdClass))
                ->integer($proxy->getMaxLengthPropertyVisibilities())
                    ->isEqualTo(0)

            ->if($proxy = new TestedClass($object = new \SampleClass2))
                ->integer($proxy->getMaxLengthPropertyVisibilities())
                    ->isEqualTo(16)
        ;
    }

    public function testGetMethods()
    {
        $this
            ->if($proxy = new TestedClass($object = new \stdClass))
                ->array($proxy->getMethods())
                    ->isEmpty()

            ->if($proxy = new TestedClass($object = new \SampleClass2))
                ->array($methods = $proxy->getMethods())
                    ->hasSize(4)
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
                    ->hasSize(5)
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

                ->given($i++)
                ->array($method = $methods[$i])
                ->string($method['method']->getName())
                    ->isEqualTo('publicMethod')
                ->string($method['visibility'])
                    ->isEqualTo('public')
                ->array($method['arguments'])
                    ->hasSize(0)
        ;
    }
}
<?php

namespace tests\units\Marmotz\Dumper\Proxy;

use atoum;
use Marmotz\Dumper\Proxy\ObjectProxy as TestedClass;
use mock\Marmotz\Dumper\Dump         as mockDump;

require_once __DIR__ . '/../../../../resources/classes/SampleClass1.php';


class ObjectProxy extends atoum
{
    public function testProxy()
    {
        $this
            ->if($proxy = new TestedClass($object = new \SampleClass1, new mockDump))
                ->object($class = $proxy->getClass())
                    ->isInstanceOf('ReflectionClass')
                ->string($class->getName())
                    ->isIdenticalTo('SampleClass1')

                ->array($parents = $proxy->getParents())
                    ->hasSize(2)
                ->object($parent = $parents[0])
                    ->isInstanceOf('ReflectionClass')
                ->string($parent->getName())
                    ->isEqualTo('SampleClass2')
                ->object($parent = $parents[1])
                    ->isInstanceOf('ReflectionClass')
                ->string($parent->getName())
                    ->isEqualTo('SampleAbstract1')

                ->array($interfaces = $proxy->getInterfaces())
                    ->hasSize(1)
                ->object($interface = $interfaces[0])
                    ->isInstanceOf('ReflectionClass')
                ->string($interface->getName())
                    ->isEqualTo('SampleInterface1')

                ->array($traits = $proxy->getTraits())
                    ->hasSize(1)
                ->object($trait = $traits[0])
                    ->isInstanceOf('ReflectionClass')
                ->string($trait->getName())
                    ->isEqualTo('SampleTrait1')

                ->array($constants = $proxy->getConstants())
                    ->isIdenticalTo(
                        array(
                            'CONST1'    => 'const1',
                            'CONSTANT2' => 'constant2',
                        )
                    )

                ->array($properties = $proxy->getProperties())
                    ->hasSize(13)
                    ->foreach(
                        $properties,
                        function($assert, $property) {
                            $keys = array(
                                'property',
                                'isStatic',
                                'visibility',
                                'defaultValue',
                                'value',
                            );

                            if ($property['property']->isStatic()) {
                                unset($keys[3]);
                                $keys = array_values($keys);
                            }

                            $assert
                                ->array($property)
                                    ->keys
                                        ->isIdenticalTo($keys)
                                ->object($property['property'])
                                    ->isInstanceOf('ReflectionProperty')
                            ;
                        }
                    )
                ->array($property = $properties[0])
                ->string($property['property']->getName())
                    ->isEqualTo('privatePropertyWithoutDefaultValue')
                ->variable($property['defaultValue'])
                    ->isNull()
                ->string($property['value'])
                    ->isEqualTo('construct')

                ->array($property = $properties[1])
                ->string($property['property']->getName())
                    ->isEqualTo('protectedPropertyWithoutDefaultValue')
                ->variable($property['defaultValue'])
                    ->isNull()
                ->string($property['value'])
                    ->isEqualTo('construct')

                ->array($property = $properties[2])
                ->string($property['property']->getName())
                    ->isEqualTo('publicPropertyWithoutDefaultValue')
                ->variable($property['defaultValue'])
                    ->isNull()
                ->string($property['value'])
                    ->isEqualTo('construct')

                ->array($property = $properties[3])
                ->string($property['property']->getName())
                    ->isEqualTo('privatePropertyWithDefaultValue')
                ->string($property['defaultValue'])
                    ->isEqualTo('default')
                ->string($property['value'])
                    ->isEqualTo('construct')

                ->array($property = $properties[4])
                ->string($property['property']->getName())
                    ->isEqualTo('protectedPropertyWithDefaultValue')
                ->string($property['defaultValue'])
                    ->isEqualTo('default')
                ->string($property['value'])
                    ->isEqualTo('construct')

                ->array($property = $properties[5])
                ->string($property['property']->getName())
                    ->isEqualTo('publicPropertyWithDefaultValue')
                ->string($property['defaultValue'])
                    ->isEqualTo('default')
                ->object($property['value'])
                    ->isInstanceOf('SampleClass2')

                ->array($property = $properties[6])
                ->string($property['property']->getName())
                    ->isEqualTo('traitProperty')
                ->variable($property['defaultValue'])
                    ->isNull()
                ->variable($property['value'])
                    ->isNull()

                ->array($property = $properties[7])
                ->string($property['property']->getName())
                    ->isEqualTo('staticPrivatePropertyWithoutDefaultValue')
                ->string($property['value'])
                    ->isEqualTo('construct')

                ->array($property = $properties[8])
                ->string($property['property']->getName())
                    ->isEqualTo('staticProtectedPropertyWithoutDefaultValue')
                ->string($property['value'])
                    ->isEqualTo('construct')

                ->array($property = $properties[9])
                ->string($property['property']->getName())
                    ->isEqualTo('staticPublicPropertyWithoutDefaultValue')
                ->string($property['value'])
                    ->isEqualTo('construct')

                ->array($property = $properties[10])
                ->string($property['property']->getName())
                    ->isEqualTo('staticPrivatePropertyWithDefaultValue')
                ->string($property['value'])
                    ->isEqualTo('construct')

                ->array($property = $properties[11])
                ->string($property['property']->getName())
                    ->isEqualTo('staticProtectedPropertyWithDefaultValue')
                ->string($property['value'])
                    ->isEqualTo('construct')

                ->array($property = $properties[12])
                ->string($property['property']->getName())
                    ->isEqualTo('staticPublicPropertyWithDefaultValue')
                ->string($property['value'])
                    ->isEqualTo('construct')
        ;
    }
}
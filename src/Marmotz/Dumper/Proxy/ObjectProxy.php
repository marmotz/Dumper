<?php

namespace Marmotz\Dumper\Proxy;

use Marmotz\Dumper\Dump;


/**
 * Object proxy
 *
 * @package Dumper
 * @author  Renaud Littolff <rlittolff@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link    https://github.com/marmotz/Dumper
 */
class ObjectProxy
{
    protected $maxLengthConstantNames;
    protected $maxLengthMethodVisibilities;
    protected $maxLengthPropertyVisibilities;
    protected $methods;
    protected $parents;
    protected $properties;
    protected $reflectionObject;

    /**
     * Constructor
     *
     * @param object $object
     * @param Dump   $dumper
     */
    public function __construct($object, Dump $dumper)
    {
        $this->reflectionObject = new \ReflectionObject($object);

        // extends
        $this->parents = array();

        $parent = $this->getClass();

        while ($parent = $parent->getParentClass()) {
            $this->parents[] = $parent;
        }

        // properties
        $this->properties = array();

        $defaultPropertiesValue = $this->getClass()->getDefaultProperties();

        foreach ($this->parents as $parent) {
            $defaultPropertiesValue = array_merge(
                $defaultPropertiesValue,
                $parent->getDefaultProperties()
            );
        }

        $arrayObject = (array) $object;

        foreach (array_keys($arrayObject) as $propertyName) {
            $propertyClass = $this->getClass()->getName();

            if (strpos($propertyName, '*') === 1) {
                $propertyName = substr($propertyName, 3);
            } elseif (strpos($propertyName, $this->getClass()->getName()) === 1) {
                $propertyName = substr($propertyName, strlen($this->getClass()->getName()) + 2);
            } else {
                foreach ($this->parents as $parent) {
                    $parentName = $parent->getName();

                    if (strpos($propertyName, $parentName) === 1) {
                        $propertyName = substr($propertyName, strlen($parentName) + 2);
                        $propertyClass = $parentName;
                        break;
                    }
                }
            }

            try {
                $property = new \ReflectionProperty($propertyClass, $propertyName);
                $property->setAccessible(true);

                $value = $property->getValue($object);

                $this->properties[] = array(
                    'property'     => $property,
                    'isStatic'     => false,
                    'visibility'   => $this->getVisibility($property),
                    'defaultValue' => $defaultPropertiesValue[$propertyName],
                    'value'        => $value,
                );
            } catch (\ReflectionException $e) {
            }
        }

        foreach ($this->getClass()->getStaticproperties() as $propertyName => $value) {
            $property = new \ReflectionProperty($this->getClass()->getName(), $propertyName);
            $property->setAccessible(true);

            $value = $property->getValue($object);

            $this->properties[] = array(
                'property'    => $property,
                'isStatic'    => true,
                'visibility'  => $this->getVisibility($property),
                'value'       => $value,
            );
        }

        foreach ($this->getClass()->getMethods() as $methodName => $method) {
            $this->methods[] = array(
                'method'     => $method,
                'visibility' => $this->getVisibility($method),
                'arguments'  => array_map(
                    function($parameter) {
                        $return = array(
                            'name'      => '$' . $parameter->getName(),
                            'reference' => $parameter->isPassedByReference() ? '&' : '',
                            'type'      => $parameter->isArray() ? 'array' : (
                                version_compare(PHP_VERSION, '5.4.0', '>=') && $parameter->isCallable() ? 'callable' : (
                                    $parameter->getClass() ? $parameter->getClass()->getName() : ''
                                )
                            ),
                        );

                        if ($parameter->isDefaultValueAvailable()) {
                            $return['default'] = version_compare(PHP_VERSION, '5.4.6', '>=') && $parameter->isDefaultValueConstant()
                                ? $parameter->getDefaultValueConstantName()
                                : $parameter->getDefaultValue()
                            ;
                        }

                        return $return;
                    },
                    $method->getParameters()
                )
            );
        }
    }

    /**
     * Return ReflectionClass object
     *
     * @return \ReflectionClass
     */
    public function getClass()
    {
        return $this->reflectionObject;
    }

    /**
     * Return constants
     *
     * @return array
     */
    public function getConstants()
    {
        return $this->getClass()->getConstants();
    }

    /**
     * Return interfaces
     *
     * @return \ReflectionClass[]
     */
    public function getInterfaces()
    {
        return array_values($this->getClass()->getInterfaces());
    }

    /**
     * Return max length for constant names
     *
     * @return integer
     */
    public function getMaxLengthConstantNames()
    {
        if ($this->maxLengthConstantNames === null) {
            $this->maxLengthConstantNames = $this->calculateMaxLength(
                array_keys($this->getConstants())
            );
        }

        return $this->maxLengthConstantNames;
    }

    /**
     * Return max length for method visibilities
     *
     * @return integer
     */
    public function getMaxLengthMethodVisibilities()
    {
        if ($this->maxLengthMethodVisibilities === null) {
            $this->maxLengthMethodVisibilities = $this->calculateMaxLength(
                array_map(
                    function($method) {
                        if ($method['method']->isStatic()) {
                            return 'static ' . $method['visibility'];
                        } else {
                            return $method['visibility'];
                        }
                    },
                    $this->methods
                )
            );
        }

        return $this->maxLengthMethodVisibilities;
    }

    /**
     * Return max length for property visibilities
     *
     * @return integer
     */
    public function getMaxLengthPropertyVisibilities()
    {
        if ($this->maxLengthPropertyVisibilities === null) {
            $this->maxLengthPropertyVisibilities = $this->calculateMaxLength(
                array_map(
                    function($property) {
                        if ($property['isStatic']) {
                            return 'static ' . $property['visibility'];
                        } else {
                            return $property['visibility'];
                        }
                    },
                    $this->properties
                )
            );
        }

        return $this->maxLengthPropertyVisibilities;
    }

    /**
     * Return methods
     *
     * @return \ReflectionMethod[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Return parent classes
     *
     * @return \ReflectionClass[]
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * Return properties
     *
     * @return \ReflectionProperty[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Return traits
     *
     * @return \ReflectionClass[]
     */
    public function getTraits()
    {
        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            return array_values($this->getClass()->getTraits());
        } else {
            return array();
        }
    }

    /**
     * Return visibility of current reflection object
     *
     * @param \ReflectionProperty|\ReflectionMethod $reflectionObject
     *
     * @return string
     */
    public function getVisibility($reflectionObject)
    {
        return $reflectionObject->isPublic() ? 'public' : (
            $reflectionObject->isProtected() ? 'protected' : 'private'
        );
    }

    /**
     * Return if proxy has constants
     *
     * @return boolean
     */
    public function hasConstants()
    {
        return (boolean) count($this->getConstants());
    }

    /**
     * Return if proxy has interfaces
     *
     * @return boolean
     */
    public function hasInterfaces()
    {
        return (boolean) count($this->getInterfaces());
    }

    /**
     * Return if proxy has methods
     *
     * @return boolean
     */
    public function hasMethods()
    {
        return (boolean) count($this->getMethods());
    }

    /**
     * Return if proxy has parents
     *
     * @return boolean
     */
    public function hasParents()
    {
        return (boolean) count($this->getParents());
    }

    /**
     * Return if proxy has properties
     *
     * @return boolean
     */
    public function hasProperties()
    {
        return (boolean) count($this->getProperties());
    }

    /**
     * Return if proxy has traits
     *
     * @return boolean
     */
    public function hasTraits()
    {
        return (boolean) count($this->getTraits());
    }

    protected function calculateMaxLength(array $array)
    {
        $maxLength = 0;

        foreach ($array as $value) {
            $maxLength = max($maxLength, strlen($value));
        }

        return $maxLength;
    }
}
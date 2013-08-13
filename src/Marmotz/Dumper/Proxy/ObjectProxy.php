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
    protected $className;
    protected $constants;
    protected $interfaces;
    protected $maxLengthConstantNames;
    protected $maxLengthMethodVisibilities;
    protected $maxLengthPropertyVisibilities;
    protected $methods;
    protected $parents;
    protected $properties;
    protected $reflectionClass;
    protected $traits;

    /**
     * Constructor
     *
     * @param object $object
     */
    public function __construct($object)
    {
        $this->reflectionClass = new \ReflectionObject($object);

        $this
            ->loadParents()
            ->loadProperties($object)
            ->loadMethods()
        ;
    }

    /**
     * Return class name of current object
     *
     * @return string
     */
    public function getClassName()
    {
        if ($this->className === null) {
            $this->className = $this->getReflectionClass()->getName();
        }

        return $this->className;
    }

    /**
     * Return constants
     *
     * @return array
     */
    public function getConstants()
    {
        if ($this->constants === null) {
            $this->constants = $this->getReflectionClass()->getConstants();
        }

        return $this->constants;
    }

    /**
     * Return interfaces
     *
     * @return \ReflectionClass[]
     */
    public function getInterfaces()
    {
        if ($this->interfaces === null) {
            $this->interfaces = array_values($this->getReflectionClass()->getInterfaces());
        }

        return $this->interfaces;
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
                    $this->getMethods()
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
                    $this->getProperties()
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
     * Return ReflectionClass object
     *
     * @return \ReflectionClass
     */
    public function getReflectionClass()
    {
        return $this->reflectionClass;
    }

    /**
     * Return traits
     *
     * @return \ReflectionClass[]
     */
    public function getTraits()
    {
        if ($this->traits === null) {
            if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
                $this->traits = array_values($this->getReflectionClass()->getTraits());
            } else {
                $this->traits = array();
            }
        }

        return $this->traits;
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

    /**
     * Load methods of current object
     *
     * @return Objectproxy
     */
    public function loadMethods()
    {
        $this->methods = array();

        foreach ($this->getReflectionClass()->getMethods() as $methodName => $method) {
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

        // sort by name
        usort(
            $this->methods,
            function($a, $b) {
                return strcasecmp($a['method']->getName(), $b['method']->getName());
            }
        );

        return $this;
    }

    /**
     * Load parent classes of current object
     *
     * @return ObjectProxy
     */
    public function loadParents()
    {
        $this->parents = array();

        $parent = $this->getReflectionClass();

        while ($parent = $parent->getParentClass()) {
            $this->parents[] = $parent;
        }

        return $this;
    }

    /**
     * Load properties of current object
     *
     * @param object $object
     *
     * @return ObjectProxy
     */
    public function loadProperties($object)
    {
        // properties
        $this->properties = array();

        $defaultPropertiesValue = $this->getReflectionClass()->getDefaultProperties();

        foreach ($this->parents as $parent) {
            $defaultPropertiesValue = array_merge(
                $defaultPropertiesValue,
                $parent->getDefaultProperties()
            );
        }

        $arrayObject = (array) $object;

        foreach (array_keys($arrayObject) as $propertyName) {
            $propertyClass = $this->getReflectionClass()->getName();

            if (strpos($propertyName, '*') === 1) {
                $propertyName = substr($propertyName, 3);
            } elseif (strpos($propertyName, $this->getReflectionClass()->getName()) === 1) {
                $propertyName = substr($propertyName, strlen($this->getReflectionClass()->getName()) + 2);
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

        foreach ($this->getReflectionClass()->getStaticproperties() as $propertyName => $value) {
            $property = new \ReflectionProperty($this->getReflectionClass()->getName(), $propertyName);
            $property->setAccessible(true);

            $value = $property->getValue($object);

            $this->properties[] = array(
                'property'    => $property,
                'isStatic'    => true,
                'visibility'  => $this->getVisibility($property),
                'value'       => $value,
            );
        }

        // sort by name
        usort(
            $this->properties,
            function($a, $b) {
                return strcasecmp($a['property']->getName(), $b['property']->getName());
            }
        );

        return $this;
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
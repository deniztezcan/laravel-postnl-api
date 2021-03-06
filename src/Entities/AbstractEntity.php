<?php

namespace DenizTezcan\LaravelPostNLAPI\Entities;

use Exception;
use ReflectionClass;

abstract class AbstractEntity
{
    public static function create(array $properties = [])
    {
        if (get_called_class() === __CLASS__) {
            return;
        }

        try {
            $reflectionClass = new ReflectionClass(get_called_class());
        } catch (Exception $e) {
            report($e);

            return;
        }

        $instance = $reflectionClass->newInstanceWithoutConstructor();

        foreach ($properties as $name => $value) {
            $instance->{'set'.$name}($value);
        }

        return $instance;
    }

    public function __call($name, $value)
    {
        $methodName = substr($name, 0, 3);
        $propertyName = substr($name, 3, strlen($name));

        if ($methodName === 'get') {
            if (property_exists($this, $propertyName)) {
                return $this->{$propertyName};
            } else {
                return;
            }
        } elseif ($methodName === 'set') {
            if (!is_array($value) || count($value) < 1) {
                throw new Exception('Value is missing');
            }
            if (property_exists($this, $propertyName)) {
                $this->{$propertyName} = $value[0];
            }

            return $this;
        }

        throw new Exception('Not a valid `get` or `set` method');
    }
}

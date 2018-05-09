<?php

namespace m8rge\swagger;

use IteratorAggregate;

class Parameters extends BaseObject implements IteratorAggregate
{
    /**
     * @var Parameter[]
     */
    protected $parameters = [];

    public function __set($name, $value)
    {
        if (isset($value['name'])) {
            $this->parameters[$value['name']] = new Parameter($value);
        }
    }

    function __get($name)
    {
        return $this->parameters[$name];
    }

    public function getBodyObject()
    {
        $res = null;
        foreach ($this->parameters as $name => $parameter) {
            if ($parameter->in == 'body') {
                if (!is_array($res)) {
                    $res = [];
                }
                $res[$name] = $parameter->schema->getObject();
            }
        }

        return $res;
    }

    public function getHeaderParameters()
    {
        $res = null;
        foreach ($this->parameters as $name => $parameter) {
            if ($parameter->in == 'header') {
                if (!is_array($res)) {
                    $res = [];
                }
                $res[$name] = $parameter;
            }
        }

        return $res;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->parameters);
    }
}
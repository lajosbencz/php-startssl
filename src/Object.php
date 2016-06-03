<?php


namespace StartSSL;


class Object extends \ArrayObject
{
    public function __construct($input=[], $flags=0, $iterator_class='ArrayIterator')
    {
        if(is_array($input)) {
            foreach($input as $k => $v) {
                if(is_array($v) || is_object($v)) {
                    $input[$k] = new self($v, $flags, $iterator_class);
                }
            }
        }
        parent::__construct($input, $flags, $iterator_class);
    }

    public function offsetSet($index, $value)
    {
        if(is_array($value) || is_object($value)) {
            $value = new self($value);
        }
        parent::offsetSet($index, $value);
    }

    public function getArrayCopy()
    {
        $r = [];
        foreach(parent::getArrayCopy() as $k => $v) {
            if($v instanceof self) {
                $v = $v->getArrayCopy();
            }
            $r[$k] = $v;
        }
        return $r;
    }

    function __get($name)
    {
        return $this->offsetGet($name);
    }

    function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    function __isset($name)
    {
        return $this->offsetExists($name);
    }

    function __unset($name)
    {
        $this->offsetUnset($name);
    }

    function __toString()
    {
        return json_encode($this->getArrayCopy(), JSON_PRETTY_PRINT);
    }
}
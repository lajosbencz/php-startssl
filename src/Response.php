<?php

namespace StartSSL;

abstract class Response implements ResponseInterface
{
    /** @var Request */
    protected $_request;

    /** @var array */
    protected $_data = [];

    public function __construct(Request $request)
    {
        $this->_request = $request;
        $this->handle();
    }

    public function handle()
    {
        $this->_handle();
        return $this;
    }

    abstract protected function _handle();

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->_request;
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->_data[$offset];
        }
        return null;
    }

    public function offsetExists($offset)
    {
        return isset($this->_data[$offset]);
    }

    public function offsetSet($offset, $value)
    {
        $this->_data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->_data[$offset]);
        }
    }

}
<?php

namespace StartSSL;

use ReflectionClass;

abstract class Request implements RequestInterface
{
    /** @var Service */
    protected $_service;

    /**
     * Request constructor.
     * @param Service $service
     */
    public function __construct(Service $service)
    {
        $this->_service = $service;
    }

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->_service;
    }

    public function send()
    {
        $class = $this->getResponseName();
        $response = new $class($this);

        return $response;
    }

    /**
     * @return string
     */
    public function getResponseName()
    {
        static $name;
        if ($name) {
            $ref = new ReflectionClass($this);
            $name = __NAMESPACE__ . '\\Response\\' . $ref->getShortName();
        }
        return $name;
    }

}
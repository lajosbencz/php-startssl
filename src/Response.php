<?php

namespace StartSSL;

abstract class Response extends \ArrayObject implements ResponseInterface
{
    /** @var RequestInterface */
    protected $_request;

    /** @var array */
    protected $_response = [];

    abstract protected function _handle();

    /**
     * @inheritdoc
     */
    public function __construct(RequestInterface $request, array $response=[])
    {
        $this->_request = $request;
        $this->_response = $response;
        parent::__construct($response);
        $this->handle();
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @return $this
     */
    public function handle()
    {
        $this->_handle();
        return $this;
    }

    /**
     * @return string
     */
    public function getJson()
    {
        return json_encode($this->getArrayCopy(), JSON_PRETTY_PRINT, 1024);
    }

}
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
     * @return int
     */
    public function getStatus()
    {
        return $this->getArrayCopy()['status'];
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->getArrayCopy()['errorCode'];
    }

    /**
     * @return string
     */
    public function getShortMessage()
    {
        return $this->getArrayCopy()['shortMsg'];
    }

    /**
     * @param string $index (optional)
     * @return mixed
     */
    public function getData($index=null)
    {
        $a = $this->getArrayCopy();
        if($index !== null && isset($a['data'][$index])) {
            return $a['data'][$index];
        }
        return $a['data'];
    }

    /**
     * @return string
     */
    public function getJson()
    {
        return json_encode($this->getArrayCopy(), JSON_PRETTY_PRINT, 1024);
    }

}
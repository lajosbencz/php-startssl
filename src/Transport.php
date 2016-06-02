<?php

namespace StartSSL;

abstract class Transport implements TransportInterface
{
    /** @var int */
    protected $_timeout = null;

    /** @var string */
    protected $_url = null;

    /** @var array */
    protected $_payload = [];

    /** @var string */
    protected $_error = null;

    /** @var int */
    protected $_errorCode = 0;

    /** @var string */
    protected $_response = null;

    /**
     * Transport constructor.
     * @param int $timeout (optional)
     * @param string $url (optional)
     * @param array $data (optional)
     */
    public function __construct($timeout = null, $url = null, array $data = [])
    {
        if ($timeout) {
            $this->setTimeout($timeout);
        }
        if ($url) {
            $this->setUrl($url);
        }
        if ($data) {
            $this->setPayload($data);
        }
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->_timeout;
    }

    /**
     * @inheritdoc
     */
    public function setTimeout($timeout)
    {
        $this->_timeout = max(0, $timeout);
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @inheritdoc
     */
    public function setUrl($url, array $query = [])
    {
        $this->_response = null;
        if ($url) {
            $parsed = parse_url($url);
            $url = $parsed['scheme'] . '://' . $parsed['host'] . $parsed['path'];
            if (isset($parsed['query'])) {
                $q = [];
                parse_str($parsed['query'], $q);
                $query = array_merge($q, $query);
            }
            if (count($query) > 0) {
                $url .= '?' . http_build_query($query);
            }
        } else {
            $url = null;
        }
        $this->_url = $url;
        return $this;
    }


    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->_payload;
    }

    /**
     * @inheritdoc
     */
    public function setPayload($payload)
    {
        $this->_response = null;
        $this->_payload = $payload ?: [];
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getError()
    {
        return $this->_error;
    }

    /**
     * @inheritdoc
     */
    public function getErrorCode()
    {
        return $this->_errorCode;
    }

    /**
     * @inheritdoc
     */
    function getResponse($array = true)
    {
        if ($this->_response === null) {
            $this->_response = $this->broker();
        }
        if ($array) {
            return json_decode($this->_response, true);
        }
        return $this->_response;
    }

}
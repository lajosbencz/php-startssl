<?php

namespace StartSSL;

abstract class Transport implements TransportInterface
{
    use ConfigTrait;

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
     * @param Config $config (optional)
     */
    public function __construct(Config $config=null)
    {
        $this->setConfig($config ? : Config::getDefault());
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
            if(!isset($parsed['path'])) {
                $parsed['path'] = '/';
            }
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
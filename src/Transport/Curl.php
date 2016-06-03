<?php

namespace StartSSL\Transport;

use StartSSL\Config;
use StartSSL\Transport;

class Curl extends Transport
{
    /** @var resource */
    protected $_curl;

    public function __construct(Config $config=null)
    {
        parent::__construct($config);
        $this->_curl = curl_init();
    }

    /**
     * @inheritdoc
     */
    public function broker()
    {
        $this->_error = null;
        $this->_errorCode = 0;
        curl_reset($this->_curl);
        curl_setopt($this->_curl, CURLOPT_URL, $this->getUrl());
        curl_setopt($this->_curl, CURLOPT_TIMEOUT, $this->getConfig('timeout'));
        curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($this->_curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->_curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->_curl, CURLOPT_SSLCERT, $this->getConfig('certificate'));
        curl_setopt($this->_curl, CURLOPT_SSLCERTTYPE, "P12");
        curl_setopt($this->_curl, CURLOPT_SSLKEYPASSWD, $this->getConfig('password'));
        if ($this->_payload) {
            curl_setopt($this->_curl, CURLOPT_POST, 1);
            curl_setopt($this->_curl, CURLOPT_POSTFIELDS, http_build_query($this->_payload));
        }
        $r = curl_exec($this->_curl);
        if ($r === false) {
            $this->_error = curl_error($this->_curl);
            $this->_errorCode = curl_errno($this->_curl);
            $this->_response = null;
        }
        $this->_response = $r;
        return $this->_response;
    }

    public function __destruct()
    {
        if (is_resource($this->_curl)) {
            curl_close($this->_curl);
        }
    }

}
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
        $options = [
            CURLOPT_URL => $this->getUrl(),
            CURLOPT_TIMEOUT => $this->getConfig('timeout'),
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17',
            CURLOPT_HEADER => 0,
            CURLOPT_AUTOREFERER => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSLCERT => $this->getConfig('certificate')->getPath(),
            CURLOPT_SSLCERTPASSWD => $this->getConfig('certificate')->getPassword(),
        ];
        //$cert = $this->getConfig('certificate');
        if($this->_payload) {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = http_build_query($this->_payload);
        }
        curl_reset($this->_curl);
        curl_setopt_array($this->_curl, $options);
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
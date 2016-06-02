<?php

namespace StartSSL;

/**
 * Class Service
 * @package StartSSL
 */
class Service
{
    /** @var string */
    protected $_token;

    /** @var string */
    protected $_certificate;

    /** @var string */
    protected $_password;

    /** @var int */
    protected $_timeout = 0;

    /**
     * Service constructor.
     * @param string $token
     * @param string $certificate
     * @param string $password (optional)
     * @param int $timeout (optional)
     */
    public function __construct($token, $certificate, $password = '', $timeout = 0)
    {
        if (is_array($token)) {
            $this->setCertificate($token['certificate']);
            $this->setPassword($token['password']);
            $this->setTimeout($token['timeout']);
            $this->setToken($token['token']);
        } else {
            $this->setToken($token);
            $this->setCertificate($certificate);
            $this->setPassword($password);
            $this->setTimeout($timeout);
        }
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->_token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getCertificate()
    {
        return $this->_certificate;
    }

    /**
     * @param string $certificate
     * @return $this
     */
    public function setCertificate($certificate)
    {
        $this->_certificate = $certificate;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->_timeout;
    }

    /**
     * @param int $timeout
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->_timeout = $timeout;
        return $this;
    }

}
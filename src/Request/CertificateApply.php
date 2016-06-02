<?php

namespace StartSSL\Request;

use StartSSL\Request;

class CertificateApply extends Request
{
    /*
     * tokenID
     * actionType
     * certType
     * domains
     * CSR
     * userID
     */

    /** @var string */
    protected $_type;

    /** @var string */
    protected $_csr;

    /** @var string */
    protected $_user;

    /** @var array */
    protected $_domains;

    /**
     * @inheritdoc
     */
    function getAction()
    {
        return 'ApplyCertificate';
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getCsr()
    {
        return $this->_csr;
    }

    /**
     * @param string $csr
     * @return $this
     */
    public function setCsr($csr)
    {
        $this->_csr = $csr;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @param string $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->_user = $user;
        return $this;
    }

    /**
     * @return array
     */
    public function getDomains()
    {
        return $this->_domains;
    }

    /**
     * @param array $domains
     * @return $this
     */
    public function setDomains($domains)
    {
        $this->_domains = $domains;
        return $this;
    }

}
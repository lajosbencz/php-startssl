<?php

namespace StartSSL\Request;

use StartSSL\Request;
use StartSSL\Response\CertificateApply as Response;

/**
 * @package StartSSL\Request
 * @method Response send()
 */
class CertificateApply extends Request
{
    const TYPE_DV = 'DVSSL';
    const TYPE_IV = 'IVSSL';
    const TYPE_OV = 'OVSSL';
    const TYPE_EV = 'EVSSL';

    protected $_data = [
        'CSR' => null,
        'domains' => null,
        'certType' => self::TYPE_DV,
        'userID' => '',
    ];

    /** @var array */
    protected $_domains = [];

    /**
     * @inheritdoc
     */
    function getAction()
    {
        return 'ApplyCertificate';
    }

    /**
     * @inheritdoc
     */
    function getFieldName()
    {
        return '';
    }


    /**
     * @return string
     */
    public function getType()
    {
        return $this->_data['certType'];
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->_data['certType'] = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->_data['CSR'];
    }

    /**
     * @param string $csr
     * @return $this
     */
    public function setSignature($csr)
    {
        if(strpos($csr,'-----BEGIN CERTIFICATE REQUEST-----') !== 0) {
            if(is_file($csr)) {
                $csr = file_get_contents($csr);
            } else {
                throw new \InvalidArgumentException('Invalid CSR, must be file path or PEM encoded CSR');
            }
        }
        $this->_data['CSR'] = $csr;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->_data['userID'];
    }

    /**
     * @param string $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->_data['userID'] = $user;
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
        $this->_data['domains'] = join(',', $this->_domains);
        return $this;
    }

    /**
     * @param string $domain
     * @param array $subDomains (optional)
     * @return $this
     */
    public function addDomain($domain, $subDomains=[]) {
        $this->_domains[$domain] = $domain;
        foreach($subDomains as $subDomain) {
            $subDomain = $subDomain . '.' . $domain;
            $this->_domains[$subDomain] = $subDomain;
        }
        $this->_data['domains'] = join(',', $this->_domains);
        return $this;
    }

    /**
     * @param string $domain
     * @return $this
     */
    public function removeDomain($domain) {
        if(isset($this->_domains[$domain])) {
            unset($this->_domains[$domain]);
        }
        $this->_data['domains'] = join(',', $this->_domains);
        return $this;
    }

}
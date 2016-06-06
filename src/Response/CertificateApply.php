<?php


namespace StartSSL\Response;


use StartSSL\Response;

class CertificateApply extends Response
{
    protected function _handle() { }

    public function getOrderId()
    {
        return $this->getData('orderID');
    }

    public function getOrderNumber()
    {
        return $this->getData('orderNo');
    }

    public function getOrderStatus()
    {
        return $this->getData('orderStatus');
    }

    public function getCertificate()
    {
        return $this->getData('certificate');
    }

    public function getCertificateMd5()
    {
        return $this->getData('certificateFieldMD5');
    }

    public function getIntermediateCertificate()
    {
        return $this->getData('intermediateCertificate');
    }

    public function getIntermediateCertificateMd5()
    {
        return $this->getData('intermediateCertificateFieldMD5');
    }

}
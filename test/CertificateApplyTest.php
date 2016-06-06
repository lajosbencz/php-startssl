<?php

namespace StartSSL_Test;

use StartSSL\Config;
use StartSSL\Request\CertificateApply;

class CertificateApplyTest extends \PHPUnit_Framework_TestCase
{
    public function testRequest()
    {
        $config = new Config(__DIR__ . '/fixture/config.ini');
        $request = new CertificateApply($config);
        $request->setSignature(file_get_contents(__DIR__ . '/fixture/lazos.me.csr'));
        $request->addDomain('test.'.md5(time()).'.lazos.me');
        $response = $request->send();
        $this->assertEquals(1, $response->getStatus());
        $this->assertEquals(0, $response->getErrorCode());
        $this->assertEquals('success', $response->getShortMessage());
        $this->assertEquals(2, $response->getOrderStatus());
        $this->assertEquals(md5($response->getCertificate()), $response->getCertificateMd5());
        $this->assertEquals(md5($response->getIntermediateCertificate()), $response->getIntermediateCertificateMd5());
    }
}

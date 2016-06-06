<?php

namespace StartSSL_Test;

use StartSSL\Certificate;

class CertificateTest extends \PHPUnit_Framework_TestCase
{
    public function testCertificate()
    {
        $path = realpath(__DIR__ . '/fixture/lazos@lazos.me.p12');
        $cert = Certificate::fromFileP12($path, 'p1c5kumST4');
        $this->assertEquals($path.'.crt', $cert->getPath());
        $this->assertStringStartsWith('-----BEGIN CERTIFICATE-----', $cert->getValue());
    }
}

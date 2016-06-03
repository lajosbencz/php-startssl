<?php

namespace StartSSL_Test;

use StartSSL\Config;
use StartSSL\Transport\Curl as CurlTransport;
use StartSSL\Transport\Stream as StreamTransport;
use StartSSL\TransportInterface;

class TransportTest extends \PHPUnit_Framework_TestCase
{
    public function provideData()
    {
        $base = Config::getDefault()->get('url');
        $transport = [
            new CurlTransport,
            new StreamTransport,
        ];
        $data = [
            [$base . '/', [], ['get' => [], 'post' => []]],
            [$base . '/?foo=bar', [], ['get' => ['foo' => 'bar'], 'post' => []]],
            [$base . '/?foo=bar', ['foo' => 'baz'], ['get' => ['foo' => 'baz'], 'post' => []]],
            [$base . '/?foo=bar', ['foo' => 'baz'], ['get' => ['foo' => 'baz'], 'post' => ['foo' => 'bar', 'baz' => 'bax']]],
            [$base . '/', ['foo' => 'baz'], ['get' => ['foo' => 'baz'], 'post' => ['foo' => 'bar', 'baz' => 'bax']]],
            [$base . '/', [], ['get' => [], 'post' => ['foo' => 'bar', 'baz' => 'bax']]],
        ];
        $r = [];
        foreach ($transport as $t) {
            foreach ($data as $d) {
                $r[] = [$t, $d[0], $d[1], $d[2]];
            }
        }
        return $r;
    }

    /**
     * @dataProvider provideData
     * @param TransportInterface $transport
     * @param string $url
     * @param array $query
     * @param array $data
     */
    public function testTransport($transport, $url, $query, $data)
    {
        $this->assertInstanceOf(TransportInterface::class, $transport);
        $transport->setUrl($url, $query);
        $transport->setPayload($data['post']);
        $this->assertEquals($data, $transport->getResponse());
    }

}

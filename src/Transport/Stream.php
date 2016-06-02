<?php

namespace StartSSL\Transport;

use StartSSL\Transport;

class Stream extends Transport
{
    function broker()
    {
        $this->_response = null;
        $h = parse_url($this->_url, PHP_URL_HOST);
        $c = [
            'http' => [
                'method' => 'GET',
                'header' => "Host: $h\r\nConnection: close\r\n",
            ],
        ];
        if ($this->_payload) {
            $d = is_array($this->_payload) ? http_build_query($this->_payload) : (string)$this->_payload;
            $l = strlen($d);
            $c['http']['method'] = 'POST';
            $c['http']['header'] .= "Content-Type: application/x-www-form-urlencoded\r\nContent-Length: $l\r\n";
            $c['http']['content'] = $d;
        }
        $c = stream_context_create($c);
        $s = @fopen($this->_url, 'r', false, $c);
        if (!is_resource($s)) {
            $e = error_get_last();
            $this->_error = $e['message'];
            $this->_errorCode = intval($e['type']);
            $this->_response = null;
        }
        $r = '';
        while (!feof($s)) {
            $r .= fgets($s, 4096);
        }
        if ($r) {
            $this->_response = $r;
        }
        @fclose($s);
        return $this->_response;
    }

}
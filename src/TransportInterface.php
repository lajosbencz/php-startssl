<?php

namespace StartSSL;

interface TransportInterface
{
    /**
     * @param string $url
     * @param array $query
     * @return $this
     */
    function setUrl($url, array $query = []);

    /**
     * @param array|null $payload
     * @return $this
     */
    function setPayload($payload);

    /**
     * @return $this
     */
    function broker();

    /**
     * @return string
     */
    function getError();

    /**
     * @return int
     */
    function getErrorCode();

    /**
     * @param bool $array
     * @return array|string|null
     */
    function getResponse($array = true);
}
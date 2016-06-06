<?php

namespace StartSSL;

interface RequestInterface
{
    /**
     * @return Config
     */
    function getConfig();

    /**
     * @return string
     */
    function getResponseName();

    /**
     * @return string
     */
    function getAction();

    /**
     * @return string
     */
    function getFieldName();

    /**
     * @param array $data
     * @return $this
     */
    function setData(array $data=[]);

    /**
     * @return ResponseInterface
     */
    function send();
}
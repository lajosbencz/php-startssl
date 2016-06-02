<?php

namespace StartSSL;

interface RequestInterface
{
    /**
     * @return Service
     */
    function getService();

    /**
     * @return string
     */
    function getResponseName();

    /**
     * @return string
     */
    function getAction();

    /**
     * @return ResponseInterface
     */
    function send();
}
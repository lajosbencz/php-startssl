<?php

namespace StartSSL;

interface ResponseInterface extends \ArrayAccess
{
    /**
     * @return RequestInterface
     */
    function getRequest();
}
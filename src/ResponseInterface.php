<?php

namespace StartSSL;

interface ResponseInterface extends \ArrayAccess
{
    /**
     * ResponseInterface constructor.
     * @param RequestInterface $request
     * @param array $response
     */
    function __construct(RequestInterface $request, array $response=[]);

    /**
     * @return RequestInterface
     */
    function getRequest();
}
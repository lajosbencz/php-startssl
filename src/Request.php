<?php

namespace StartSSL;

use ReflectionClass;

abstract class Request implements RequestInterface
{
    use ConfigTrait;

    /** @var array */
    protected $_data = [];

    /**
     * Request constructor.
     * @param Config $config
     */
    public function __construct(Config $config=null)
    {
        $this->setConfig($config ? : Config::getDefault());
    }

    /**
     * @inheritdoc
     */
    public function send()
    {
        $data = array_merge(['tokenID'=>$this->getConfig('token'),'actionType'=>$this->getAction()],$this->_data);
        $data = ['RequestData'=>json_encode($data, JSON_ERROR_UTF8)];
        $class = $this->getResponseName();
        $transport = $this->getConfig('transport');
        /** @var TransportInterface $transport */
        $transport = new $transport($this->getConfig());
        $transport->setUrl($this->getConfig('url'));
        $transport->setPayload($data);
        $transport->broker();
        $response = $transport->getResponse(true);
        if($response === null) {
            $response = $transport->getResponse(false);
            if($response) {
                if(strpos($response, '<title> no cert </title>') !== false) {
                    throw new Transport\Exception('No client certificate specified in config');
                }
                throw new Transport\Exception('Failed to broker transport');
            }
            if($transport->getError()) {
                throw new Transport\Exception($transport->getError(), $transport->getErrorCode());
            }
            $error = error_get_last();
            throw new Transport\Exception($error['message'], $error['type']);
        }
        if($response['status'] === 0 && $response['errorCode'] < 0) {
            throw new Exception(Exception::MESSAGES[$response['errorCode']], $response['errorCode']);
        }
        $response = new $class($this, $response);
        return $response;
    }

    /**
     * @return string
     */
    public function getResponseName()
    {
        static $name;
        if (!$name) {
            $ref = new ReflectionClass($this);
            $name = __NAMESPACE__ . '\\Response\\' . $ref->getShortName();
        }
        return $name;
    }

    /**
     * @inheritdoc
     */
    public function setData(array $data = [])
    {
        $this->_data = $data;
        return $this;
    }

}
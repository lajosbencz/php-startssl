<?php

namespace StartSSL;

class Certificate
{
    /** @var string */
    protected $_value;

    /** @var string */
    protected $_path = '';

    /** @var string */
    protected $_password = '';

    /** @var bool */
    protected $_temporary = false;

    public static function fromString($value, $path='')
    {
        $c = new self;
        $c->_value = $value;
        $c->_path = $path;
        $c->_temporary = false;
        return $c;
    }

    public static function fromFilePEM($path, $password='')
    {
        $real = realpath($path);
        if(!$real) {
            throw new \InvalidArgumentException('No such file: '.$path);
        }
        $value = file_get_contents($real);
        $c = self::fromString($value, $real);
        $c->_password = $password;
        $c->_temporary = false;
        return $c;
    }

    public static function fromFileP12($path, $password='')
    {
        $real = realpath($path);
        if(!$real) {
            throw new \InvalidArgumentException('No such file: '.$path);
        }
        if(!openssl_pkcs12_read(file_get_contents($real), $certs, $password)) {
            throw new Exception(openssl_error_string());
        }
        if(count($certs)<1) {
            throw new Exception('Failed to parse P12 file: '.$path);
        }
        if(!openssl_pkey_export($certs['pkey'], $pkey, $password)) {
            throw new Exception(openssl_error_string());
        }
        $value = $certs['cert'].PHP_EOL.$pkey;
        $path = $real.'.crt';
        if(is_file($path)) {
            unlink($path);
            touch($path);
            chmod($path, 0600);
        }
        file_put_contents($path, $value);
        $c = self::fromFilePEM($path, $password);
        $c->_temporary = true;
        return $c;
    }

    private function __construct() { }

    public function __destruct()
    {
        if($this->_temporary && is_file($this->_path)) {
            unlink($this->_path);
        }
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->_path;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

}
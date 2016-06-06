<?php


namespace StartSSL;


use StartSSL\Transport\Curl;

class Config extends \ArrayObject
{
    const DEFAULTS = [
        'token' => null,
        'certificate' => null,
        'password' => null,
        'debug' => false,
        'timeout' => 120,
        'url' => 'https://apitest.startssl.com',
        'transport' => Curl::class,
    ];

    /** @var self */
    private static $_instance;

    /**
     * @return self
     */
    public static function getDefault()
    {
        if(!self::$_instance) {
            self::$_instance = new self(self::DEFAULTS);
        }
        return self::$_instance;
    }

    /**
     * Get normalized name for config index
     * @param string $offset Name of config index
     * @param string|bool $prefix false: Lowercase first. true: Uppercase first. string: Uppercase first and prepend string.
     * @return string
     */
    public static function Name($offset, $prefix=false)
    {
        $r = trim($offset);
        $l = strlen($r);
        foreach(['-','_','.',' '] as $delimiter) {
            $p = 0;
            while($p<$l && ($p=strpos($r, $delimiter, $p)) !== false) {
                if(++$p==$l) {
                    break;
                }
                $r[$p] = strtoupper($r[$p]);
                $r = substr($r,0, $p-1) . strtoupper($r[$p]) . substr($r, min($l,$p+1));
                $l--;
            }
        }
        if($prefix) {
            $r = ucfirst($r);
            if(is_string($prefix) && strlen($prefix) > 0) {
                $r = $prefix . $r;
            }
        } else {
            $r = lcfirst($r);
        }
        return $r;
    }

    /** @var Certificate */
    protected $_certificate;

    public function __construct($input=[], $flags=0, $iterator_class = 'ArrayIterator')
    {
        $file = false;
        if(is_string($input) && substr($input, -4, 4) == '.ini' && is_file($input)) {
            $file = realpath($input);
            $input = parse_ini_file($file, true);
        }
        if(is_array($input)) {
            $i = [];
            foreach($input as $k => $v) {
                $i[self::Name($k)] = $v;
            }
            $input = $i;
        } else {
            $input = [];
        }
        if(!self::$_instance) {
            self::$_instance = $this;
            $input = array_merge(self::DEFAULTS, $input);
        }
        parent::__construct($input, $flags, $iterator_class);
        if(isset($input['certificate']) && $input['certificate'][0] != DIRECTORY_SEPARATOR && $file) {
            $input['certificate'] = realpath(dirname($file) . DIRECTORY_SEPARATOR . $input['certificate']);
        }
        if(substr($input['certificate'],-4,4) == '.p12') {
            $this->_certificate = Certificate::fromFileP12($input['certificate'], $input['password']);
        }
        else {
            $this->_certificate = Certificate::fromFilePEM($input['certificate']);
        }
    }

    public function offsetExists($index)
    {
        return parent::offsetExists(self::Name($index));
    }

    public function offsetGet($index)
    {
        if($index == 'certificate') {
            return $this->_certificate;
        }
        return parent::offsetGet(self::Name($index));
    }

    public function offsetSet($index, $value)
    {
        parent::offsetSet(self::Name($index), $value);
    }

    public function offsetUnset($index)
    {
        parent::offsetUnset(self::Name($index));
    }

    public function get($name, $default=null)
    {
        if($this->offsetExists($name)) {
            return $this->offsetGet($name);
        }
        if($default === null && array_key_exists($name, self::DEFAULTS)) {
            return self::DEFAULTS[$name];
        }
        return $default;
    }

}
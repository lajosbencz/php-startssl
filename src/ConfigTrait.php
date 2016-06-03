<?php


namespace StartSSL;


trait ConfigTrait
{
    /** @var Config */
    private $__configTrait_config = null;

    /**
     * @param string $name
     * @param mixed $default
     * @return Config|mixed|null
     */
    public function getConfig($name=null, $default=null)
    {
        if(!$this->__configTrait_config) {
            $this->__configTrait_config = Config::getDefault();
        }
        if($name) {
            return $this->__configTrait_config->get($name, $default);
        }
        return $this->__configTrait_config;
    }

    /**
     * @param Config $config
     * @return $this
     */
    public function setConfig(Config $config)
    {
        $this->__configTrait_config = $config;
        return $this;
    }
}
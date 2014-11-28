<?php
namespace UnidUser\Options;

use Zend\Stdlib\AbstractOptions;
use ZendTest\XmlRpc\Server\Exception;

class ModuleOptions extends AbstractOptions  {


    protected $config;

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     * @return (string)
     */

    public function getFormRedirect($param)
    {

        if(isset($this->config['form_redirect'][$param]))
        {
            return $this->config['form_redirect'][$param];
        }else {
            throw new Exception('Not parametr ['. $param. '] in uniduser.config.php');
        }


    }

    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    function __construct($config)
    {
        self::setConfig($config);
    }
    function __invoke()
    {
        return $this->config;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 28.11.2014
 * Time: 14:00
 */

namespace unid\Controller;


use Zend\Mvc\Controller\AbstractActionController;

abstract class  unidControllerAbstract extends AbstractActionController {

    protected $adapter;
    protected $user;

    function __construct($user,$adapter)
    {
        $this->user = $user;
        $this->adapter = $adapter;
    }
    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
    /**
     * @return mixed
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param mixed $adapter
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
    }




} 
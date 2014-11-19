<?php
namespace unid\Model;
use unid\Model\Data;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

/** @return Data $user */
class Autorization extends  UserStorage
{
    protected  $key;
    const COOKIE_KEY = 'login';
    function __construct()
    {
        parent::__construct();
        parent::setRememberMe(1);
        $this->key = (isset($_COOKIE[self::COOKIE_KEY]))?$_COOKIE[self::COOKIE_KEY]:'user';

    }
    public function autorization($Adapter, Data $user)
    {
        $UserTable = new UserTable($Adapter);
        $obj = $UserTable->get(array('login'=>$user->login, 'password'=>$user->password))->current();
        if(is_object($obj)){
            self::setUser($obj);
            return true;
        } else {
            return false;
        }


    }
    function appendParam($key, $value){
        $obj = parent::get($this->key);
        $obj->set($key,$value);
        parent::set($this->key, $obj);
    }

    // name = 'user'
    function setUser(Data $user)
    {
        parent::set($this->key , $user);
    }
    function is_vars(){
        $user = parent::get( $this->key );
        return isset($user);
    }
    function get($name = null)
    {
        return parent::get($this->key);
    }
    function logout(){
        parent::forgetMe();
        parent::delete($this->key);
    }




}
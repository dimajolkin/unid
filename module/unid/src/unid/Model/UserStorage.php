<?php
namespace unid\Model;

use Zend\Authentication\Storage;

class UserStorage extends Storage\Session
{
    /** @method install time live */

    public function setRememberMe($rememberMe = 0, $time = 1209600)
    {
        if ($rememberMe == 1) {
            $this->session->getManager()->rememberMe($time);
        }
    }

    public function  set($name,$val){
        // name = 'user'
        //if(isset($_COOKIE['login']));
        $this->session[ $name ] = $val;
    }

    public  function get($name){
        if(isset($this->session[$name]))
        {
            return $this->session[$name];
        }
        else
        {
            return null;
        }
    }
    public function forgetMe()
    {
        $this->session->getManager()->forgetMe();
    }
    public function delete($name)
    {
        $this->session[$name] = null;
    }

}
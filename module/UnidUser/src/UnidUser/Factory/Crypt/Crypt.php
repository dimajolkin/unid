<?php
namespace UnidUser\Factory\Crypt;

use Zend\Crypt\Password\PasswordInterface;

class Crypt implements PasswordInterface {


    function __construct()
    {
    }

    public function create($password)
    {

    }

    public function verify($password, $hash)
    {
        return $password == $hash;

    }
} 
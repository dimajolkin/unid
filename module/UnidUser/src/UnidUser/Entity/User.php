<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 25.11.2014
 * Time: 2:45
 */
namespace UnidUser\Entity;

use ZendTest\XmlRpc\Server\Exception;
use ZfcUser\Entity\UserInterface;
/**
 * Class User
 * @package UnidUser\Entity
 */
class User  implements  UserInterface  {

    protected $id;
    /**
     * @var
     */
    protected $login;
    /**
     * @var
     * <p>Идентификатор нашего преподавателя
     */
    protected $familie;
    /**
     * @var
     * <p>Фамилия
     */
    protected $name;
    /**
     * @var
     * Имя
     */
    protected $gname;
    /**
     * @var
     * Отчество
     */
    protected $email;
    /**
     * @var
     *
     */
    protected $password;
    /**
     * @var
     */
    protected $position;
    /**
     * @var
     * Должность
     */
    protected $salary;
    /**
     * @var
     * ставка
     */
    protected $Y_O_T;

    /**
     * @return mixed
     * условия оплаты труда
     */
    public function getYOT()
    {
        return $this->Y_O_T;
    }

    /**
     * @param mixed $Y_O_T
     */
    public function setYOT($Y_O_T)
    {
        $this->Y_O_T = $Y_O_T;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param mixed $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }


    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param mixed $email
     * @return UserInterface
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param mixed $familie
     * @return UserInterface
     */
    public function setFamilie($familie)
    {
        $this->familie = $familie;
    }

    /**
     * @param mixed $gname
     * @return UserInterface
     */
    public function setGname($gname)
    {
        $this->gname = $gname;
        return $this;
    }

    /**
     * @param mixed $id
     * @return UserInterface
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param mixed $name
     * @return UserInterface
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $password
     * @return UserInterface
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getFamilie()
    {
        return $this->familie;
    }

    /**
     * @return mixed
     */
    public function getGname()
    {
        return $this->gname;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->familie;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->familie. ' '.$this->name.' '.$this->gname;
    }

    /**
     * Get password.
     *
     * @return string password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return 0;
    }

    public function __get($name)
    {

        if(is_string($name))
        {
            return $this->$name;
        }else throw new Exception("");


    }

}
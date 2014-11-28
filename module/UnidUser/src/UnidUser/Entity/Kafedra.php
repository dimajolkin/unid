<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 27.11.2014
 * Time: 11:56
 */

namespace UnidUser\Entity;


use ZfcUser\Entity\UserInterface;

/**
 * Class Kafedra
 * @package UnidUser\Entity
 */
class Kafedra implements UserInterface {
    /**
     * @var
     */
    protected $id;
    /**
     * @var
     */
    protected $id_kaf;
    /**
     * @var
     */
    protected $name_kaf;
    /**
     * @var
     */
    protected $password;
    /**
     * @var
     */
    protected $zav_kaf;
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
        return $this->id_kaf;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail(){}

    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->name_kaf;
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
    public function getState(){}

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
     * @param mixed $id_kaf
     * @return UserInterface
     */
    public function setIdKaf($id_kaf)
    {
        $this->id_kaf = $id_kaf;
        return $this;
    }

    /**
     * @param mixed $name_kaf
     * @return UserInterface
     */
    public function setNameKaf($name_kaf)
    {
        $this->name_kaf = $name_kaf;
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
     * @param mixed $zav_kaf
     * @return UserInterface
     */
    public function setZavKaf($zav_kaf)
    {
        $this->zav_kaf = $zav_kaf;
        return $this;
    }



} 
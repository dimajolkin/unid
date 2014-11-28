<?php
namespace UnidUser\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Stdlib\Hydrator\HydratorInterface as Hydrator;
use ZfcUser\Mapper\UserInterface;

class Kafedra extends AbstractDbMapper implements UserInterface {



    public function __construct()
    {
//        $this->setTableName('kafedra');
//        $this->setEntityPrototype(new \ZfcUser\Entity\User());
    }
    public function findByEmail($email)
    {
        $select = $this->getSelect()
            ->where(array('email' => $email));

        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }

    //username == id_kaf
    public function findByUsername($username)
    {
        self::setTableName('kafedra');


        $select = $this->getSelect($this->tableName)
            ->where(array('id_kaf' => $username));
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }

    public function findById($id)
    {
        $select = $this->getSelect()
            ->where(array('id' => $id));

        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName($tableName)
    {
        $this->tableName=$tableName;
    }

    public function insert($entity, $tableName = null, Hydrator $hydrator = null)
    {
        $hydrator = $hydrator ?: $this->getHydrator();
        $result = parent::insert($entity, $tableName, $hydrator);
        $hydrator->hydrate(array('user_id' => $result->getGeneratedValue()), $entity);
        return $result;
    }

    public function update($entity, $where = null, $tableName = null, Hydrator $hydrator = null)
    {
        if (!$where) {
            $where = array('user_id' => $entity->getId());
        }

        return parent::update($entity, $where, $tableName, $hydrator);
    }


} 
<?php
namespace unid\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature;
use Zend\Mvc\MvcEvent;

use Zend\Db\Sql\Select;
use unid\Model\DataTable;
use Zend\Db\Sql\Predicate\Predicate;

class UserTable extends DataTable
{

    public function __construct($dbAdapter, $table ='users' )
    {
       parent::__construct($dbAdapter, $table);
    }
    function getUser($user)
    {
        return parent::get(array('login'=>$user->login, 'password'=>$user->password))->current();

    }

    function getKafedra($login){
       $select = new Select();
        $select->from('users')
           // ->where->equalTo('login',$login)
            ->join('skafedra','users.login = skafedra.login',Select::SQL_STAR,Select::JOIN_LEFT)
            ->join('kafedra','skafedra.id_kaf = kafedra.id_kaf',Select::SQL_STAR,Select::JOIN_LEFT)
            ->where->equalTo('users.login',$login);
        $res = $this->tableGateway->selectWith($select);
        foreach($res as $obj){
            return $obj;
        }
        return $res;
    }
//       function save(Data $user, $bool = true ){
//
//
//    }
    function update(Data $user){
        $this->tableGateway->update( $user->get() , array('login' => $user->login));
    }





}
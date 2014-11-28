<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 02.08.14
 * Time: 0:47
 */

namespace unid\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature;
use Zend\Mvc\MvcEvent;
use unid\Model\Personal;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Predicate\Predicate;
class SoavtorTable extends DataTable  {
    /** Find user */

    function __construct($Adapter, $name_table){
        parent::__construct($Adapter,$name_table);
    }


    public function Search($text, $base_row, Data $user )
    {
        $select = new Select($this->tableGateway->getTable());

        $select->where
            ->equalTo('year',$user->get('__year'));

        $select->where->like($base_row, $text.'%');

        return $this->tableGateway->selectWith($select);
    }

    public function getTableSoavtor(Data $tableinfo, Data $user)
    {
        $t2 = $tableinfo->get('soavtor');
        $select  = new Select($this->tableGateway->getTable());
        $select
            ->join($t2, $t2.'.id_doc=id')
            ->where->equalTo($t2.'.login',$user->get('login'));

        return $this->tableGateway->selectWith($select);
    }
    /** @params table table, id_row  */
    public function getListSoavtor($id)
    {
        $name_table = $this->tableGateway->getTable();

        $select = new Select($name_table);
        $select->join('users','users.login='.$name_table.'.login')
            ->where->equalTo('id_doc',$id);

        return $this->tableGateway->selectWith($select);
    }
    /** */


} 
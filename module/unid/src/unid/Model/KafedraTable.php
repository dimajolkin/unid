<?php
namespace unid\Model;
use unid\Model\Data;
use Zend\Db\Sql\Delete;
use Zend\Db\TableGateway\TableGateway;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature;
use Zend\Mvc\MvcEvent;
use unid\Model\Personal;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Predicate\Predicate;
class KafedraTable extends  DataTable
{
    protected  $id_kafedra;

    protected $TableInfo;
    public $Personal;
    private function   AddRowFio($result){
        $array = array();
        foreach($result as $obj){
            $login = $obj->get('login');
            $obj->set('FIO', $this->Personal->getFIO($login));
            array_push($array, $obj);
        }
        return $array;

    }


    function __construct($Adapter, $nametable, $id_kaf = null){
        if(!is_object($nametable))
            parent::__construct($Adapter,$nametable);
        else {
            $this->TableInfo = $nametable;
            parent::__construct($Adapter, $nametable->name_table);

        }
        $this->id_kafedra = $id_kaf;

    }
    function fetchAll($year = null)
    {
        if(strpos(' '.$this->TableInfo->name_table,'kaf')){

            if($year == null){
                return self::getListKaf($this->id_kafedra, $this->TableInfo->year);
            } else {
                return self::getListKaf($this->id_kafedra,$year);
            }


        }else {
            $Personal = new Personal($this->tableGateway->getAdapter(),$this->id_kafedra);

            if($year == null ){

                return self::getList($Personal->getLogins(), $this->TableInfo->year);
            }
            else
                self::getList($Personal->getLogins(), $year);
        }
    }
    function LoadPersonal(){
        $this->Personal =  new Personal($this->tableGateway->getAdapter(), $this->id_kafedra);
    }

    public function  getPersonal($id_kaf = null){

        $select = new Select($this->tableGateway->getTable());
        $select->join('users','skafedra.login = users.login');
        $Predicate = new Predicate();
        // $Predicate->in('id_kaf',$id_kaf);

        if($id_kaf == null){
            $id_kaf = $this->id_kafedra;
        }

        $select->where->in('id_kaf',array($id_kaf));
        //$select->where->equalTo('id_kaf', $id_kaf);
        // $select->where($Predicate);
        // var_dump($select->getSqlString());
        return $this->tableGateway->selectWith($select);
    }


    public function remove_personal($login)
    {
//             $select = new Delete('skafedra');
//             $select->where->equalTo('login',$login)->and->equalTo('id_kaf', $this->id_kafedra);
        var_dump($login);
        var_dump($this->id_kafedra);

        $this->tableGateway->delete(array('login'=>$login, 'id_kaf'=>$this->id_kafedra));

    }

    public function getListKaf($id_kaf, $year){
        $name_table = $this->tableGateway->getTable();
        $select = new Select( $name_table );

        $select->where(array(
            'id_kaf' => $id_kaf,
            'year'=>$year
        ));


        self::LoadPersonal();
        return self::AddRowFio( $this->tableGateway->selectWith($select) );

    }
    public function getList($logins,$year)
    {
        //var_dump($this->tableGateway->getTable());

        $name_table = $this->tableGateway->getTable();
        $select = new Select( $name_table );

        $select->where(array(
            'login' => $logins,
            'year'=>$year
        ));


        self::LoadPersonal();
        return self::AddRowFio( $this->tableGateway->selectWith($select) );

    }
//    public function save(Data $data, $bool = true)
//    {
//        if ( !$data->in_vars('id_kaf') )
//        {
//            $this->tableGateway->insert( $data->get() );
//        }
//        else {
//
//            $id = (int)$data->id;
//            if ($this->getTable($id)) {
//                $this->tableGateway->update( $data->get() , array('id_kaf' => $id));
//            } else {
//                throw new \Exception('Form id does not exist');
//            }
//        }
//    }



}
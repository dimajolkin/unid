<?php
namespace unid\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature;
use Zend\Mvc\MvcEvent;
use unid\Model\Data;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Predicate\Predicate;

class DataTable
{
    protected $tableGateway;


    public function __construct($dbAdapter, $name_table )
    {
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Data());
        $this->tableGateway =  new TableGateway($name_table, $dbAdapter, null, $resultSetPrototype);
    }


    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getTable($id){

        if(is_numeric($id)){
            return $this->tableGateway->select(array('id'=>$id))->current();
        } elseif(is_array($id)){
            $select = new Select($this->tableGateway->getTable());
            $select->where(array(
                'id'=>$id
            ));
            return $this->tableGateway->selectWith($select);
        }



    }


    function convert($objects, $params){

        $object_summ  = null;
         if(count($objects) != 1)
         {
             foreach($objects as $obj){
                 if(!$object_summ){
                     $object_summ = $obj;
                 }else {
                     $object_summ->append($obj);
                 }
             }
         } else {
             $object_summ = $objects;
         }

        foreach($params['convert'] as $pole => $func_convert){
            $convert_pole = '';
            //Убрать повторение как нибудь
            foreach(@explode(' ', $object_summ->$pole) as $key){
                $convert_pole .= $func_convert(
                    new Personal($this->tableGateway->getAdapter()),
                    trim($key)
                );
            }
            var_dump($object_summ);
            $object_summ->$pole = $convert_pole;
        }

        $new_obj = new Data();
        $data = array();
        foreach($params['pravilo'] as $table1 => $table2){
            $new_obj->exchangeArray(array($table2=>$object_summ->$table1));
        }

        return $new_obj;
    }

    public function get($array, $limit = null, $sort = null){
        if($sort == null)
        {
            return $this->tableGateway->select($array);
        } else {
            $name_table = $this->tableGateway->getTable();
            $select = new Select($name_table);
            $select->order($sort)->where($array);
            //$select->join('users','users.login='.$name_table.'.login')
             //   ->where->equalTo('id_doc',$id);

            return $this->tableGateway->selectWith($select);
        }

    }

    public function getlast(){

        return $this->tableGateway;
    }

    public function save(Data $data, $bool = true)
    {
        if ( !$data->in_vars('id') )
        {
            $this->tableGateway->insert( $data->get() );
        }
        else {

            $id = (int)$data->id;
            if ($this->getTable($id)) {
                $this->tableGateway->update( $data->get() , array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }



    public function FindUser($text)
    {
        $text = explode(' ', str_replace(",", "", trim($text)));
        $select = new Select('users');
        $rows = array('familie','name','gname');
        // $select->where->equalTo('familie', 'Копейкина');
        $select->limit(15);
        return $this->tableGateway->selectWith($select);
    }

    public function FindData($pole , $text_search, $limit = null){
        $text = explode(' ', str_replace(",", "", trim($text_search)));

        $select = new Select($this->tableGateway->getTable());

        $Predicate = new Predicate();
        if(is_array($text))
        {

            if(is_array($pole))
            {
                for($j=0;$j<count($pole)-1;$j++)
                {
                    for($i=0;$i<count($text)-1;$i++)
                        $Predicate->like($pole[$j], $text[$i].'%')->or;
                    $Predicate->like($pole[$j], $text[count($text)-1].'%')->or;

                }
                $j = count($pole)-1;
                for($i=0;$i<count($text)-1;$i++)
                    $Predicate->like($pole[$j], $text[$i].'%')->or;
                $Predicate->like($pole[$j], $text[count($text)-1].'%');



            } elseif(is_string($pole)){

                for($i=0;$i<count($text)-1;$i++)
                    $Predicate->like($pole, $text[$i].'%');
                $Predicate->like($pole, $text[count($text)-1].'%');

            }

            if($limit == null)
                $select->where($Predicate);
            else {
                if(is_numeric($limit))
                {
                    $select->where($Predicate)->limit((int)$limit);
                } else throw new \Exception('Limit not parametr ( numberic )');

            }

            return $this->tableGateway->selectWith($select);
        } else {
            return $this->tableGateway->select(array($pole=>$text_search));
        }


    }

    public function delete($id)
    {
        if(!is_array($id))
        {
            $this->tableGateway->delete(array('id'=>$id));
        }
        else {
            $this->tableGateway->delete($id);
        }

    }

}
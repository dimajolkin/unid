<?php
namespace unid\Controller;

use unid\Model\Autorization;
use Zend\Mvc\Controller\AbstractActionController;

use unid\Model\Data;
use unid\Model\DataTable;
use unid\Model\UserStorage;

use Zend\View\Model\ViewModel;

class BaseActionController extends AbstractActionController
{
    protected $user;
    protected $Autoriz;
    public $tableInfo;

    function __construct()
    {


            $Auth = new Autorization();
            // var_dump($Auth->get());
            if( $Auth->get() != null ){

                $this->user = $Auth->get();
            } else
            {
                //$this->redirect()->toRoute('home');
                header("Location: / ");
            }

    }



    function MessageStorgate()
    {
        $storgate_msg = new UserStorage();
        if($storgate_msg->get('message')){
            $this->flashMessenger()->addSuccessMessage($storgate_msg->get('message'));
            $storgate_msg->delete('message');
        }
        return $storgate_msg;
    }

    function getAdapter(){
        return $this->getServiceLocator()->get('Adapter');
    }
    function appendJavaScript($file_name = null){
        $script = $this->getServiceLocator()->get('viewhelpermanager')->get('inlineScript');

        if($file_name == null){
            $array = explode("\\",get_called_class());
            $catalog = substr( $array[2],0,-10);
            $file_name = $catalog.'/'.$this->params('action');
            $script->appendFile('/js/'.$file_name.'.js');
        } else {
            $script->appendFile('/js/'.$file_name.'.js');
        }

    }

    function getYear($tableInfo = null){

        if($tableInfo == null){
            $tableInfo = $this->tableInfo;
        }

        //$user = $this->__get('user');
        $user = $this->user;
        if(isset($user))
        {
            $year = $this->user->get('__year'); //настраиваем год с которым мы работаме ели это план то  +1
            if(is_object($tableInfo))
            {
                if($tableInfo->get('group_') == 'План') $year++; // собственно вот и оно
            }
        } else throw new \Exception('User not in Storgate');

        return $year;
    }

    function getStrucureTab(Data $tableinfo){
        $array = $this->getServiceLocator()->get('unid.config');
        $conf =$array['tabs'];
        if(!isset($conf[get_called_class()][$tableinfo->name_table])){
            return $conf['default'];
        }else {
            return $conf[get_called_class()][$tableinfo->name_table];
        }
    }
    function getTableInfo($id)
    {
        if($id  != null)
        {
            $obj =  $this->getTable('__structure_menu')->getTable( $id );
            if(is_object($obj))
            {
//                try
//                {
                   $year = $this->getYear($obj);
                    $obj->year = $year;
                    $list_boss_cell = explode(',',$obj->boss_row);

                    $struct_table = $this->getTable('__structure_stable')->get(array('table_'=>$obj->name_table));

                    $array_struct = array();
                    foreach($struct_table as $cell){
                        $array_struct[$cell->cell] = $cell->cap;
                    }

                    $array = array();
                    foreach($list_boss_cell as $key => $val)
                    {       $val = trim($val);

                        $array[$val] = $array_struct[$val];
                    }

                    $obj->boss_row = $array;


                    return $obj;
//                } catch(\Exception $e){
//                    throw new \Exception( $e->getLine() . ' tableinfo getTableInfo()' );
//                }

            } else return false;

        } else {
            throw new \Exception('getTableInfo: id == null');
        }

    }

    function getTable($name_table)
    {
        $adapter = $this->getServiceLocator()->get('Adapter');
        $this->Table = new DataTable($adapter, $name_table);
        return $this->Table;
    }

}
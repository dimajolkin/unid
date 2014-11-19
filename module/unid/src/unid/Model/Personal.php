<?php
namespace unid\Model;
use unid\Model\KafedraTable;


class Personal extends Data
{

    function __construct($Adapter, $id_kafedra = null){


        $personal = null;
        if($id_kafedra == null){
            $DataTable =  new DataTable($Adapter, 'users');
            $personal = $DataTable->fetchAll();
        }else {

            $Tpersonal = new KafedraTable(
                $Adapter,
                'skafedra', //сотрудники
                $id_kafedra
            );
            $personal = $Tpersonal->getPersonal();
        }

        foreach($personal as $user){
            $this->set($user->get('login'), $user);
        }
    }

    function getLogins(){
        $res = array();
        foreach($this->vars as $key=>$obj){
            array_push($res, $key);
        }
        return $res;
    }
    function getFIO($login){
        $obj =  $this->get($login);
        if(is_object($obj)){
            return $obj->get(array('familie','name','gname'));
        }
    }
    function FindUser($login)
    {
        return $this->get($login);
    }



}
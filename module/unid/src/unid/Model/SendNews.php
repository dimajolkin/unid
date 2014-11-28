<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 07.10.14
 * Time: 14:24
 */

namespace unid\Model;
use unid\Model\Data;

class SendNews extends DataTable {

    function __construct($dbAdapter){
        parent::__construct($dbAdapter, 'news');
    }


    function send($cap,$text,$login){
          $data = new Data();
         $data->exchangeArray(array(
             'login'=>$login,
             'text'=>$text,
             'cap'=>$cap
         ));
        parent:: save($data);

    }
    function add(){

    }


} 
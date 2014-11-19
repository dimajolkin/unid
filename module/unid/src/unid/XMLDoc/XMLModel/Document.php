<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 18.08.14
 * Time: 0:22
 */

namespace XMLModel;

use XMLModel\Base\XMLTeg;

class Document {
    protected  $str;
    function __construct($verion = '1.0', $progind = 'Excel.Sheet'){
        $this->str = '<?xml version="'.$verion.'"?>';
        $this->str.= '<?mso-application progid="'.$progind.'"?>';
    }

    function append(XMLTeg $teg){
        $this->str .=$teg->result();
    }

   function result(){
       return $this->str;
   }

} 
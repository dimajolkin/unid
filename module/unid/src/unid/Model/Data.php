<?php
namespace unid\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/** @class универсальный переносник моделей */
class Data
{
    //базовые параметры для добавления
    protected  $vars;


    public function __construct($data = null){
        if($data != null)
        {

            self::exchangeArray($data);
        } else {
            $this->vars = null;
        }

    }
    public function append(Data $obj){

        foreach($this->vars as $key=>$val)
        {
//            if(!is_numeric($val))
            if(!empty($val))
                self::set($key, $val .' '. $obj->get($key) );
            else
                self::set($key, $val . $obj->get($key) );
//            else self::set($key, $val + $obj->get($key) );
        }
    }



    function remove($key){
        unset($this->vars[$key]);
    }

    public function __get($name){
        if(self::in_vars($name)){
            return $this->vars[$name];
        }
        return null;
    }
    public function __set($name,$value){
        self::set($name, $value);
    }
    public function exchangeArray($data)
    {

        foreach($data as $var => $value){
            if(is_array($value))
            {
                $str = '';
                foreach($value as $key => $param)
                    if(is_string($key))
                    {
                        if($param) $str .= $key.', ';
                    }elseif(is_numeric($key)){
                        if(!empty($param))
                        $str.= $param.', ';
                    }
               $str = substr($str, 0, -2);
                self::__set($var, $str);

            }elseif(!empty($value)) {
                self::__set($var,$value);
                // $this->vars[$var] = $value;
            }
            else {
                self::__set($var, '');
                //$this->vars[$var] = '';
            }
        }

        self::remove('button');

    }
    public function get($key = null,$str = ' ')
    {

        if($key == null)
            return $this->vars;
        else
            if(is_string($key))
            {
                if( isset( $this->vars[ $key ]))
                {
                    return $this->vars[ $key ];
                } else
                {
                    return false;
                }
            }
        if(is_array($key))
        {
            $result  = '';
            foreach($key as $var)
            {
                $result.=$this->get($var).$str;
            }
            return $result;
        }
    }
    public function set($key, $value ){
        $this->vars[ $key ] = $value;
    }

    public function in_vars($variable)
    {
        if(isset( $this->vars[ $variable ] ))
            return true;
        else return false;
    }
    public function size(){
        return count($this->vars);
    }

    public function fetchAll($params = 'value'){
        $array = array();
        if(isset($this->vars))
            foreach($this->vars as $key => $val)
                array_push($array, $val);

        return $array;
    }
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new Exception("Not used");
    }

    public function getInputFilter()
    {

    }
}
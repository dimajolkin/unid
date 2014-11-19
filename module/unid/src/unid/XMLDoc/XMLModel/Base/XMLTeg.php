<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 18.08.14
 * Time: 0:10
 */

namespace XMLModel\Base;


class XMLTeg {
//    const STYLE = 'Style';
//    const Alignment = 'Alignment';
//    const Borders = 'Borders';

    protected $type;
    protected $content;
    protected $attr = '';

    function __construct($attr = null,$content = null){

        $mas = explode("\\", get_called_class() );

        $this->type = $mas[count($mas)-1];
        //var_dump($mas)
        if($attr != null)
            self::attr($attr);
        if($content!=null)
            self::content($content);

    }


    public  function attr($attr){
        if(is_array($attr)){
            foreach($attr as $key => $val){
                $this->attr.= $key.'="'.$val.'"  ';
            }
        }elseif(is_string($attr)){
            $this->attr.= $attr;
        }
        return $this;
    }
    public  function content($content){
        if(is_numeric($content)){
            $this->content = $content;
        }elseif(is_string($content))
            $this->content = $content;
        elseif(is_object($content))
        {
            $this->content.=$content->result()."\n";

        }elseif(is_array($content))
        {
            foreach($content as $obj){
                //  var_dump($obj);
                $this->content.=$obj->result()."\n";
            }
        }

return $this;

}

function result(){

    if(($this->attr == null) && ($this->content == null)){
        return '<'.$this->type.'/>';
    }elseif(($this->attr!= null) && ($this->content == null)){
        return '<'.$this->type.' '.$this->attr.'/>';
    } else {
        return '<'.$this->type.' '.$this->attr.'>'
        ."\n"
        .$this->content
        .'</'.$this->type.'>';
    }



}
} 
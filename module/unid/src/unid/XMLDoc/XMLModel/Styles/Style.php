<?php
namespace XMLModel\Styles;

use XMLModel\Base\XMLTeg;


class Style extends XMLTeg {


    const ID = 'ss:ID';
    const NAME = 'ss:Name';

    static  function DefaultValue($type){
        $value = array(
            self::ID => 'Default',
            self::NAME=>'Normal',
        );
        return $value[$type];
    }


} 
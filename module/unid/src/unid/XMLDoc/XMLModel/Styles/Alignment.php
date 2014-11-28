<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 18.08.14
 * Time: 0:18
 */
namespace XMLModel\Styles;

use XMLModel\Base\XMLTeg;

class Alignment extends XMLTeg {
    const Vertical = 'ss:Vertical';
    const  Horizontal = 'ss:Horizontal';
    const WrapText = 'ss:WrapText';
    static  function DefaultValue($type){
        $value = array(
            self::Vertical => 'Bottom', //Center
            self::Horizontal => 'Center'
        );
        return $value[$type];
    }


}
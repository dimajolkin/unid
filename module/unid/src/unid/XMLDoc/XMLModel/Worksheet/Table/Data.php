<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 18.08.14
 * Time: 23:49
 */

namespace XMLModel\Worksheet\Table;

use XMLModel\Base\XMLTeg;

class Data extends XMLTeg {
    const Type = 'ss:Type';
    function text($text){
        parent::attr(array(self::Type=>'String'));
        parent::content($text);
    }
} 
<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 18.08.14
 * Time: 1:14
 */
namespace XMLModel\Styles;

use XMLModel\Base\XMLTeg;

//<Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="8" ss:Color="#000000"/>
class Font extends XMLTeg{


    const FontName = 'ss:FontName';
    const CharSet = 'x:CharSet';
    const Family = 'x:Family';
    const Size = 'ss:Size';
    const Color = 'ss:Color';
    const Bold = 'ss:Bold';


    static  function DefaultValue($type){
        $value = array(
            self::FontName => 'Calibri',
            self::CharSet=>'204',
            self::Family=>'Swiss',
            self::Size =>8,
            self::Color=>'#000000'
        );
        return $value[$type];
    }

    static function  getDafaultValue($app = null){
     $mas =  array(
         self::FontName => 'Calibri',
         self::CharSet=>'204',
         self::Family=>'Swiss',
         self::Size =>8,
         self::Color=>'#000000'
     );
        if($app != null)
        foreach($app as $key => $val)
            $mas[$key] = $val;
        return $mas;
    }

} 
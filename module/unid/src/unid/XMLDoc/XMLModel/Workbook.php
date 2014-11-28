<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 18.08.14
 * Time: 23:26
 */

namespace XMLModel;

/**
 * Class Workbook
 * @package
 * XMLModelxmlns="urn:schemas-microsoft-com:office:spreadsheet"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
xmlns:html="http://www.w3.org/TR/REC-html40"
 *
 */


class Workbook extends \XMLModel\Base\XMLTeg {

    const xmlns = 'xmlns';
    const xmlns_o  ='xmlns:o';
    const xmlns_x = 'xmlns:x';
    const xmlns_ss = 'xmlns:ss';
    const xmlns_html = 'xmlns:html';
    function infoDoc(){
        $this->str = '';
    }
    function append(Table $table){
        parent::content($table);
    }
    static function  getDafaultValue($app = null){
        $mas =  array(
            self::xmlns => 'urn:schemas-microsoft-com:office:spreadsheet',
            self::xmlns_o=>'urn:schemas-microsoft-com:office:office',
            self::xmlns_x=>'urn:schemas-microsoft-com:office:excel',
            self::xmlns_ss =>'urn:schemas-microsoft-com:office:spreadsheet',
            self::xmlns_html=>'http://www.w3.org/TR/REC-html40'
        );
        if($app != null)
            foreach($app as $key => $val)
                $mas[$key] = $val;
        return $mas;
    }
} 
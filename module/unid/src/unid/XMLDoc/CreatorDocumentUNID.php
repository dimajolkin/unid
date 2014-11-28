<?php

namespace unid\XMLDoc;

use unid\Model\Personal;
use unid\Model\SoavtorTable;

use XMLModel\Document;
use XMLModel\Styles;
use XMLModel\Workbook;
use XMLModel\Worksheet;
use XMLModel\Worksheet\Table;
use XMLModel\Worksheet\Table\Column;
use XMLModel\Worksheet\Table\Cell;
use XMLModel\Worksheet\Table\Row;
use XMLModel\Worksheet\Table\Data;

use XMLModel\Worksheet\WorksheetOptions;
use unid\Model\Data as unidData;
use unid\Model\DataTable;

use XMLModel\Styles\Font;
use Zend\Mail\Header\From;

spl_autoload_register(function ($class) {
    //var_dump( __DIR__."\\". $class . '.php');
    $class = str_replace('\\','/',$class);
    $link = __DIR__."/". $class . '.php';
    include $link;
});

class CreatorDocumentUNID{
    protected $Worksheet;
    protected $Workbook;

    protected $Adapter;
    protected $user;
    protected $id_kaf;
    protected $tables;
    protected $Personal;

    protected $first_table = true;

    static function getStyle(){
        return new Styles(null, Styles::DefaultStyle());
    }

    static function getCapDocument($FIO, $name_kaf){
        return array(new Row(null,array(
            new Cell(array(Cell::MergeAcross=>5,Cell::StyleID=>'s75'),
                array(
                    new Data(array(Data::Type=>'String'),
                        'Министерство образования и науки Российской Федерации')
                ))
        )),
//            new Row(null,array(
//                new Cell(array(Cell::MergeAcross=>5,Cell::StyleID=>'s75'),
//                    array(
//                        new Data(array(Data::Type=>'String'),
//                            'Федеральное агентство по образованию')
//                    ))
//            )),
            new Row(null,array(
                new Cell(array(Cell::MergeAcross=>5,Cell::StyleID=>'s75'),
                    array(
                        new Data(array(Data::Type=>'String'),
                            'Костромской государственный университет имени Н.А. Некрасова&quot;')
                    ))
            )),
            new Row(array(Row::Index=>6),array(
                new Cell(null, new Data(array(Data::Type=>'String'),
                    '1. Кафедра:'.$name_kaf))
            )),
            new Row(null,array(
                new Cell(null, new Data(array(Data::Type=>'String'),
                    '2. Руководитель:'.$FIO))
            )),
            new Row(null,new Cell(null, new Data(array(Data::Type=>'String'),'')))
        );
    }

    protected $cap;
    protected $addintable;

    function add($text, $style = 's82', $len = 3){
        if(!$this->addintable){
            $this->addintable = array();
        }

        if($style == 'pull_left'){
            $obj = array(
                new Row(null,array( new Cell(null, new Data(array(Data::Type=>'String'), $text)))));
            array_push($this->addintable,  $obj );

            return null;
        }else

            array_push($this->addintable, self::setCapTable($text, $style, $len) );

    }

    function setCapTable($text, $style = 's82', $len = 5){
        $this->cap = false;
        return  array(
            new Row(array(Row::Height=>15),array(
                new Cell(array(Cell::MergeAcross=>$len,Cell::StyleID=>$style),
                    array(
                        new Data(array(Data::Type=>'String'),
                            $text)
                    ))
            )));
    }

    static function getSizeCell($size_cell){

        $array = array();
        foreach( explode(' ',$size_cell) as $int )
        {
            array_push($array,  new Column(array(Column::StyleID=>'s71',Column::AutoFitWidth=>0,Column::Width=>$int)) );
        }
        return $array;
    }
//        } else {
//            throw new \Exception('Нет такой табалицы');
//        }

    protected $enable_cap;
    function Cap($enabled = true){
        $this->enable_cap = $enabled;
    }


    function getTableXML($name_table,$option = array()){
        // var_dump($name_table);

        extract($option);

        if(!isset($size_cell)){
            throw new \Exception('Not Option size_cell');
        }
        //tab_group

        $FIO = $this->user->get(array('familie','name','gname'));


        $Table = new Table(null, self::getSizeCell($size_cell));

        if($this->enable_cap)
        {
            if($this->first_table){

                $name_kaf = $this->user->kafedra->name_kaf;

                $Table->content(self::getCapDocument($FIO, $name_kaf));
                $this->first_table = false;
            }
        }

        if($this->addintable){
            foreach($this->addintable as $obj)
                $Table->content($obj);
        }
        $stucture_table = new DataTable($this->Adapter, '__structure_stable');
        $TableInfo = new DataTable($this->Adapter, '__structure_menu');

        $st = null;


        if(isset($union_table))
        {

            $st = $stucture_table->get(array('table_'=>$union_table));
            $Table->content(self::setCapTable($text_tab));


        } else
        {
            $st = $stucture_table->get(array('table_'=>$name_table));
            $TableInfo = $TableInfo->get(array('name_table'=>$name_table))->current();

            $Table->content(self::setCapTable($TableInfo->menu));
        }



        $cell = array();
        $Row = new Row();
        $rows = array();
        if(isset($append_cell_fio))
        {
            if($append_cell_fio){
                //если не определена то Def = 'ФИО'
                if(!isset($text_cell_fio)) $text_cell_fio = 'ФИО';

                array_push($rows,  'login');
                $Row->content( new Cell(array(Cell::StyleID=>'s73'),new Data(array(Data::Type=>'String'),$text_cell_fio)));
            }

        }

        foreach($st as $obj){
            array_push($rows, $obj->cell);
            $Row->content( new Cell(array(Cell::StyleID=>'s73'),new Data(array(Data::Type=>'String'),$obj->cap)));
        }

        $Table->content($Row);

        //Content Data

        $ContentTable = null;

        $sql = '';
        //var_dump($find_cell);

        if(is_string($find_cell)) {
            $sql = array($find_cell=>$this->$find_cell);
        }elseif(is_array($find_cell)){
            $sql  = $find_cell;
        }

        //Устанавливаем год

        if(!isset($union_table))
        {
            $year = $this->user->get('__year'); //настраиваем год с которым мы работаме ели это план то  +1
            if($TableInfo->get('group_') == 'План') $year++; // собственно вот и оно
            $sql['year'] = $year;

        } else {

            $year = $this->user->get('__year');
            if($type_table = 'План'){
                $year++;
            };
            $sql['year'] = $year;
        }


        $TableSoavtor = null;
        if($TableInfo->soavtor != 'null')
        {
            $TableSoavtor = new SoavtorTable($this->Adapter, $TableInfo->soavtor);

        }

        $DataTable = new DataTable($this->Adapter, $name_table);
        $ContentTable = $DataTable->get($sql);



//Table Content=========================================================================


        foreach($ContentTable as $obj)
        {
            $Row = new Row();
            foreach($rows as $row)
            {
                $Cell = new Cell();

                if($row == 'login')
                {
                    $FIO = $this->Personal->getFIO($obj->$row)."\n";
                    //Добавляем соавторов к списку
                    if($TableSoavtor){
                        $Fio_soavtor = $TableSoavtor->getListSoavtor($obj->id);
                        foreach($Fio_soavtor as $soavtor){
                            $FIO.= $soavtor->get(array('familie', 'name','gname'))."\n";
                        }
                    }

                    $Cell->attr(array(Cell::StyleID=>'s80'))
                        ->content( new Data(array(Data::Type=>'String'), $FIO ));

                }else {

                    $Cell->attr(array(Cell::StyleID=>'s80'))
                        ->content( new Data(array(Data::Type=>'String'), $obj->$row ));

                }
                $Row->content($Cell);

            }
            $Table->content($Row);
        }



        if($this->footer)
        {
            $Fio_zav_kaf = $this->user->get(array('familie','name','gname'));
            $Table->content(array(

                new Row(array(Row::Height=>15),new Cell(array(Cell::StyleID=>'s83'), new Data(array(Data::Type=>'String')))),
                new Row(array(Row::Height=>15),
                    new Cell(null, new Data(array(Data::Type=>'String'),'Отчёт утверждён на заседании кафедры.')
                    )
                ),
                new Row(array(Row::Height=>15),new Cell(array(Cell::StyleID=>'s83'), new Data(array(Data::Type=>'String')))),
                new Row(array(Row::Height=>15),
                    new Cell(null,  new Data(array(Data::Type=>'String'),'Зав. кафедрой _______________________________ '.$Fio_zav_kaf
                        )
                    )
                )
            ));

        }


        $name_tab = '';
        if(isset($text_tab)){
            $name_tab = $text_tab;
        }else $name_tab = $TableInfo->menu;

        $name_tab = str_replace('\\','|',$name_tab);
        $name_tab = str_replace('/','|',$name_tab);

        $this->Workbook->content(
            new Worksheet( array( Worksheet::Name=> $name_tab ), array(
                    $Table,
                    Worksheet::Option())
            )
        );

    }
    function finalizWorkSheet($name_tab){

    }

    function setPersonal(Personal $personal){
        $this->Personal = $personal;
    }

    protected  $footer;
    function Footer($bool){

        $this->footer = $bool;
    }
    function __construct($DbAdapter,$zav_kaf){
        $this->Workbook = new Workbook();
        $this->Workbook   ->attr(Workbook::getDafaultValue());
        $this->Workbook   ->content(self::getStyle());

        $this->Adapter = $DbAdapter;
        $this->user = $zav_kaf;
        if($this->user->in_vars('kafedra'))
            $this->id_kaf = $zav_kaf->kafedra->id_kaf;

        $this->footer = true;
        $this->enable_cap = true;
    }


    function result(){
        $Document  = new Document();
        $Document->append($this->Workbook);
        return $Document->result();
    }
}

//$Doc = new CreatorDocumentUNID('');
//$Doc->result();
















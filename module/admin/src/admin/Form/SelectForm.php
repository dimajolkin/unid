<?php

namespace admin\Form;

use Zend\Form\Form;
use unid\Model\Data;
use unid\Model\DataTable;
class EditForm extends Form
{
    public $size;
    public $caps;
    public $adapter;


    /**@params adapter connect for BD, name_table in BD
     * @metod create_and_generation_form */
    public function __construct( $Adapter, $name_table)
    {




    }


    function  getCaps()
    {
        return $this->caps;
    }

}
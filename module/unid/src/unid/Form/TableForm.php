<?php
namespace unid\Form;

use Zend\Form\Form;
use unid\Model\Data;
use unid\Model\DataTable;

class TableForm extends Form
{
    public $size;
    public $caps;
    public $adapter;
    public function getStructure($name_table)
    {
        return new DataTable($this->adapter, $name_table);
    }
    /**@params adapter connect for BD, name_table in BD
     * @metod create_and_generation_form */

    function setElement(Data $row){
        switch($row->type)
        {
            case 'Text':
                array_push($this->caps, $row->get('cell'));
                $this->add(array(
                    'name' => $row->get('cell'),
                    'type'  => $row->type,
                    'attributes' => array(
                        'class'=>'text'
//                   'placeholder'=>$row->cap,
                    ),
                    'options' => array(
                        'label_attributes' => array(
                            'class'  => 'cell'
                        ),
                        'label' => $row->get('cap'),
                    )

                ));
                break;
            case 'Select':
                array_push($this->caps, $row->get('cell'));
                $value_option =  $this->getStructure('__structute_select')->get(array('type'=>$row->get('cell')));
                $array = array();
                foreach($value_option as $data) $array[ $data->get('name') ] = $data->get('name');
                $this->add(array(
                    'name' => $row->get('cell'),
                    'type'  => $row->get('type'),
                    'attributes' => array(
                        'class'=>'text',
                        'required' => 'required'
//                   'placeholder'=>$row->cap,
                    ),
                    'options' => array(
                        'label_attributes' => array(
                            'class'  => 'cell'
                        ),
                        'label' => $row->get('cap'),
                        'value_options' =>$array
                    )
                ));
                break;
            case 'Textarea':

                array_push($this->caps, $row->get('cell'));

                $this->add(array(
                    'name' => $row->get('cell'),
                    'type'  => $row->get('type'),
                    'attributes' => array(
                        'class'=>'text',
                        'required' => 'required'
//                   'placeholder'=>$row->cap,
                    ),
                    'options' => array(
                        'label_attributes' => array(
                            'class'  => 'cell'
                        ),
                        'label' => $row->get('cap')

                    )

                ));
                break;
            case 'SelectChekbox': //для Публикации
                array_push($this->caps, $row->get('cell'));

                $value_option =  $this->getStructure('__structute_select')->get(array('type'=>$row->get('cell')));
                          // foreach($value_option as $data) $array[ $data->name ] = $data->name;


                $elem = new Element\SelectChekbox($row->cell,$value_option);
                $elem->setOption('value',12);
                $elem->setName($row->cell);
                $elem->setAttribute('class','cell');
                $elem->setOptions(array(
                        'label_attributes' => array(
                            'class'  => 'cell'
                        ),
                        'label' => $row->cap,

                    )
                );
                $this->add($elem);



                break;

        }
    }
    public function setButtonLabel($label_text = 'Сохранать')
    {
        $this->get('button')->setOptions(array('label'=>$label_text));
    }
    public function __construct( $Adapter, $name_table, $assets = 'user')
    {

        $this->adapter  = $Adapter;
        // we want to ignore the name passed
        parent::__construct('DataTable');
        $this->setAttribute('method', 'post');



        $sql = array('table_'=>$name_table);
        if($assets == 'user') $sql['assets'] = $assets;

        $structure_table = $this->getStructure('__structure_stable')->get($sql,null,array('id_cell'));

        $this->size = count($structure_table);
        if($this->size == 0) throw new \Exception("Table not Fount ".$name_table);


        $this->caps = array();
        foreach($structure_table as $row)
        {

            self::setElement($row, $this->caps);
        }


        $this->add(array(
            'type' => 'Zend\Form\Element\Button',
            'name' =>'button',
            'attributes' => array(
                'class' =>'btn btn-success btn-large',
                'type'=>'submit',
                'validate'=>'',
                'style'=>'width: 100%'

            ),
            'options' => array(
                'label' => 'Добавление',
            )
        ));

    }


    public function load( Data $object){
        foreach($this->caps as $cap) {
            parent::get($cap)->setValue( $object->$cap );
        }
    }

    function  getCaps()
    {
        return $this->caps;
    }
    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
                'required' => true,
            )
        );
    }

}
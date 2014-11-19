<?php
namespace unid\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Form\FormElementManager;
use Zend\Form\Fieldset;



class TestForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('login');
        $row = 'array';
        $array = array(
            '11212',
            '12323'
        );




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
<?php
namespace unid\Form\Element;



use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
class SelectChekbox extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name, $value)
    {

        parent::__construct($name);

        $index  = 0;
        foreach($value as $data)
            $this->add(array(
                'name' => $data->name,
                'type'  => 'Checkbox',
                'attributes' => array(
                    'value'=>0,
                ),
                'options' => array(
                    'label' => $data->name,
                    'label_attributes' => array(
                        'class'  => 'checkbox'
                    ),
                )
            ));


        $this->add(array(
            'name' => 1,
            'type'  => 'Text',

            'attributes' => array(
                'class'=>'text'

            ),
            'options' => array(
                'label' =>  'Иное'
            )
        ));

    }
    public function setData()
    {

    }
    public function setValue($value)
    {
        if(is_string($value))
        {
            $temp = explode(',', $value);
            $array = $temp;
            foreach($array as $i => $value)
            {
                foreach($this->getElements() as $obj)
                {
                    if( trim($obj->getName()) == trim($value))
                    {
                        unset($array[$i]);
                        $obj->setValue(1);
                    }
                }
            }
            //если не пустой значит там естб 1 элемент "Иное"
            if(!empty($array))
            {
               foreach($array as $i => $value)
               {
                   foreach($this->elements as $obj)
                       if(is_numeric($obj->getName()))
                       {
                           $obj->setValue(trim($value));
                       }
               }

            }

        }



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
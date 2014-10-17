<?php
namespace Xoperator\Form;

use Zend\Form\Form;

class MenusForm extends Form
{
    public function __construct()
    {
        // we want to ignore the name passed
        parent::__construct('menus');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        $this->add(array(
            'name' => 'menu',
            'attributes' => array(
                'type'   => 'text',
                'class'       => 'form-control',              
            ),
            'options'   => array(
                'label'  => 'Menu',
                'class'  => 'col-sm-2 control-label',
            ),
        ));
        
        $this->add(array(
            'name' => 'description',
            'attributes'    => array(
                'type'      => 'text',
                'class'     => 'form-control',
            ),
            'options' => array(
                'label'     => 'Descrição do Menu',
                'class'     => 'col-sm-2 control-label',
            ),
        ));        
        
        $this->add(array(
            'name' => 'submit',
            'attributes'    => array(
                'type'      => 'submit',
                'class'     => 'btn btn-success',
                'value'     => 'Salvar',
                
            ),
        ));
    }
}
<?php
namespace Xoperator\Form;

use Zend\Form\Form;

class LinksMenusForm extends Form
{
    public function __construct()
    {
        // we want to ignore the name passed
        parent::__construct('linksmenus');
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
            'name' => 'id_menu',
            'attributes' => array(
                'type'   => 'hidden',
                'class'       => 'form-control',              
            ),
        ));
        
        $this->add(array(
            'name' => 'value',
            'attributes' => array(
                'type'   => 'text',
                'class'       => 'form-control',              
            ),
            'options' => array(
                'label'     => 'Nome do Link',
                'class'     => 'col-sm-2 control-label',
            ),
        ));
        
        $this->add(array(
            'name' => 'link',
            'attributes' => array(
                'type'   => 'text',
                'class'       => 'form-control',              
            ),
            'options' => array(
                'label'     => 'Link URL da página',
                'class'     => 'col-sm-2 control-label',
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
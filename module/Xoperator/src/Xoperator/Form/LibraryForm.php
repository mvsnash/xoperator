<?php

namespace Xoperator\Form;

use Zend\Form\Form;

class LibraryForm extends Form
{
    
    public function __construct()
    {
        // we want to ignore the name passed
        parent::__construct('library');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        $this->add(array(
            'name' => 'file_name',
            'attributes' => array(
                'type'   => 'text',
                'class'       => 'form-control',              
            ),
            'options'   => array(
                'label'  => 'Nome do Arquivo',
                'class'  => 'col-sm-2 control-label',
            ),
        ));      
        
        $this->add(array(
            'name' => 'file_image',
            'attributes'    => array(
                'type'      => 'file',
                'class'     => 'form-control',
            ),
            'options'   => array(
                'label'  => 'Nome do Arquivo',
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
                'label'     => 'Descrição do arquivo',
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

<?php
namespace Xoperator\Form;

use Zend\Form\Form;

class ArticlesForm extends Form
{
    public function __construct()
    {
        // we want to ignore the name passed
        parent::__construct('articles');
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
            'name' => 'url',
            'attributes' => array(
                'type'   => 'text',
                'class'       => 'form-control',              
            ),
            'options'   => array(
                'label'  => 'URL (Ex.: nome-artigo) * não use espaços em branco',
                'class'  => 'col-sm-2 control-label',
            ),
        ));
        
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'   => 'text',
                'class'       => 'form-control',              
            ),
            'options'   => array(
                'label'  => 'Título *',
                'class'  => 'col-sm-2 control-label',
            ),
        ));
        
        $this->add(array(
            'name' => 'text',
            'attributes'    => array(
                'type'      => 'textarea',
                'class'     => 'xop-form-control',
            ),
            'options' => array(
                'label'     => 'Texto *',
                'class'     => 'col-sm-2 control-label',
            ),
        ));
        
        $this->add(array(
            'name' => 'id_image',
            'attributes' => array(
                'type'   => 'text',
                'class'       => 'form-control',             
            ),
            'options'   => array(
                'label'  => 'ID da imagem *',
                'class'  => 'col-sm-2 control-label',
            ),
        ));
        
        $this->add(array(
            'name' => 'tags',
            'attributes' => array(
                'type'   => 'text',
                'class'       => 'form-control',           
            ),
            'options'   => array(
                'label'  => 'Tags (Opcional)',
                'class'  => 'col-sm-2 control-label',
            ),
        ));
        
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type'   => 'text',
                'class'       => 'form-control',
            ),
            'options'   => array(
                'label'  => 'Descrição do artigo (Opcional)',
                'class'  => 'col-sm-2 control-label',
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
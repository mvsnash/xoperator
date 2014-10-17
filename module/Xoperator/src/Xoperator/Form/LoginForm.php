<?php
namespace Xoperator\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct()
    {
        // we want to ignore the name passed
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'   => 'text',
                'class'       => 'form-control',              
            ),
            'options'   => array(
                'label'  => 'E-mail',
                'class'  => 'col-sm-2 control-label',
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'attributes'    => array(
                'type'      => 'password',
                'class'     => 'form-control',
            ),
            'options' => array(
                'label'     => 'Senha',
                'class'     => 'col-sm-2 control-label',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes'    => array(
                'type'      => 'submit',
                'class'     => 'btn btn-default',
                'value'     => 'Entrar',
                
            ),
        ));
    }
}
<?php

namespace Xoperator\EntityTable;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Doctrine\ORM\Mapping as ORM;
/**
 * A music library.
 *
 * @ORM\Entity
 * @ORM\Table(name="xoplibrary")
 */

class Library implements InputFilterAwareInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $file_name;
    /**
     * @ORM\Column(type="string")
     */
    protected $file_image;
    /**
     * @ORM\Column(type="string")
     */
    protected $description;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;
    /**
     * @ORM\Column(type="string")
     */
    protected $status;
    
    
    protected $inputFilter;

    public function __get($property) 
    {
        return $this->$property;
    }
 
    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) 
    {
        $this->$property = $value;
    }
 
    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this);
    }
    
    public function getUsername(){
        $this->username;
    }


    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array()) 
    {
        $this->file_name = $data['file_name'];
        $this->file_image = $data['file_image'];
        $this->description = $data['description'];
    }

    // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

//            $inputFilter->add($factory->createInput(array(
//                'name'     => 'id',
//                'required' => true,
//                'filters'  => array(
//                    array('name' => 'Int'),
//                ),
//            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'file_name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        array(
                            'name' => 'EmailAddress'
                        ),
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                        ),
                    ),
                ),
            )));


            $inputFilter->add($factory->createInput(array(
                'name'     => 'file_image',
                'required' => false,
                'FilterChain'  => array(
                    'attachByName' => array(
//                        'filerenameupload',
                            array(
                                'target' => './data',
                                'overwrite' => true,
                                'use_upload_name' => true,
                            )
                        ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'description',
                'required' => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'min' => 6,
                                ),
                            ),
                        ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

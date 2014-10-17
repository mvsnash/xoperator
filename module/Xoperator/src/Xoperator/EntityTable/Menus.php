<?php

namespace Xoperator\EntityTable;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Doctrine\ORM\Mapping as ORM;
/**
 * A music articles.
 *
 * @ORM\Entity
 * @ORM\Table(name="xopmenus")
 */

class Menus implements InputFilterAwareInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(unique=false, type="string")
     */
    protected $menu;
    /**
     * @ORM\Column(type="string")
     */
    protected $modules;
    /**
     * @ORM\Column(type="string")
     */
    protected $description;
    /**
     * @ORM\Column(type="string")
     */
    protected $block;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;
    
    
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

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array()) 
    {
        $this->menu = $data['menu'];
        $this->description = $data['description'];
        $this->block = 'null';
        $this->modules = 'null';
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
                'name'     => 'menu',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));

            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'description',
                'required' => false,
                'filters'    => array(
                                    array(
                                        'name' => 'StringTrim', 
                                    )),
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

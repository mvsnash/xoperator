<?php

namespace Xoperator\EntityTable;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Doctrine\ORM\Mapping as ORM;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="xoplinksmenus")
 */

class LinksMenus implements InputFilterAwareInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="integer")
     */
    protected $id_menu;
    /**
     * @ORM\Column(type="string")
     */
    protected $value;
    /**
     * @ORM\Column(type="string")
     */
    protected $link;
    /**
     * @ORM\Column(type="string")
     */
    protected $description;
    /**
     * @ORM\Column(type="integer")
     */
    protected $id_user;
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
        $this->id_menu = $data['id_menu'];
        $this->value = $data['value'];
        $this->link = $data['link'];
        $this->description = $data['description'];
        $this->id_user = 1;
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
                        'name' => 'id_menu',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));
            
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'value',
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
                                    'min' => 3,
                                ),
                            ),
                        ),
            )));
            

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

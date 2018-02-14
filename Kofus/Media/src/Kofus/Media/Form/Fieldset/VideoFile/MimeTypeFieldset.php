<?php
namespace Kofus\Media\Form\Fieldset\VideoFile;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;
use Zend\Filter;
use Zend\Validator;

class MimeTypeFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function init()
    {
        $el = new Element\Text('mime', array(
            'label' => 'Mime-Type'
        ));
        $this->add($el);
        
    }

    public function getInputFilterSpecification()
    {
        return array(
            'mime' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'Zend\Filter\ToNull'
                    ),
                    array(
                        'name' => 'Zend\Filter\StringTrim'
                    )
                )
            ),
            
            'enabled' => array(
                'required' => false
            )
        );
    }
}

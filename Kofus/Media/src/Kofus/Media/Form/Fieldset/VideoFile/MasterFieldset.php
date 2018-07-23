<?php
namespace Kofus\Media\Form\Fieldset\VideoFile;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;
use Zend\Filter;
use Zend\Validator;

class MasterFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function init()
    {
        $el = new Element\Text('title', array(
            'label' => 'Administrativer Titel'
        ));
        $this->add($el);
        
        $el = new Element\Text('mime', array(
            'label' => 'Mime-Type'
        ));
        $el->setAttribute('placeholder', 'z.B. video/webm');
        $el->setOption('help-block', 'Video-Mime-Type wird automatisch ermittelt, wenn leer.');
        $this->add($el);
    }

    public function getInputFilterSpecification()
    {
        return array(
            'mime' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'Zend\Filter\ToNull'
                    ),
                    array(
                        'name' => 'Zend\Filter\StringTrim'
                    )
                )
            ),
            
            'title' => array(
                'required' => false,
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

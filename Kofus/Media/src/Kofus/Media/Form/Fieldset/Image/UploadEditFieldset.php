<?php
namespace Kofus\Media\Form\Fieldset\Image;

use Zend\Validator;

class UploadEditFieldset extends UploadFieldset
{

    public function getInputFilterSpecification()
    {
        // Hack: allow empty file in this case
        if (isset($_FILES['upload']['error']['file']) && 4 == $_FILES['upload']['error']['file'])
            return array();
            
        return array(
            'file' => array(
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'Zend\Validator\File\IsImage'
                    ),
                    array(
                        'name' => 'Zend\Validator\File\Size',
                        'options' => array(
                            'max' => $this->getMaxFilesize() . 'MB'
                        )
                    )
                )
            )
        );
        
    }
}

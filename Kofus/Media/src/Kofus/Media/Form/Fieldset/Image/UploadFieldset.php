<?php
namespace Kofus\Media\Form\Fieldset\Image;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;
use Zend\Filter\StaticFilter;

class UploadFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected function parseSize($s)
    {
        $int = StaticFilter::execute($s, 'Digits');
        $unit = StaticFilter::execute($s, 'Alpha');
        
        switch (strtoupper($unit)) {
            case 'G':
                $mb = $int * 1024;
                break;
            case 'M':
                $mb = $int;
                break;
            default: // byte
                $mb = $int / 1024;
        }
        ;
        return $mb;
    }

    protected function getMaxFilesize()
    {
        $limitUpload = $this->parseSize(ini_get('upload_max_filesize'));
        $limitPost = $this->parseSize(ini_get('post_max_size'));
        
        if ($limitUpload < $limitPost)
            return $limitUpload;
        return $limitPost;
    }

    public function init()
    {
        $this->setName('upload');
        $this->setLabel('Upload');
        
        $el = new Element\File('file', array(
            'label' => 'Image File'
        ));
        $el->setAttribute('id', 'file');
        $el->setOption('help-block', 'max. ' . $this->getMaxFilesize() . 'MB');
        $this->add($el);
    }

    public function getInputFilterSpecification()
    {
        return array(
            'file' => array(
                'required' => true,
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

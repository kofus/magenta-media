<?php
namespace Kofus\Media\Form\Fieldset\VideoFile;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;
use Zend\Filter;
use Zend\Validator;

class ImportFieldset extends Fieldset implements InputFilterProviderInterface
{
    protected $path = 'data/media/imports';

    public function init()
    {
        
        $el = new Element\Select('filename', array(
            'label' => 'File'
        ));
        $el->setOption('help-block', 'Dateien aus Verzeichnis "' . $this->path . '"');
        
        if (is_dir($this->path)) {
            $filenames = array();
            foreach (scandir($this->path) as $filename) {
                $canonical = ROOT_DIR . '/' . $this->path . '/' . $filename;
                if (is_file($canonical))
                    $filenames[$canonical] = $filename;
            }
            $el->setValueOptions($filenames);
        }
            
        $this->add($el);
        
    }

    public function getInputFilterSpecification()
    {
        return array(
            'filename' => array(
                'required' => true,
            ),
        );
    }
}

<?php
namespace Kofus\Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Form\Element\Submit;
use Zend\Form\Form;


class ConsoleController extends AbstractActionController
{
    public function hashesAction()
    {
        $command = $this->getRequest()->getParam(0);
        $nodeType = $this->getRequest()->getParam(2);
        
        switch ($command) {
            case 'rebuild':
                $files = $this->nodes()->getRepository($nodeType)->findAll();
                foreach ($files as $file) {
                    if (file_exists($file->getPath())) {
                        //print $file . ' ' . $file->getPath() . PHP_EOL;
                        $hash = md5_file($file->getPath());
                        $file->setHash($hash);
                        $this->em()->persist($file);
                    }
                }
                break;
                
            case 'remove':
                $files = $this->nodes()->getRepository($nodeType)->findAll();
                foreach ($files as $file) {
                    $file->setHash(null);
                    $this->em()->persist($file);
                }
                break;
                
            default:
                throw new \Exception('Unknown console command: ' . $command . ' hashes');
        }
        $this->em()->flush();
    }
}

<?php

namespace Kofus\Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Imagick;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;

class VideoFileController extends AbstractActionController
{
    public function listAction()
    {
        $this->archive()->uriStack()->push();
        $qb = $this->nodes()->createQueryBuilder('VF');
        $paginator = $this->paginator($qb);
        
        return new ViewModel(array(
            'paginator' => $paginator
        ));
    }
    
    public function dumpAction()
    {
        $uri = $this->getRequest()->getRequestUri();
        $link = $this->em()->getRepository('Kofus\System\Entity\LinkEntity')->findOneBy(array('uri' => $uri));
        if (! $link) {
            return $this->getResponse()->setStatusCode(Response::STATUS_CODE_404)
            ->setReasonPhrase('Not Found')
            ->setContent('Not Found');
        }
        
        $file = $this->nodes()->getNode($link->getLinkedNodeId());
        if (! $file instanceof \Kofus\Media\Entity\VideoFileEntity)
            throw new \Exception('Node '.$file->getNodeId().' must implement VideoFileEntity');
            
        $cacheFilename = 'public/' . $link->getUri();
        if (! is_dir(dirname($cacheFilename))) {
            if (! mkdir(dirname($cacheFilename), 0777, true))
                throw new \Exception('Could not create directory ' . dirname($cacheFilename));
        }
        copy($file->getPath(), $cacheFilename);
        
        return $this->redirect()->toUrl($link->getUri() . '?' . time());
    }
    
    public function importAction()
    {
        $entity = new \Kofus\Media\Entity\VideoFileEntity();
        
        $form = $this->formBuilder()
            ->setEntity($entity)
            ->setContext('import')
            ->setLabelSize('col-sm-3')->setFieldSize('sm-9')
            ->buildForm()
            ->add(new \Zend\Form\Element\Submit('submit', array('label' => 'Save')));
            
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $this->em()->persist($entity);
                $this->em()->flush();
                return $this->redirect()->toUrl($this->archive()->uriStack()->pop());
            }
        }
        
        return new ViewModel(array(
            'form' => $form->prepare(),
            'formTemplate' => 'kofus/system/node/form/panes.phtml'
        ));
    }
    
    
    
    	
}
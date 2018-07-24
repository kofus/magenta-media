<?php

namespace Kofus\Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Imagick;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;

class VideoDisplayController extends AbstractActionController
{
    public function listAction()
    {
        $this->archive()->uriStack()->push();
        $qb = $this->nodes()->createQueryBuilder('VD');
        $qb->orderBy('n.priority', 'ASC');
        $paginator = $this->paginator($qb);
        
        return new ViewModel(array(
            'paginator' => $paginator
        ));
    }
    
    public function viewAction()
    {
        $this->archive()->uriStack()->push();
        $entity = $this->nodes()->getNode($this->params('id'), 'VD');
        
        // Relations
        $relations = array();
        foreach ($this->config()->get('relations.enabled', array()) as $_relation) {
            $relation = explode('_', $_relation);
            if ($relation[0] == 'VD') {
                $relations[$relation[1]] = $this->nodes()->getRelations($entity, $relation[1]);
            }
        }
        
        return new ViewModel(array(
            'entity' => $entity,
            'relations' => $relations
        ));
    }
    
    	
}
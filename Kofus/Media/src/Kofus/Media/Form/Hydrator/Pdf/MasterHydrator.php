<?php
namespace Kofus\Media\Form\Hydrator\Pdf;

use Zend\Stdlib\Hydrator\HydratorInterface;



class MasterHydrator implements HydratorInterface
{
	public function extract($object)
	{
	    return array(
	        'title' => $object->getTitle()
	    );
	}

	public function hydrate(array $data, $object)
	{
	    $object->setTitle($data['title']);
		return $object;
	}
	
	
		
	
	
}
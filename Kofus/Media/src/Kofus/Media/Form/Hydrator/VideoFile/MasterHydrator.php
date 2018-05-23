<?php
namespace Kofus\Media\Form\Hydrator\VideoFile;

use Zend\Stdlib\Hydrator\HydratorInterface;



class MasterHydrator implements HydratorInterface
{
	public function extract($object)
	{
	    return array(
	        'mime' => $object->getMimeType(),
	        'title' => $object->getTitle()
	    );
	}

	public function hydrate(array $data, $object)
	{
	    $object->setMimeType($data['mime']);
	    $object->setTitle($data['title']);
		return $object;
	}
	
	
		
	
	
}
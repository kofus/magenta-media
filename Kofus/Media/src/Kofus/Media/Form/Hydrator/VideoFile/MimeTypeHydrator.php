<?php
namespace Kofus\Media\Form\Hydrator\VideoFile;

use Zend\Stdlib\Hydrator\HydratorInterface;



class MimeTypeHydrator implements HydratorInterface
{
	public function extract($object)
	{
	    return array(
	        'mime' => $object->getMimeType()
	    );
	}

	public function hydrate(array $data, $object)
	{
	    $object->setMimeType($data['mime']);
		return $object;
	}
	
	
		
	
	
}
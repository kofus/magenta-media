<?php
namespace Kofus\Media\Form\Hydrator\VideoFile;

use Zend\Stdlib\Hydrator\HydratorInterface;



class ImportHydrator implements HydratorInterface
{
	public function extract($object)
	{
	    return array(
	    );
	}

	public function hydrate(array $data, $object)
	{
	    $filename = \Zend\Math\Rand::getString(16, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
	    $path = 'data/media/files/' . $filename;
	    
	    copy($data['filename'], $path);
	    
	    $object->setFilename($filename);
	    $object->setMimeType(mime_content_type($path));
	    $object->setFilesize(filesize($path));
	    
		return $object;
	}
}
<?php
namespace Kofus\Media\Form\Hydrator\VideoFile;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class UploadEditHydrator implements HydratorInterface, ServiceLocatorAwareInterface
{
	public function extract($object)
	{
	    return array(
	    );
	}

	public function hydrate(array $data, $object)
	{
	    $config = $this->getServiceLocator()->get('KofusConfig');
	    
	    if (! isset($data['file']))
	        return $object;
	    
	    // Create filename
	    if (! $object->getFilename())
	        $object->setFilename(\Zend\Math\Rand::getString(16, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'));
	    
        // Upload successful?
        if (! isset($data['file']['name']))
            return $object;
        if ($data['file']['error'] == 4)
            return $object;
        if ($data['file']['error'] != 0)
            throw new \Exception('File upload error ' . $data['file']['error']);
	        

	    // Handle uploaded file
	    $target = $object->getPath();
	    $fileInfo = $data['file'];
	    $object->setMimeType($fileInfo['type']);
	    $object->setFilesize($fileInfo['size']);	
	    if (! move_uploaded_file($fileInfo['tmp_name'], $target))
	    	throw new \Exception('Uploaded file "'.$fileInfo['tmp_name'].'" could not be moved to "'.$target.'"');
	    
    	if ($config->get('media.file.' . $object->getNodeType() . '.hashing', false))
    	    $object->setHash(md5_file($target));	    
		return $object;
	}
	
	protected $sm;
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->sm = $serviceLocator;
	}
	
	public function getServiceLocator()
	{
		return $this->sm;
	}
		
	
	
}
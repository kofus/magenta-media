<?php
namespace Kofus\Media\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class VideoFileEntity extends FileEntity 
{
	public function getNodeType()
	{
		return 'VF';
	}
	
	public function __toString()
	{
	    return $this->getTitle() . ' (' . $this->getNodeId() . ')';
	}
}


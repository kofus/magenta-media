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
	
	public function setMimeType($value)
	{
	    $this->mimeType = $this->filterMimeType($value); 
	    return $this;
	}
	
	public function getMimeType()
	{
	    return $this->filterMimeType($this->mimeType);
	}
	
	protected function filterMimeType($value)
	{
	    if (preg_match('/(video\/[0-9a-z]+)/i', $value, $matches)) {
	        return $matches[1];
	    }
	    return $value;
	}
	
	
	public function __toString()
	{
	    $s = $this->getMimeType();
	    if ($this->getTitle())
	        $s .= ': ' . $this->getTitle();
	    $s .= ' (' . $this->getNodeId() . ')';
	    
	    return $s; 
	}
}


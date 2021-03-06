<?php
namespace Kofus\Media\Entity;
use Doctrine\ORM\Mapping as ORM;
use Kofus\System\Node;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Table(name="kofus_media_files", uniqueConstraints={@ORM\UniqueConstraint(name="hash", columns={"hash"})})
 */
class FileEntity implements Node\NodeInterface, Node\EnableableNodeInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    protected $id;
    
    public function getId()
    {
    	return $this->id;
    }
    
    /**
     * @ORM\Column(nullable=true)
     */
    protected $title;
    
    public function setTitle($value)
    {
        $this->title = $value; return $this;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    
	
	/**
	 * @ORM\Column()
	 */
	protected $filename;
	
	public function setFilename($value)
	{
		$this->filename = $value; return $this;
	}
	
	public function getFilename()
	{
		return $this->filename;
	}
	
	/**
	 * @ORM\Column()
	 */
	protected $mimeType;
	
	public function setMimeType($value)
	{
		$this->mimeType = $value; return $this;
	}
	
	public function getMimeType()
	{
		return $this->mimeType;
	}
	

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $filesize;
	
	public function setFilesize($value)
	{
		$this->filesize = $value; return $this;
	}
	
	public function getFilesize()
	{
		return $this->filesize;
	}
	
	/**
	 * @ORM\Column(nullable=true)
	 */
	protected $hash;
	
	public function setHash($value)
	{
		$this->hash = $value; return $this;
	}
	
	public function getHash()
	{
		return $this->hash;
	}
		
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $enabled = true;
	
	public function isEnabled($bool = null)
	{
		if ($bool !== null) {
		    $this->enabled = (bool) $bool;
		    return $this;
		}
		return $this->enabled;
	}
	
	/**
	 * @ORM\Column(type="json_array")
	 */
	protected $params = array();
	
	public function setParam($key, $value)
	{
	    $this->params[$key] = $value; return $this;
	}
	
	public function getParam($key)
	{
	    if (array_key_exists($key, $this->params))
	        return $this->params[$key];
	}
	
	
	public static function determineType(array $infoArray)
	{
		$mimeType = strtolower($infoArray['type']);
		$extension = strtolower(pathinfo($infoArray['name'], PATHINFO_EXTENSION));
		
		if ('pdf' == $extension || strpos($mimeType, 'pdf'))
			return 'pdf';
		if (false !== strpos($mimeType, 'image'))
			return 'image';
		return 'file';
	}
	
	
	public function getNodeType()
	{
		return 'F';
	}
	
	public function __toString()
	{
		return $this->getNodeId();
	}
	
	public function getNodeId()
	{
		return $this->getNodeType() . $this->getId();
	}
	
	/**
	 * @ORM\Column(nullable=true)
	 */
	protected $path;
	
	public function getPath()
	{
	    if ($this->path)
	        return $this->path;
	    
		return 'data/media/files/' . $this->getFilename();
	}
	
	public function setPath($value)
	{
	    $this->path = $value; return $this;
	}
	
	
}


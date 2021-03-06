<?php
namespace Kofus\Media\Entity;
use Doctrine\ORM\Mapping as ORM;
use Kofus\System\Node;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Table(name="kofus_media_videos")
 * 
 */
class VideoDisplayEntity implements Node\NodeInterface, Node\EnableableNodeInterface
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
	 * @ORM\Column()
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
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $priority;
	
	public function setPriority($value)
	{
	    $this->priority = $value; return $this;
	}
	
	public function getPriority()
	{
	    return $this->priority;
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
	
	public function getNodeType()
	{
		return 'VD';
	}
	
	public function __toString()
	{
		return $this->getTitle() . ' (' . $this->getNodeId() . ')';
	}
	
	public function getNodeId()
	{
		return $this->getNodeType() . $this->getId();
	}
	
	
}


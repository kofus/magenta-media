<?php
namespace Kofus\Media\Imagick\Filter;
use Kofus\Media\Imagick\AbstractFilter;

class ZoomIn extends AbstractFilter
{
    const ZOOM_CENTER   = 'center';
    const ZOOM_NORTH    = 'north';
    
    public function filter($value)
    {
        if (! $value instanceof \Imagick)
            throw new \Exception('Filter value must be an instance of Imagick');
        
        // Make sure that original image is larger than target image
        if ($this->getWidth() > $value->getImageWidth())
            $value->scaleImage($this->getWidth(), null);
        if ($this->getHeight() > $value->getImageHeight())
            $value->scaleImage(null, $this->getHeight());
        
        $mock1 = clone $value;
        $mock1->scaleImage($this->getWidth(), null);
        if ($mock1->getImageHeight() >= $this->getHeight())
            $value->scaleImage($this->getWidth(), null);
        
        $mock2 = clone $value;
        $mock2->scaleImage(null, $this->getHeight());
        if ($mock2->getImageWidth() >= $this->getWidth())
            $value->scaleImage(null, $this->getHeight());
        
        switch ($this->getZoom()) {
            case self::ZOOM_NORTH:
                $value->cropImage(
                    $this->getWidth(),
                    $this->getHeight(),
                    ($value->getImageWidth() - $this->getWidth()) / 2,
                    0
                );
                break;
                
            case self::ZOOM_CENTER:
                $value->cropImage(
                    $this->getWidth(),
                    $this->getHeight(),
                    ($value->getImageWidth() - $this->getWidth()) / 2,
                    ($value->getImageHeight() - $this->getHeight()) / 2
                );
                break;
                
            default:
                throw new \Exception('no zoom defined');
        }
        
        return $value;
    }
    
    public function setZoom($value)
    {
        $this->options['zoom'] = $value; return $this;
    }
    
    public function getZoom()
    {
        if (! isset($this->options['zoom']))
            $this->options['zoom'] = self::ZOOM_CENTER;
            return $this->options['zoom'];
    }
    
    
    public function setWidth($value)
    {
        $this->options['width'] = $value; return $this;
    }
    
    public function getWidth()
    {
        if (! isset($this->options['width']))
            throw new \Exception('Option "width" is required');
        return $this->options['width'];
    }
    
    public function setHeight($value)
    {
        $this->options['height'] = $value; return $this;
    }
    
    public function getHeight()
    {
        if (! isset($this->options['height']))
            throw new \Exception('Option "height" is required');
            return $this->options['height'];
    }
    
   
    
    

    
}
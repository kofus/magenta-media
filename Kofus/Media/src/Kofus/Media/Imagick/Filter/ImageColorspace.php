<?php
namespace Kofus\Media\Imagick\Filter;
use Kofus\Media\Imagick\AbstractFilter;

/*
 * Constants:
    0 - UndefinedColorspace   
    1 - RGBColorspace   
    2 - GRAYColorspace   
    3 - TransparentColorspace   
    4 - OHTAColorspace   
    5 - LABColorspace   
    6 - XYZColorspace   
    7 - YCbCrColorspace   
    8 - YCCColorspace   
    9 - YIQColorspace   
    10 - YPbPrColorspace   
    11 - YUVColorspace   
    12 - CMYKColorspace   
    13 - sRGBColorspace   
    14 - HSBColorspace   
    15 - HSLColorspace   
    16 - HWBColorspace
 */

class ImageColorspace extends AbstractFilter
{
    protected $options = array(
        'colorspace' => 0
    );
    
    
    public function filter($value)
    {
        if (! $value instanceof \Imagick)
            throw new \Exception('Filter value must be an instance of Imagick');
        
        $value->transformImageColorSpace($this->getImageColorspace());
        
        return $value;
    }
    
    public function setImageColorspace($value)
    {
        $this->options['colorspace'] = (int) $value; return $this;
    }
    
    public function getImageColorspace()
    {
        return $this->options['colorspace'];
    }
    

   
    
    

    
}
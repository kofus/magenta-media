<?php 
namespace Kofus\Media\Service;
use Kofus\System\Service\AbstractService;
use Zend\Math\Rand;

class MediaService extends AbstractService
{
    
    protected function removeDir($dirPath)
    {
        foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dirPath, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST) as $path) {
        	$path->isDir() && !$path->isLink() ? rmdir($path->getPathname()) : unlink($path->getPathname());
        }
    }
    
    public function clearCache(\Kofus\System\Node\NodeInterface $node=null)
    {
        if ($node === null) {
            $this->removeDir('public/cache/media');
            return; 
        }
        
        if ($node instanceof \Kofus\Media\Entity\FileEntity) {
            
            $links = $this->em()->getRepository('Kofus\System\Entity\LinkEntity')->findBy(array(
                'linkedNodeId' => $node->getNodeId()
            ));
            foreach ($links as $link) {
                $linkUri = \Zend\Uri\UriFactory::factory($link->getUri(), 'http');
                $filename = 'public/' . trim($linkUri->getPath(), '/');
                if (strpos($filename, 'public/cache/media/') !== 0)
                    return;
                if (file_exists($filename))
                    unlink($filename);
            }
        }
    } 
    
    public function getImageLink($image, $display='thumb', array $options=array())
    {
        $link = $this->em()->getRepository('Kofus\System\Entity\LinkEntity')->findOneBy(array('linkedNodeId' => $image->getNodeId(), 'context' => $display));
        if (! $link) {
            $config = $this->config()->get('media.image.displays.available.' . $display);
            
            //$path = $image->getPath();
            //if (! is_readable($path) && isset($config['error_image']))
                //$path = $config['error_image'];
            
            $imagick = $this->process($image, $display);
            $extension = strtolower($imagick->getImageFormat());
            
            $r = Rand::getString(16, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXZY0123456789');
            $uri = '/cache/media/image/' . $display . '/' . $r . '.' . $extension;
            
            $mirrors = $this->config()->get('media.mirrors', array());
            if ($mirrors) {
                $key = array_rand($mirrors);
                $uri = trim($mirrors[$key], '/') . $uri;
            }
            
            $link = new \Kofus\System\Entity\LinkEntity();
            $link->setLinkedNodeId($image->getNodeId())
                ->setContext($display)
                ->setUri($uri);
            
            $this->em()->persist($link);
            $this->em()->flush();
        }
        
        return $link;
    }
    
    public function getVideoLinks(\Kofus\Media\Entity\VideoDisplayEntity $video)
    {
        $files = $this->nodes()->getRelatedNodes($video, 'VF');
        $links = array();
        foreach ($files as $file)
            $links[] = $this->getVideoLink($video);
        return $links;
    }
    
    public function getVideoLink(\Kofus\Media\Entity\VideoFileEntity $video, array $options=array())
    {
        $link = $this->em()->getRepository('Kofus\System\Entity\LinkEntity')->findOneBy(array('linkedNodeId' => $video->getNodeId(), 'context' => 'video'));
        if (! $link) {
            if ($video->getTitle()) {
                $filter = new \Kofus\System\Filter\UriSegment();
                $uriSegment = $filter->filter($video->getTitle());
            } else {
                $uriSegment = Rand::getString(16, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXZY0123456789');
            }
            
            $extension = str_replace('video/', '', $video->getMimeType());
            
            $uri = '/cache/media/video/' . $uriSegment . '.' . $extension;
            
            $link = new \Kofus\System\Entity\LinkEntity();
            $link->setLinkedNodeId($video->getNodeId())
            ->setContext('video')
            ->setUri($uri);
            
            $this->em()->persist($link);
            $this->em()->flush();
        }
        
        return $link;
    }
    
    public function getPdfLink(\Kofus\Media\Entity\PdfEntity $pdf, array $options=array())
    {
    	$link = $this->em()->getRepository('Kofus\System\Entity\LinkEntity')->findOneBy(array('linkedNodeId' => $pdf->getNodeId(), 'context' => 'pdf'));
    	if (! $link) {
    	    if ($pdf->getUriSegment()) {
    	        $uriSegment = $pdf->getUriSegment();
    	    } elseif ($pdf->getTitle()) {
    	        $filter = new \Kofus\System\Filter\UriSegment();
    	        $uriSegment = $filter->filter($pdf->getTitle());
    	    } else {
                $uriSegment = Rand::getString(16, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXZY0123456789');
    	    }
    	    
    	    $uri = '/cache/media/pdf/' . $uriSegment . '.pdf';
    	    
    	    // Duplicate uri?
    	    $link = $this->em()->getRepository('Kofus\System\Entity\LinkEntity')->findOneBy(array('uri' => $uri));
    	    if ($link) {
    	        // throw new \Exception('Link for ' . $uri . ' already referes to node ' . $link->getLinkedNodeId() . '; cannot link  ' . $pdf->getNodeId());
    	        $uri = '/cache/media/pdf/' . $uriSegment . '-' . strtolower($pdf->getNodeId()) . '.pdf';
    	    }
    
    		$link = new \Kofus\System\Entity\LinkEntity();
    		$link->setLinkedNodeId($pdf->getNodeId())
        		->setContext('pdf')
        		->setUri($uri);
    
    		$this->em()->persist($link);
    		$this->em()->flush();
    	}
    
    	return $link;
    }
    
    
    public function process($node, $display)
    {
        $config = $this->config()->get('media.image.displays.available.' . $display);
        if (! $config)
            throw new \Exception('No media specifications found for ' . $node->getNodeType() . ' / ' . $display);

        $path = $node->getPath();
        if (! is_readable($path) && isset($config['error_image']))
            $path = $config['error_image'];
        
        if ($node instanceof \Kofus\Media\Entity\PdfEntity)
            $path .= '[0]';
        
        $imagick = new \Imagick();
        $imagick->setResolution(300, 300);
        $imagick->readImage($path);
        $imagick->setOption('nodeId', $node->getNodeId());
        
        $pluginManager = new \Zend\Filter\FilterPluginManager();
        $pluginManager->setServiceLocator($this->getServiceLocator());
        $filenames = scandir(__DIR__ . '/../Imagick/Filter');
        foreach ($filenames as $filename) {
            if (in_array($filename, array('.', '..')))
                continue;
            $classname = 'Kofus\Media\Imagick\Filter\\' . str_replace('.php', '', $filename);
            $filtername = str_replace('.php', '', $filename);
            $pluginManager->setInvokableClass($filtername, $classname);
        }
        
        $filterChain = new \Zend\Filter\FilterChain();
        $filterChain->setPluginManager($pluginManager);
        $filterChain->setOptions($config);
        $imagick = $filterChain->filter($imagick);
        
        return $imagick;
    }
    
    
    
}

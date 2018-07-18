<?php
namespace Kofus\Media;

return array(
    'controllers' => array(
        'invokables' => array(
            'Kofus\Media\Controller\Admin' => 'Kofus\Media\Controller\AdminController',
            'Kofus\Media\Controller\Image' => 'Kofus\Media\Controller\ImageController',
            'Kofus\Media\Controller\Pdf' => 'Kofus\Media\Controller\PdfController',
            'Kofus\Media\Controller\VideoDisplay' => 'Kofus\Media\Controller\VideoDisplayController',
            'Kofus\Media\Controller\VideoFile' => 'Kofus\Media\Controller\VideoFileController',
            'Kofus\Media\Controller\Console' => 'Kofus\Media\Controller\ConsoleController',
        )
    ),
    
    'user' => array(
        'controller_mappings' => array(
            'Kofus\Media\Controller\Console' => 'Console'
        )
    ),
    
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . str_replace('\\', '/', __NAMESPACE__) . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    
    'listeners' => array(
        'KofusMediaListener'
    ),
    
    'service_manager' => array(
        'invokables' => array(
            'KofusMediaService' => 'Kofus\Media\Service\MediaService',
            'KofusMediaListener' => 'Kofus\Media\Listener\MediaListener'
        )
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'Media' => __DIR__ . '/../view'
        ),
        'controller_map' => array(
            'Kofus\Media' => true
        ),
        'module_layouts' => array(
            'Kofus\Media' => 'kofus/layout/admin'
        )
    ),
    
    'view_helpers' => array(
        'invokables' => array(
            'media' => 'Kofus\Media\View\Helper\MediaHelper',
            'fileSize' => 'Kofus\Media\View\Helper\FileSizeHelper'
        )
    ),
    
    'controller_plugins' => array(
        'invokables' => array(
            'media' => 'Kofus\Media\Controller\Plugin\MediaPlugin'
        )
    ),

);

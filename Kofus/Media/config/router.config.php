<?php
return array(
    'router' => array(
        'routes' => array(
            'kofus_media_image' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/cache/media/image/:display/:filename',
                    'constraints' => array(),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kofus\Media\Controller',
                        'controller' => 'image',
                        'action' => 'process'
                    )
                )
            ),
            'kofus_media_video' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/cache/media/video/:filename',
                    'constraints' => array(),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kofus\Media\Controller',
                        'controller' => 'video-file',
                        'action' => 'dump'
                    )
                )
            ),
            'kofus_media_pdf' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/cache/media/pdf/:filename',
                    'constraints' => array(),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kofus\Media\Controller',
                        'controller' => 'pdf',
                        'action' => 'dump'
                    )
                )
            ),
            'kofus_media' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/:language/' . KOFUS_ROUTE_SEGMENT . '/media/:controller/:action[/:id[/:id2]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'language' => '[a-z][a-z]'
                    ),
                    'defaults' => array(
                        'language' => 'de',
                        '__NAMESPACE__' => 'Kofus\Media\Controller'
                    )
                )
            )
        )
    )
);
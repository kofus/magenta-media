<?php
return array(
    'console' => array(
        'router' => array(
            'routes' => array(
                'hashes' => array(
                    'options' => array(
                        'route' => '(rebuild|remove) hashes <node_type>',
                        'help_text' => 'Rebuild or remove file hashes for given node type',
                        'defaults' => array(
                            'action' => 'hashes',
                            'controller' => 'console',
                            '__NAMESPACE__' => 'Kofus\Media\Controller'
                        ),
                    )
                ),
            )
        )
    )
);
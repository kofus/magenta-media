<?php
return array(
    'nodes' => array (
        'available' => array (
            'IMG' => array (
                'label' => 'Image',
                'label_pl' => 'Images',
                'entity' => 'Kofus\Media\Entity\ImageEntity',
                'controllers' => array (
                    'Kofus\Media\Controller\Image'
                ),
                'form' => array (
                    'add' => array (
                        'fieldsets' => array (
                            'upload' => array (
                                'class' => 'Kofus\Media\Form\Fieldset\Image\UploadFieldset',
                                'hydrator' => 'Kofus\Media\Form\Hydrator\Image\UploadHydrator'
                            )
                        )
                    ),
                    'edit' => array (
                        'fieldsets' => array (
                            'upload' => array (
                                'class' => 'Kofus\Media\Form\Fieldset\Image\UploadEditFieldset',
                                'hydrator' => 'Kofus\Media\Form\Hydrator\Image\UploadEditHydrator'
                            )
                        )
                    )
                )
                
            ),
            'PDF' => array (
                'label' => 'PDF',
                'label_pl' => 'PDFs',
                'entity' => 'Kofus\Media\Entity\PdfEntity',
                'controllers' => array (
                    'Kofus\Media\Controller\Pdf'
                ),
                'form' => array (
                    'add' => array (
                        'fieldsets' => array (
                            'upload' => array (
                                'class' => 'Kofus\Media\Form\Fieldset\Pdf\UploadFieldset',
                                'hydrator' => 'Kofus\Media\Form\Hydrator\Pdf\UploadHydrator'
                            )
                        )
                    ),
                    'edit' => array (
                        'fieldsets' => array (
                            'upload' => array (
                                'class' => 'Kofus\Media\Form\Fieldset\Pdf\UploadEditFieldset',
                                'hydrator' => 'Kofus\Media\Form\Hydrator\Pdf\UploadEditHydrator'
                            )
                        )
                    )
                )
            ),
            'VD' => array(
                'label' => 'Video Display',
                'label_pl' => 'Video Displays',
                'entity' => 'Kofus\Media\Entity\VideoDisplayEntity',
                'controllers' => array(
                    'Kofus\Media\Controller\VideoDisplay'
                ),
                'form' => array(
                    'default' => array(
                        'fieldsets' => array(
                            'master' => array(
                                'class' => 'Kofus\Media\Form\Fieldset\VideoDisplay\MasterFieldset',
                                'hydrator' => 'Kofus\Media\Form\Hydrator\VideoDisplay\MasterHydrator'
                            )
                        )
                    )
                ),
                'navigation' => array(
                    'list' => array(
                        'add' => array(
                            'icon' => 'glyphicon glyphicon-plus',
                            'label' => 'Add',
                            'route' => 'kofus_system',
                            'controller' => 'node',
                            'action' => 'add',
                            'params' => array(
                            'id' => 'VD'
                                )
                        )
                    )
                )
            ),
            'VF' => array(
                'label' => 'Video File',
                'label_pl' => 'Video Files',
                'entity' => 'Kofus\Media\Entity\VideoFileEntity',
                'controllers' => array(
                    'Kofus\Media\Controller\VideoFile'
                ),
                'form' => array (
                    'add' => array (
                        'fieldsets' => array (
                            'upload' => array (
                                'class' => 'Kofus\Media\Form\Fieldset\VideoFile\UploadFieldset',
                                'hydrator' => 'Kofus\Media\Form\Hydrator\VideoFile\UploadHydrator'
                            )
                        )
                    ),
                    'edit' => array (
                        'fieldsets' => array (
                            'upload' => array (
                                'class' => 'Kofus\Media\Form\Fieldset\VideoFile\UploadEditFieldset',
                                'hydrator' => 'Kofus\Media\Form\Hydrator\VideoFile\UploadEditHydrator'
                            )
                        )
                    )
                )
                
            )
        )
        
    ),
    'relations' => array(
        'available' => array(
            'VD_VF' => array(
            ),
        )
    )
);

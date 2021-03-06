<?php
return array(
    'doctrine' => array(
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'username',
                    'password' => 'password',
                    'dbname'   => 'database',
                )
            )
        ),
                'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'my_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
               /*config dans le module 
                   'path/to/my/entities',
                    'another/path'*/
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                   //dans le module 'My\Namespace' => 'my_annotation_driver'
                )
            )
        )
    ),
);
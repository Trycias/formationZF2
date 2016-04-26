<?php
return array(
    'log' => array(
        'Log\App' => array(
            'writers' => array(
               'file' => array(
                    'name' => 'stream',
                    'priority' => 3, //prod
                    'options' => array(
                        'stream' => 'data/logs/app.log',
                        'filters' => array(
                            'priority' => array(
                                'name' => 'priority',
                                'options' => array( 'priority' => 2)
                            ),
                            'suppress' => array(
                                'name' => 'suppress',
                                'suppress' => array( 'suppress' => false)
                            )
                        ),
                        'formatter' => array(
                                'name' => 'simple',
                                'options' => array( 'dateTimeFormat' => 'Y-m-d H:i:s')
                            ),
                    ),
                ),
            ),
        ),
    ),
);


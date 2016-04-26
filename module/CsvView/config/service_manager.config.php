<?php
return array(
    'service_manager'=> array(
        'invokables' => array(
            'ViewCsvRenderer' => \CsvView\Renderer\CsvRenderer::class,
        ),
        'factories' => array(
            'ViewCsvStrategy' => \CsvView\Strategy\CsvStrategyFactory::class,
        ),
    )
);


<?php
return [
    'propel' => [
        'database' => [
            'connections' => [
                'form' => [
                    'adapter'    => 'mysql',
                    'classname'  => 'Propel\Runtime\Connection\ConnectionWrapper',
                    'dsn'        => 'mysql:host=localhost;dbname=form',
                    'user'       => '<user>',
                    'password'   => '<password>',
                    'attributes' => []
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'form',
            'connections' => ['form']
        ],
        'generator' => [
            'defaultConnection' => 'form',
            'connections' => ['form']
        ]
    ]
];

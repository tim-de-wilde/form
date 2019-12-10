<?php
return [
    'propel' => [
        'database' => [
            'connections' => [
                'form' => [
                    'adapter'    => 'mysql',
                    'classname'  => 'Propel\Runtime\Connection\ConnectionWrapper',
                    'dsn'        => 'mysql:host=localhost;dbname=form',
                    'user'       => 'form',
                    'password'   => 'wolletje',
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

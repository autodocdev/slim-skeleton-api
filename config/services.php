<?php

declare(strict_types=1);

return [
    'dynamodb' => [
        'endpoint'      => $_ENV['DYNAMODB_ENDPOINT'] ?? '',
        'region'        => $_ENV['AWS_REGION'],
        'version'       => 'latest',
        'credentials'   => [
            'key'       => $_ENV['DYNAMODB_ACCESS_KEY'] ?? '',
            'secret'    => $_ENV['DYNAMODB_SECRET_KEY'] ?? '',
        ],
    ],
];

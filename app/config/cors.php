<?php
return [
    'paths' => ['api/*', 'google/*','usuario/new'], // Asegúrate de agregar la ruta de tu API
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:4200'], // Origen de tu frontend
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];

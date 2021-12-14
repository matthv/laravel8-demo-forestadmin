<?php

return [
    'models_directory' => env('MODEL_DIRECTORY', 'app/Models/'),
    'models_namespace' => env('MODEL_NAMESPACE', 'App\Models\\'),
    'json_file_path'   => env('JSON_FILE_PATH', '.forestadmin-schema.json'),
    'api'              => [
        'url'         => env('FOREST_URL', 'https://api.development.forestadmin.com'),
        'secret'      => 'a33754d559dfec688726d147bbc4ff6c36eacdd771e572876a0b54deae9785e3',
        'auth-secret' => 'GIC0R-MFcemxnZEBJz8DxQ',
    ]
];

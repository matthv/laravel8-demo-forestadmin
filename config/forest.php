<?php

return [
    'models_directory' => env('MODEL_DIRECTORY', 'app/Models/'),
    'json_file_path'   => env('JSON_FILE_PATH', '.forestadmin-schema.json'),
    'api'              => [
        'url'         => env('FOREST_URL', 'https://api.development.forestadmin.com'),
        'secret'      => '586f9a1c0f6a443bd590386c07136e17dbabd85ecf029d7b6ab51e912b21425a',
        'auth-secret' => 'GIC0R-MFcemxnZEBJz8DxQ',
    ]
];

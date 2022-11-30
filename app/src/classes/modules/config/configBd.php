<?php

use app\src\classes\modules\utils\helpers;

$settings = helpers::getSettingsApp();

if ($settings['displayErrorDetails']) {

    return [
        'dbHost' => '187.73.210.163',
        'dbName' => 'sicoficial_bd',
        'dbUser' => 'sicoficial_admin',
        'dbPass' => '!Dlfs02**'
    ];

}
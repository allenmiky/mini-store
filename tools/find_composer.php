<?php

$paths = [
    'C:/ProgramData/ComposerSetup/bin/composer.bat',
    'C:/ComposerSetup/bin/composer.bat',
    'C:/xampp/php/composer.phar',
    'C:/Users/Admin/AppData/Roaming/Composer/vendor/bin/composer.bat',
];

foreach ($paths as $path) {
    echo $path . ':' . (file_exists($path) ? 'yes' : 'no') . PHP_EOL;
}

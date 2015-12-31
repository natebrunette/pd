#!/usr/bin/env php

<?php

use Tebru\Pd\PdApplication;

require __DIR__ . '/../vendor/autoload.php';

$application = new PdApplication('Pd', '@package_version@');
$application->run();

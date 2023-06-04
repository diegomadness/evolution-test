<?php
declare(strict_types=1);
require 'vendor/autoload.php';

use App\Controllers\IndexController;

$config = json_decode(file_get_contents('config.json'), true);
if (empty($config)) {
    print_r('Please make sure there is a readable non-empty config.json file in the root directory');
}
/**
 * Due to simplicity of the task, I've decided not to use any frameworks and routing tools
 */
$indexController = new IndexController($config);
$indexController->spin();
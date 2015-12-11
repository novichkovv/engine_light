<?php
/**
 * Created by PhpStorm.
 * User: enovichkov
 * Date: 11.12.2015
 * Time: 13:14
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', __DIR__ . DS);
require_once(ROOT_DIR . 'core' . DS . 'config.php');
require_once(ROOT_DIR . 'core' . DS . 'autoload.php');
$controller = new controller();
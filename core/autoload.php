<?php
/**
 * Created by PhpStorm.
 * User: novichkov
 * Date: 06.03.15
 * Time: 19:20
 */

//class name MUST be of next kind:  'class_name' . '_' . 'folder name'
// folders with classes MUST have postfix "s" and MUST be in root dir.
// E.G. /controllers/index_controller.php

function autoload($class_name)
{
    $exp_arr = explode('_', $class_name);
    if (count($exp_arr) === 1) {
        $folder = 'core';
    } else {
        $n = array_pop($exp_arr);
        $folder = $n . ($n[strlen($n) - 1] == 's' ? 'es' : 's');
    }
    switch($folder) {
        case "controllers":
        case "templates":
            $class_file = ROOT_DIR . $folder . DS . $class_name . '.php';
            break;
        default:
            $class_file = ROOT_DIR . $folder . DS . $class_name . '.php';
            break;
    }
    if (file_exists($class_file)) {
        require_once($class_file);
    }
}
spl_autoload_register('autoload');
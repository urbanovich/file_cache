<?php

ob_start();

$flag = 'file_cache.flag';

if (file_exists($flag)
    //disable caching ajax request
    && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

    $root_path = dirname(__FILE__);
    $path_to_cache = $root_path . '/file_cache';

    if (file_exists($path_to_cache)
        && is_writable($path_to_cache)
        //disable caching ajax request
        && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

        $last_pos_slash = strrpos($_SERVER['REQUEST_URI'], '/');
        $path_dir = substr($_SERVER['REQUEST_URI'], 0, $last_pos_slash);
        $path_file = substr($_SERVER['REQUEST_URI'], $last_pos_slash);

        if(!empty($path_dir))
            $file_name = '/' . basename($path_dir);
        else
            $file_name = '/index.html';

        $path_file = ($path_file != '/') ? $path_file : $file_name ;
        $path_to_cache_file = $path_to_cache . $path_dir . $path_file;

        if(file_exists($path_to_cache_file)) {

            echo file_get_contents($path_to_cache_file);
            exit;
        }

    } else {
        die ('Directory "' . $path_to_cache . '" not exist or not writable.');
    }

}

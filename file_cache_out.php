<?php

$flag = 'file_cache.flag';

if (file_exists($flag)
    && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

    $exceptions = array(
        'cart',
    );
    foreach ($exceptions as $exception) {
        if (strpos($_SERVER['REQUEST_URI'], $exception) !== false) {
            exit;
        }
    }

    if ($page = ob_get_contents()) {

        $root_path = dirname(__FILE__);
        $path_to_cache = $root_path . '/file_cache';

        if (file_exists($path_to_cache) && is_writable($path_to_cache)) {

            $last_pos_slash = strrpos($_SERVER['REQUEST_URI'], '/');
            $path_dir = substr($_SERVER['REQUEST_URI'], 0, $last_pos_slash);
            $path_file = substr($_SERVER['REQUEST_URI'], $last_pos_slash);

            if(!empty($path_dir))
                $file_name = '/' . basename($path_dir);
            else
                $file_name = '/index.html';

            $path_file = ($path_file != '/') ? $path_file : $file_name ;
            $path_to_cache_file = $path_to_cache . $path_dir . $path_file;

            if(!file_exists($path_to_cache_file)) {
                @mkdir(dirname($path_to_cache_file), 0777, true);
                @file_put_contents($path_to_cache_file, $page);
                @chmod($path_to_cache_file, 0777);
            }

        } else {
            die ('Directory "' . $path_to_cache . '" not exist or not writable.');
        }
    }
}
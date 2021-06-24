<?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    spl_autoload_register(function($class) {
        include_once 'libs/'.$class.'.php';
    });
    include_once 'app/config/config.php';

    Session::init();
    $main = new Main();
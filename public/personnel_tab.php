<?php
    session_start();
    require __DIR__.'/../inc/flash.php';
    require __DIR__.'/../inc/func_personnel.php';
    require_once __DIR__.'/../features/Personnel.php';
    require __DIR__.'/../inc/header.php';
    //require_login();
    $errors = [];
    $inputs = [];
    $valid = false;
    $default_array = Personnel::read();
    $total = count($default_array);
    $request_method = strtoupper($_SERVER["REQUEST_METHOD"]);
    if($request_method === 'GET') {
        require __DIR__.'/../get/personnel_tab.php';
    } elseif ($request_method === 'POST') {
        delete_personnel();
        require __DIR__.'/../post/personnel_tab.php';
        header('Location: personnel_tab.php', true, 303);
        exit;
    }
    require __DIR__.'/../inc/footer.php';
<?php
    session_start();
    require __DIR__.'/../inc/flash.php';
    require __DIR__.'/../inc/func_client.php';
    require_once __DIR__.'/../features/Client.php';
    require __DIR__.'/../inc/header.php';
    //require_login();
    $errors = [];
    $inputs = [];
    $valid = false;
    $default_array = Client::read();
    $total = count($default_array);
    $request_method = strtoupper($_SERVER["REQUEST_METHOD"]);
    if($request_method === 'GET') {
        require __DIR__.'/../get/client_tab.php';
    } elseif ($request_method === 'POST') {
        delete_client();
        require __DIR__.'/../post/client_tab.php';
        header('Location: client_tab.php', true, 303);
        exit;
    }
    require __DIR__.'/../inc/footer.php';
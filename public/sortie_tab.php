<?php
    session_start();
    require __DIR__.'/../inc/flash.php';
    require __DIR__.'/../inc/func_sortie.php';
    require_once __DIR__.'/../features/Sortie.php';
    require __DIR__.'/../inc/header.php';
    //require_login();
    $errors = [];
    $inputs = [];
    $valid = false;
    $default_array = Sortie::read();
    $total = count($default_array);
    $request_method = strtoupper($_SERVER["REQUEST_METHOD"]);
    if($request_method === 'GET') {
        require __DIR__.'/../get/sortie_tab.php';
    } elseif ($request_method === 'POST') {
        delete_sortie();
        require __DIR__.'/../post/sortie_tab.php';
        header('Location: sortie_tab.php', true, 303);
        exit;
    }
    require __DIR__.'/../inc/footer.php';
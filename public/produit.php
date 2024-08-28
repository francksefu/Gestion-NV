<?php
    session_start();
    require __DIR__.'/../inc/func_produit.php';
    require __DIR__.'/../inc/flash.php';
    require_once __DIR__.'/../features/Produit.php';
    require __DIR__.'/../inc/header.php';
    require __DIR__.'/func_produit.php';
    //require_login();
    $errors = [];
    $inputs = [];
    $valid = false;
    $request_method = strtoupper($_SERVER["REQUEST_METHOD"]);
    if($request_method === 'GET') {
        require __DIR__.'/../get/produit.php';
    } elseif ($request_method === 'POST') {
        require __DIR__.'/../post/produit.php';
        header('Location: produit.php', true, 303);
        exit;
    }
    require __DIR__.'/../inc/footer.php';

    
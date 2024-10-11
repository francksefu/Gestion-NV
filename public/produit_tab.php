<?php
    session_start();
    require __DIR__.'/../inc/flash.php';
    require __DIR__.'/../inc/func_produit.php';
    require_once __DIR__.'/../features/Produit.php';
    require __DIR__.'/../inc/header.php';
    require __DIR__.'/func_produit.php';
    //require_login();
    $errors = [];
    $inputs = [];
    $valid = false;
    $produit = new Produit();
    $default_array = $produit->read();
    $total = count($default_array);
    $request_method = strtoupper($_SERVER["REQUEST_METHOD"]);
    if($request_method === 'GET') {
        require __DIR__.'/../get/produit_tab.php';
    } elseif ($request_method === 'POST') {
        delete_produit();
        require __DIR__.'/../post/produit_tab.php';
        header('Location: produit_tab.php', true, 303);
        exit;
    }
    require __DIR__.'/../inc/footer.php';
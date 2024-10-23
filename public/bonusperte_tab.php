<?php
    session_start();
    require __DIR__.'/../inc/flash.php';
    require __DIR__.'/../inc/func_bonusperte.php';
    require __DIR__.'/../inc/func_produit.php';
    require_once __DIR__.'/../features/Produit.php';
    require_once __DIR__.'/../features/BonusPerte.php';
    require __DIR__.'/../inc/header.php';
    //require_login();
    $errors = [];
    $inputs = [];
    $valid = false;
    $produit = new Produit();
    $allProduct = $produit->read();
    $default_array = BonusPerte::read();
    $total = count($default_array);
    $request_method = strtoupper($_SERVER["REQUEST_METHOD"]);
    if($request_method === 'GET') {
        require __DIR__.'/../get/bonusperte_tab.php';
    } elseif ($request_method === 'POST') {
        delete_bonusperte();
        require __DIR__.'/../post/bonusperte_tab.php';
        header('Location: bonusperte_tab.php', true, 303);
        exit;
    }
    require __DIR__.'/../inc/footer.php';
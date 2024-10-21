<?php
    session_start();
    require __DIR__.'/../inc/func_ventes.php';
    require __DIR__.'/../inc/func_client.php';
    require __DIR__.'/../inc/func_produit.php';
    require __DIR__.'/../inc/flash.php';
    require_once __DIR__.'/../features/Ventes.php';
    require_once __DIR__.'/../features/Produit.php';
    require_once __DIR__.'/../features/Client.php';
    require __DIR__.'/../inc/header.php';
    //require_login();
    $errors = [];
    $inputs = [];
    $valid = false;
    $produit = new Produit();
    $array_of_clients = Client::read();
    $array_of_products = $produit->read(); 
    $request_method = strtoupper($_SERVER["REQUEST_METHOD"]);
    if($request_method === 'GET') {
        require __DIR__.'/../get/ventes.php';
    } elseif ($request_method === 'POST') {
        require __DIR__.'/../post/ventes.php';
        header('Location: ventes.php', true, 303);
        exit;
    }
    require __DIR__.'/../inc/footer.php';

    
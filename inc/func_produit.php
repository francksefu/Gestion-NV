<?php

function add_update_produit($urlpost, $flash = '', $Nom = '', $PrixAchat = '', $PrixVente = '', $PrixVmin = '', $QuantiteStock = '', $QuantiteStockMin = '', $DescriptionP = '', $addorupdate = 'add', $id = '') {
    $width = 10;
    $content = "
    $flash
<h2 class='text-secondary m-2 text-center'>Produit</h2>
    <form method='post' enctype='multipart/form-data' action='$urlpost' class='container-fluid'>
        <div class='row mb-3'>
            <div class='col-md-$width'>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Nom du produit </span>
                    <input type='text' name='Nom' class='form-control' value='$Nom' placeholder='Ecrivez le nom du produit ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <div class='mb-3'>
                    <label for='formFile' class='form-label text-secondary'>Ajouter une image du produit</label>
                    <input class='form-control' type='file' name='file' id='formFile'>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Prix d achat </span>
                    <input type='number' step='0.0001' name='PrixAchat' class='form-control' value='$PrixAchat' placeholder='Ecrivez le PA ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Prix de vente </span>
                    <input type='number' step='0.0001' name='PrixVente' class='form-control' value='$PrixVente' placeholder='Ecrivez le PV ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Prix de vente minimum </span>
                    <input type='number' step='0.0001' name='PrixVmin' class='form-control' value='$PrixVmin' placeholder='Ecrivez le PV ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Quantite en stock</span>
                    <input required type='number' name='QuantiteStock' step='0.001' value='$QuantiteStock' class='form-control number' placeholder='ecrivez la quantite en stock' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Quantite stock minimum</span>
                    <input required type='number' name='QuantiteStockMin' step='0.001' value='$QuantiteStockMin' class='form-control number' placeholder='ecrivez la quantite en stock' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <small class='text-danger number-text'></small>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Description du produit</span>
                    <textarea name='DescriptionP' class='form-control number' placeholder='ecrivez la description du produit' aria-label='Username' aria-describedby='basic-addon1'>$DescriptionP</textarea>
                </div>
                
            </div>
        </div>
        <input type='hidden' name='addorupdate' value='$addorupdate'>
        <input type='hidden' name='id' value='$id'>
        <input type='submit' id='submit' class='btn btn-primary' value='Soumettre'>
    </form>";
    return $content;
}

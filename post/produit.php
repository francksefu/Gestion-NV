<?php
    //$Nom = '', $ImageLink = '' , $PrixAchat = '', $PrixVente = '', $PrixVmin = '', $QuantiteStock = '', $QuantiteStockMin = '', $DescriptionP = '
    
    $array = filter_validate_produit();
    $Nom = $array['Nom'];
    $ImageLink = $array['ImageLink'];
    $PrixAchat = $array['PrixAchat'];
    $PrixVente = $array['PrixVente'];
    $PrixVmin = $array['PrixVmin'];
    $QuantiteStock = $array['QuantiteStock'];
    $QuantiteStockMin = $array['QuantiteStockMin'];
    $DescriptionP = $array['DescriptionP'];
    $path = $array['path'];
    $produit = new Produit();
    if ($Nom) {
        if ($produit->insert($Nom, $ImageLink, $PrixAchat, $PrixVente, $PrixVmin, $QuantiteStock, $QuantiteStockMin, $DescriptionP, $path)) {
            redirect_with_message('Insertion fait avec success !', FLASH_SUCCESS, 'produit', "produit.php");
        } else {
            redirect_with_message('Error, l insertion n a pas ete faite', FLASH_ERROR, 'produit', "produit.php");
        }
    } else {
        redirect_with_message('Error, l insertion n a pas ete faite', FLASH_ERROR, 'produit', "produit.php");
    }
    
    


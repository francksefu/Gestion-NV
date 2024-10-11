<?php

    $addorupdate = filter_input(INPUT_POST, 'addorupdate', FILTER_SANITIZE_SPECIAL_CHARS);
    $input['addorupdate'] = $addorupdate;

    if($addorupdate === false) {
        $errors['addorupdate'] = 'Impossible de modifier';
        redirect_with_message('Impossible de modifier !', FLASH_ERROR, 'produit', "produit_tab.php");
    }
if ($addorupdate === 'update') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    $input['id'] = $id;

    if($id === false) {
        $errors['id'] = 'Impossible de modifier';
        redirect_with_message('Impossible de modifier', FLASH_ERROR, 'produit', "produit_tab.php");
    } 
    if((int) $id) {
        $array = filter_validate_produit("produit_tab.php");
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
            if ($produit->update($Nom, $ImageLink, $PrixAchat, $PrixVente, $PrixVmin, $QuantiteStock, $QuantiteStockMin, $DescriptionP,$path, $id)) {
                redirect_with_message('Modification fait avec success !', FLASH_SUCCESS, 'produit', "produit_tab.php");
            }
        } else {
            redirect_with_message('Error, la modification n a pas ete faite', FLASH_ERROR, 'produit', "produit_tab.php");
        }
    }
    
}

if ($addorupdate === 'add') {
    $array = filter_validate_produit("produit_tab.php");
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
            redirect_with_message('Insertion fait avec success !', FLASH_SUCCESS, 'produit', "produit_tab.php");
        } else {
            redirect_with_message('Error, l insertion n a pas ete faite', FLASH_ERROR, 'produit', "produit_tab.php");
        }
    } else {
        redirect_with_message('Error, l insertion n a pas ete faite', FLASH_ERROR, 'produit', "produit_tab.php");
    }
}

<?php

function add_update_bonusperte($urlpost, $flash = '', $idProduit = '', $QuantiteGagne = '', $QuantitePerdu = '', $DatesD = '', $Motif = '',$addorupdate = 'add', $id = '') {
    $width = 10;
    $option = selectOptionForProduct($idProduit);
    $content = "
    $flash
<h2 class='text-secondary m-2 text-center'> Bonus ou Perte</h2>
    <form method='post' enctype='multipart/form-data' action='$urlpost' class='container-fluid'>
        <div class='row mb-3'>
            <div class='col-md-$width'>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Produit</span>
                    <select name='idProduit' class='js-example-basic-single form-select form-select-lg'>
                        $option
                    </select>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Quantite gagne </span>
                    <input type='text' name='QuantiteGagne' class='form-control' value='$QuantiteGagne' placeholder='Ecrivez quantite gagnee ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Quantite perdu </span>
                    <input type='text' name='QuantitePerdu' class='form-control' value='$QuantitePerdu' placeholder='Ecrivez la quantite perdue ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>

                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Motif </span>
                    <textarea name='Motif' class='form-control number' placeholder='ecrivez le motif ici ' aria-label='Username' aria-describedby='basic-addon1'>$Motif</textarea>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Date </span>
                    <input type='date' name='DatesD' class='form-control' value='$DatesD' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                
            </div>
        </div>
        <input type='hidden' name='addorupdate' value='$addorupdate'>
        <input type='hidden' name='id' value='$id'>
        <input type='submit' class='btn btn-primary' value='Soumettre'>
    </form>";
    return $content;
}

function filter_validate_bonusperte( $url = 'bonusperte_tab.php')
{
    $idProduit = filter_input(INPUT_POST, 'idProduit', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $Motif = filter_input(INPUT_POST, 'Motif', FILTER_SANITIZE_SPECIAL_CHARS);
    $QuantiteGagne = filter_input(INPUT_POST, 'QuantiteGagne', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $QuantitePerdu = filter_input(INPUT_POST, 'QuantitePerdu', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $DatesD = filter_input(INPUT_POST, 'DatesD', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if($idProduit === false) {
        redirect_with_message('Le produit doit etre present doit etre present !', FLASH_ERROR, 'bonusperte', $url);
    }

    if($DatesD === false) {
        redirect_with_message('La date doit etre presente doit etre present !', FLASH_ERROR, 'bonusperte', $url);
    }

    $addorupdate = filter_input(INPUT_POST, 'addorupdate', FILTER_SANITIZE_SPECIAL_CHARS);
  
    return [ 'idProduit' => $idProduit,'QuantiteGagne' => $QuantiteGagne,'QuantitePerdu' => $QuantitePerdu, 'DatesD' => $DatesD, 'Motif' => $Motif, 'addorupdate' => $addorupdate, 'url' => $url];
    
    //franck
}

function delete_bonusperte()
{
    if (isset($_POST['delete'])) {
        $delete = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_SPECIAL_CHARS);
        $input['delete'] = $delete;
    
        if($delete === false) {
            $errors['delete'] = 'Impossible de supprimer';
            redirect_with_message('Impossible de supprimer', FLASH_ERROR, 'bonusperte', "bonusperte_tab.php");
        }
        $id = explode('_', $delete)[1];
        
        BonusPerte::read($id);
        
        if ( BonusPerte::delete((int) $id)) {
            redirect_with_message('Suppression effectuer avec success', FLASH_SUCCESS, 'bonusperte', "bonusperte_tab.php");
        } else {
            redirect_with_message('Erreur : La suppression n a pu pas etre effectuer', FLASH_ERROR, 'bonusperte', "bonusperte_tab.php");
        }
    }
}


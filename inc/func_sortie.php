<?php

function add_update_sortie($urlpost, $flash = '', $TypeD = '', $Montant = '', $il_pris_quoi = '', $DatesD = '', $addorupdate = 'add', $id = '') {
    $width = 10;
    $content = "
    $flash
<h2 class='text-secondary m-2 text-center'>Sortie</h2>
    <form method='post' enctype='multipart/form-data' action='$urlpost' class='container-fluid'>
        <div class='row mb-3'>
            <div class='col-md-$width'>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Type de sortie</span>
                    <select name='$TypeD' class='form-select form-select-lg mb-3' aria-label='.form-select-lg example'>
                        <option selected>Open this select menu</option>
                        <option value='1'>One</option>
                        <option value='2'>Two</option>
                        <option value='3'>Three</option>
                    </select>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Montant </span>
                    <input type='number' step='0.0001' name='Telephone' class='form-control' value='$Montant' placeholder='Ecrivez le montant en $ ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Motif</span>
                    <textarea name='il_pris_quoi' class='form-control number' placeholder='ecrivez le motif' aria-label='Username' aria-describedby='basic-addon1'>$il_pris_quoi</textarea>
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

function filter_validate_sortie( $url = 'sortie_tab.php')
{
    $TypeD = filter_input(INPUT_POST, 'TypeD', FILTER_SANITIZE_SPECIAL_CHARS);
    $il_pris_quoi = filter_input(INPUT_POST, 'il_pris_quoi', FILTER_SANITIZE_SPECIAL_CHARS);
    $Montant = filter_input(INPUT_POST, 'Montant', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $DatesD = filter_input(INPUT_POST, 'DatesD', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if($Montant === false) {
        $errors['Nom'] = 'Le nom doit etre present';
        redirect_with_message('Le montant doit etre present !', FLASH_ERROR, 'sortie', $url);
    }

    if($DatesD === false) {
        $errors['Nom'] = 'Le nom doit etre present';
        redirect_with_message('La date doit etre presente !', FLASH_ERROR, 'sortie', $url);
    }

    $addorupdate = filter_input(INPUT_POST, 'addorupdate', FILTER_SANITIZE_SPECIAL_CHARS);
  
    return [ 'TypeD' => $TypeD,'Montant' => $Montant, 'il_pris_quoi' => $il_pris_quoi, 'DatesD' => $DatesD, 'addorupdate' => $addorupdate, 'url' => $url];
    
    //franck
}

function delete_sortie()
{
    if (isset($_POST['delete'])) {
        $delete = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_SPECIAL_CHARS);
        $input['delete'] = $delete;
    
        if($delete === false) {
            $errors['delete'] = 'Impossible de supprimer';
            redirect_with_message('Impossible de supprimer', FLASH_ERROR, 'sortie', "sortie_tab.php");
        }
        $id = explode('_', $delete)[1];
        
        Sortie::read($id);
        
        if ( Sortie::delete((int) $id)) {
            redirect_with_message('Suppression effectuer avec success', FLASH_SUCCESS, 'sortie', "sortie_tab.php");
        } else {
            redirect_with_message('Erreur : La suppression n a pu pas etre effectuer', FLASH_ERROR, 'sortie', "sortie_tab.php");
        }
    }
}


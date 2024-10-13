<?php

function add_update_personnel($urlpost, $flash = '', $NomP = '', $Telephone = '', $SalaireDeBase = '', $Poste = '', $PasswordP = '', $addorupdate = 'add', $id = '') {
    $width = 10;
    $content = "
    $flash
<h2 class='text-secondary m-2 text-center'>Personnel</h2>
    <form method='post' enctype='multipart/form-data' action='$urlpost' class='container-fluid'>
        <div class='row mb-3'>
            <div class='col-md-$width'>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Nom du personnel </span>
                    <input type='text' name='NomP' class='form-control' value='$NomP' placeholder='Ecrivez le nom du personnel ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Numero de telephone du personnel </span>
                    <input type='text' name='Telephone' class='form-control' value='$Telephone' placeholder='Ecrivez le numero de phone ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Salaire de base du personnel </span>
                    <input type='number' step='0.0001'  name='SalaireDeBase' class='form-control' value='$SalaireDeBase' placeholder='Ecrivez le salaire de base ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Poste </span>
                    <input type='text' name='Poste' class='form-control' value='$Poste' placeholder='Ecrivez le salaire de base ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Mot de passe </span>
                    <input type='text' name='PasswordP' class='form-control' value='$PasswordP' placeholder='Ecrivez le mot de passe du personnel ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                
            </div>
        </div>
        <input type='hidden' name='addorupdate' value='$addorupdate'>
        <input type='hidden' name='id' value='$id'>
        <input type='submit' class='btn btn-primary' value='Soumettre'>
    </form>";
    return $content;
}

function filter_validate_personnel( $url = 'personnel_tab.php')
{
    $NomP = filter_input(INPUT_POST, 'NomP', FILTER_SANITIZE_SPECIAL_CHARS);
    $Telephone = filter_input(INPUT_POST, 'Telephone', FILTER_SANITIZE_SPECIAL_CHARS);
    $SalaireDeBase = filter_input(INPUT_POST, 'SalaireDeBase', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $Poste = filter_input(INPUT_POST, 'Poste', FILTER_SANITIZE_SPECIAL_CHARS);
    $PasswordP = filter_input(INPUT_POST, 'PasswordP', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if($NomP === false) {
        $errors['NomP'] = 'Le nom doit etre present';
        redirect_with_message('Le nom doit etre present !', FLASH_ERROR, 'personnel', $url);
    }

    if($SalaireDeBase === false) {
        $errors['NomP'] = 'Le nom doit etre present';
        redirect_with_message('Le salire doit etre present et doit etre un chiffre !', FLASH_ERROR, 'personnel', $url);
    }

    if($PasswordP === false) {
        $errors['NomP'] = 'Le nom doit etre present';
        redirect_with_message('Le mot de passe doit etre present !', FLASH_ERROR, 'personnel', $url);
    }

    $addorupdate = filter_input(INPUT_POST, 'addorupdate', FILTER_SANITIZE_SPECIAL_CHARS);
  
    return [ 'NomP' => $NomP,'Telephone' => $Telephone, 'SalaireDeBase' => $SalaireDeBase, 'Poste' => $Poste, 'PasswordP' => $PasswordP, 'addorupdate' => $addorupdate, 'url' => $url];
    
    //franck
}

function delete_personnel()
{
    if (isset($_POST['delete'])) {
        $delete = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_SPECIAL_CHARS);
        $input['delete'] = $delete;
    
        if($delete === false) {
            $errors['delete'] = 'Impossible de supprimer';
            redirect_with_message('Impossible de supprimer', FLASH_ERROR, 'personnel', "personnel_tab.php");
        }
        $id = explode('_', $delete)[1];
        
        Personnel::read($id);
        
        if ( Personnel::delete((int) $id)) {
            redirect_with_message('Suppression effectuer avec success', FLASH_SUCCESS, 'personnel', "personnel_tab.php");
        } else {
            redirect_with_message('Erreur : La suppression n a pu pas etre effectuer', FLASH_ERROR, 'personnel', "personnel_tab.php");
        }
    }
}


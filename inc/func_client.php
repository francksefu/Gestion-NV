<?php

function add_update_client($urlpost, $flash = '', $NomClient = '', $Telephone = '', $addorupdate = 'add', $id = '') {
    $width = 10;
    $content = "
    $flash
<h2 class='text-secondary m-2 text-center'>Client</h2>
    <form method='post' enctype='multipart/form-data' action='$urlpost' class='container-fluid'>
        <div class='row mb-3'>
            <div class='col-md-$width'>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Nom du client </span>
                    <input type='text' name='NomClient' class='form-control' value='$NomClient' placeholder='Ecrivez le nom du client ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text' id='basic-addon1'>Numero de telephone du client </span>
                    <input type='text' name='Telephone' class='form-control' value='$Telephone' placeholder='Ecrivez le numero de telephone du client ici' aria-label='Username' aria-describedby='basic-addon1'>
                </div>
                
            </div>
        </div>
        <input type='hidden' name='addorupdate' value='$addorupdate'>
        <input type='hidden' name='id' value='$id'>
        <input type='submit' class='btn btn-primary' value='Soumettre'>
    </form>";
    return $content;
}

function filter_validate_client( $url = 'client_tab.php')
{
    $NomClient = filter_input(INPUT_POST, 'NomClient', FILTER_SANITIZE_SPECIAL_CHARS);
    $Telephone = filter_input(INPUT_POST, 'Telephone', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if($NomClient === false) {
        $errors['Nom'] = 'Le nom doit etre present';
        redirect_with_message('Le nom doit etre present !', FLASH_ERROR, 'client', $url);
    }

    $addorupdate = filter_input(INPUT_POST, 'addorupdate', FILTER_SANITIZE_SPECIAL_CHARS);
  
    return [ 'NomClient' => $NomClient,'Telephone' => $Telephone, 'addorupdate' => $addorupdate, 'url' => $url];
    
    //franck
}

function delete_client()
{
    if (isset($_POST['delete'])) {
        $delete = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_SPECIAL_CHARS);
        $input['delete'] = $delete;
    
        if($delete === false) {
            $errors['delete'] = 'Impossible de supprimer';
            redirect_with_message('Impossible de supprimer', FLASH_ERROR, 'client', "client_tab.php");
        }
        $idClient = explode('_', $delete)[1];
        
        Client::read($idClient);
        
        if ( Client::delete((int) $idClient)) {
            redirect_with_message('Suppression effectuer avec success', FLASH_SUCCESS, 'client', "client_tab.php");
        } else {
            redirect_with_message('Erreur : La suppression n a pu pas etre effectuer', FLASH_ERROR, 'client', "client_tab.php");
        }
    }
}


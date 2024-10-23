<?php

$addorupdate = filter_input(INPUT_POST, 'addorupdate', FILTER_SANITIZE_SPECIAL_CHARS);
$input['addorupdate'] = $addorupdate;

    if($addorupdate === false) {
        $errors['addorupdate'] = 'Impossible de modifier';
        redirect_with_message('Impossible de modifier !', FLASH_ERROR, 'client', "client_tab.php");
    }

$array = filter_validate_client();
$NomClient = $array['NomClient'];
$Telephone = $array['Telephone'];

if ($addorupdate === 'update') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    $input['id'] = $id;

    if($id === false) {
        $errors['id'] = 'Impossible de modifier';
        redirect_with_message('Impossible de modifier', FLASH_ERROR, 'client', "client_tab.php");
    }

    

    if((int) $id) {
        if (! empty($NomClient)) {
            if (Client::update($NomClient, $Telephone, $id)) {
                redirect_with_message('Modification fait avec success !', FLASH_SUCCESS, 'client', "client_tab.php");
            }
        } else {
            redirect_with_message('Error, la modification n a pas ete faite', FLASH_ERROR, 'client', "client_tab.php");
        }
    }
    
}

if ($addorupdate === 'add') {
    if (! empty($NomClient)) {
        if (Client::insert($NomClient, $Telephone)) {
            redirect_with_message('Insertion fait avec success !', FLASH_SUCCESS, 'client', "client_tab.php");
        } else {
            redirect_with_message('Error, l insertion n a pas ete faite', FLASH_ERROR, 'client', "client_tab.php");
        }
    } else {
        redirect_with_message('Error, l insertion n a pas ete faite', FLASH_ERROR, 'client', "client_tab.php");
    }
}

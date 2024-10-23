<?php

$addorupdate = filter_input(INPUT_POST, 'addorupdate', FILTER_SANITIZE_SPECIAL_CHARS);
$input['addorupdate'] = $addorupdate;

    if($addorupdate === false) {
        $errors['addorupdate'] = 'Impossible de modifier';
        redirect_with_message('Impossible de modifier !', FLASH_ERROR, 'personnel', "personnel_tab.php");
    }

$array = filter_validate_personnel();
$NomP = $array['NomP'];
$Telephone = $array['Telephone'];
$SalaireDeBase = $array['SalaireDeBase'];
$Poste = $array['Poste'];
$PasswordP = $array['PasswordP'];

if ($addorupdate === 'update') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    $input['id'] = $id;

    if($id === false) {
        $errors['id'] = 'Impossible de modifier';
        redirect_with_message('Impossible de modifier', FLASH_ERROR, 'personnel', "personnel_tab.php");
    }

    

    if((int) $id) {
        if (! empty($NomP)) {
            if (Personnel::update($NomP, $Telephone, $SalaireDeBase, $Poste, $PasswordP, $id)) {
                redirect_with_message('Modification fait avec success !', FLASH_SUCCESS, 'personnel', "personnel_tab.php");
            }
        } else {
            redirect_with_message('Error, la modification n a pas ete faite', FLASH_ERROR, 'personnel', "personnel_tab.php");
        }
    }
    
}

if ($addorupdate === 'add') {
    if (! empty($NomP)) {
        if (Personnel::insert($NomP, $Telephone, $SalaireDeBase, $Poste, $PasswordP)) {
            redirect_with_message('Insertion fait avec success !', FLASH_SUCCESS, 'personnel', "personnel_tab.php");
        } else {
            redirect_with_message('Error, l insertion n a pas ete faite', FLASH_ERROR, 'personnel', "personnel_tab.php");
        }
    } else {
        redirect_with_message('Error, l insertion n a pas ete faite', FLASH_ERROR, 'personnel', "personnel_tab.php");
    }
}

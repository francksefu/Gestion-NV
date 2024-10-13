<?php

$addorupdate = filter_input(INPUT_POST, 'addorupdate', FILTER_SANITIZE_SPECIAL_CHARS);
$input['addorupdate'] = $addorupdate;

    if($addorupdate === false) {
        $errors['addorupdate'] = 'Impossible de modifier';
        redirect_with_message('Impossible de modifier !', FLASH_ERROR, 'sortie', "sortie_tab.php");
    }

$array = filter_validate_sortie();
$TypeD = $array['TypeD'];
$Montant = $array['Montant'];
$il_pris_quoi = $array['il_pris_quoi'];
$DatesD = $array['DatesD'];

if ($addorupdate === 'update') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    $input['id'] = $id;

    if($id === false) {
        $errors['id'] = 'Impossible de modifier';
        redirect_with_message('Impossible de modifier', FLASH_ERROR, 'sortie', "sortie_tab.php");
    }

    

    if((int) $id) {
        if (! empty($Montant)) {
            if (Sortie::update($TypeD, $Montant, $il_pris_quoi, $DatesD, $id)) {
                redirect_with_message('Modification fait avec success !', FLASH_SUCCESS, 'sortie', "sortie_tab.php");
            }
        } else {
            redirect_with_message('Error, la modification n a pas ete faite', FLASH_ERROR, 'sortie', "sortie_tab.php");
        }
    }
    
}

if ($addorupdate === 'add') {
    if (! empty($TypeD)) {
        if (Sortie::insert($TypeD, $Montant, $il_pris_quoi, $DatesD)) {
            redirect_with_message('Insertion fait avec success !', FLASH_SUCCESS, 'sortie', "sortie_tab.php");
        } else {
            redirect_with_message('Error, l insertion n a pas ete faite', FLASH_ERROR, 'sortie', "sortie_tab.php");
        }
    } else {
        redirect_with_message('Error, l insertion n a pas ete faite', FLASH_ERROR, 'sortie', "sortie_tab.php");
    }
}

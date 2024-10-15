<?php

$addorupdate = filter_input(INPUT_POST, 'addorupdate', FILTER_SANITIZE_SPECIAL_CHARS);
$input['addorupdate'] = $addorupdate;

    if($addorupdate === false) {
        $errors['addorupdate'] = 'Impossible de modifier';
        redirect_with_message('Impossible de modifier !', FLASH_ERROR, 'bonusperte', "bonusperte_tab.php");
    }

$array = filter_validate_bonusperte();
$idProduit = $array['idProduit'];
$QuantiteGagne = $array['QuantiteGagne'];
$QuantitePerdu = $array['QuantitePerdu'];
$DatesD = $array['DatesD'];
$Motif = $array['Motif'];

if ($addorupdate === 'update') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    $input['id'] = $id;

    if($id === false) {
        $errors['id'] = 'Impossible de modifier';
        redirect_with_message('Impossible de modifier', FLASH_ERROR, 'bonusperte', "bonusperte_tab.php");
    }

    

    if((int) $id) {
        if (! empty($idProduit)) {
            if (BonusPerte::update($idProduit, $QuantitePerdu ,$QuantiteGagne, $DatesD, $Motif, $id)) {
                redirect_with_message('Modification fait avec success !', FLASH_SUCCESS, 'bonusperte', "bonusperte_tab.php");
            }
        } else {
            redirect_with_message('Error, la modification n a pas ete faite', FLASH_ERROR, 'bonusperte', "bonusperte_tab.php");
        }
    }
    
}

if ($addorupdate === 'add') {
    if (! empty($idProduit)) {
        if (BonusPerte::insert($idProduit, $QuantitePerdu ,$QuantiteGagne, $DatesD, $Motif)) {
            redirect_with_message('Insertion fait avec success !', FLASH_SUCCESS, 'bonusperte', "bonusperte_tab.php");
        } else {
            redirect_with_message('Error, l insertion n a pas ete faite', FLASH_ERROR, 'bonusperte', "bonusperte_tab.php");
        }
    } else {
        redirect_with_message('Error, l insertion n a pas ete faite', FLASH_ERROR, 'bonusperte', "bonusperte_tab.php");
    }
}

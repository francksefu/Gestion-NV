<?php
function filter_validate_produit( $url = 'produit.php')
{
    $url = $url . $_GET['q'];
    $Nom = filter_input(INPUT_POST, 'Nom', FILTER_SANITIZE_SPECIAL_CHARS);
    $PrixAchat = filter_input(INPUT_POST, 'PrixAchat', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $PrixVente = filter_input(INPUT_POST, 'PrixVente', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $PrixVmin = filter_input(INPUT_POST, 'PrixVmin', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $QuantiteStock = filter_input(INPUT_POST, 'QuantiteStock', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $QuantiteStockMin = filter_input(INPUT_POST, 'QuantiteStockMin', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $DescriptionP = filter_input(INPUT_POST, 'Description', FILTER_SANITIZE_SPECIAL_CHARS);
    if($Nom === false) {
        $errors['Nom'] = 'Le nom doit etre present';
        redirect_with_message('Le nom doit etre present !', FLASH_ERROR, 'produit', $url);
    }

    if($PrixAchat === false) {
        $errors['Prix d achat'] = 'Le prix d achat doit etre present';
        redirect_with_message('Le prix d achat doit etre present !', FLASH_ERROR, 'produit', $url);
    }

    if($PrixVente === false) {
        redirect_with_message('Le prix de vente doit etre present !', FLASH_ERROR, 'produit', $url);
    }

    if($PrixVmin === false) {
        redirect_with_message('Le prix de vente minimum doit etre present !', FLASH_ERROR, 'produit', $url);
    }

    if($QuantiteStock === false) {
        redirect_with_message('La quantite en stock doit etre presente !', FLASH_ERROR, 'produit', $url);
    }

    if($QuantiteStockMin === false) {
        redirect_with_message('La quantite en stock min doit etre presente !', FLASH_ERROR, 'produit', $url);
    }

    $addorupdate = filter_input(INPUT_POST, 'addorupdate', FILTER_SANITIZE_SPECIAL_CHARS);
    //

     $MAX_SIZE = 50 * 1024 * 1024; //  50MB

    $UPLOAD_DIR = __DIR__ . '/upload_files';
    if ( isset($_FILES['file'])) {
        $status = $_FILES['file']['error'];
        $filename = $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
    
        if($addorupdate == 'add') {
            // an error occurs
            if ($status !== UPLOAD_ERR_OK) {
                redirect_with_message('Une erreur s est produite lors de l enregistrement du fichier', FLASH_ERROR, 'produit', $url);
            }

            // validate the file size
            $filesize = filesize($tmp);
            if ($filesize > $MAX_SIZE) {
                redirect_with_message("Votre fichier est tres lourd, chercher un autre plus leger qui ne depasse pas $MAX_SIZE", FLASH_ERROR, 'produit', $url);
            }

            // set the filename as the basename + extension
            $uploaded_file = pathinfo($filename, PATHINFO_FILENAME);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            // new file location
            $filepath = $UPLOAD_DIR . '/' . $uploaded_file . ".$extension";
            $f = '';
            if (is_uploaded_file($tmp)) {
                $f .= "The file is a valid uploaded file.";
            } else {
                $f .=  "The file is not a valid uploaded file.";
            }

            if (is_writable($UPLOAD_DIR)) {
                $f .=  "The upload directory is writable.";
            } else {
                $f .= "The upload directory is not writable.";
            }
                // move the file to the upload dir
            $success = move_uploaded_file($tmp, $filepath);
            if (! $success) {
                redirect_with_message("$f <br>   The file was not uploaded .", FLASH_ERROR, 'produit', $url);
            }
        }

        if($addorupdate == 'update' && !empty($filename)) {
            // an error occurs
            if ($status !== UPLOAD_ERR_OK) {
                redirect_with_message('Une erreur s est produite lors de l enregistrement du fichier', FLASH_ERROR, 'produit', $url);
            }

            // validate the file size
            $filesize = filesize($tmp);
            if ($filesize > $MAX_SIZE) {
                redirect_with_message("Votre fichier est tres lourd, chercher un autre plus leger qui ne depasse pas $MAX_SIZE", FLASH_ERROR, 'produit', $url);
            }

            // set the filename as the basename + extension
            $uploaded_file = pathinfo($filename, PATHINFO_FILENAME);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            // new file location
            $filepath = $UPLOAD_DIR . '/' . $uploaded_file . ".$extension";
            $f = '';
            if (is_uploaded_file($tmp)) {
                $f .= "The file is a valid uploaded file.";
            } else {
                $f .=  "The file is not a valid uploaded file.";
            }

            if (is_writable($UPLOAD_DIR)) {
                $f .=  "The upload directory is writable.";
            } else {
                $f .= "The upload directory is not writable.";
            }
                // move the file to the upload dir
            $success = move_uploaded_file($tmp, $filepath);
            if (! $success) {
                redirect_with_message("$f <br>   The file was not uploaded .", FLASH_ERROR, 'produit', $url);
            }
        }
        
        
        return [ 'Nom' => $Nom,'ImageLink' => $filename, 'path' => $filepath,'PrixAchat' => $PrixAchat,'PrixVente' => $PrixVente,'PrixVmin' => $PrixVmin, 'QuantiteStock' => $QuantiteStock,'QuantiteStockMin' => $QuantiteStockMin, 'DescriptionP' => $DescriptionP, 'size' => $filesize, 'addorupdate' => $addorupdate, 'url' => $url];
    
    } else {
        redirect_with_message('Invalid file upload operation', FLASH_ERROR, 'produit', $url);
    }
    //franck
}

function delete_produit()
{
    if (isset($_POST['delete'])) {
        $delete = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_SPECIAL_CHARS);
        $input['delete'] = $delete;
    
        if($delete === false) {
            $errors['delete'] = 'Impossible de supprimer';
            redirect_with_message('Impossible de supprimer', FLASH_ERROR, 'produit', "produit_tab.php");
        }
        $idProduit = explode('_', $delete)[1];
        $produit = new Produit();
        
        $produit_delete = $produit->read($idProduit);
        if (! empty($produit_delete['path'])) {
            unlink($produit_delete["path"]);
        }
        
        if ($produit->delete((int) $idProduit)) {
            redirect_with_message('Suppression effectuer avec success', FLASH_SUCCESS, 'produit', "produit_tab.php");
        } else {
            redirect_with_message('Erreur : La suppression n a pu pas etre effectuer', FLASH_ERROR, 'produit', "produit_tab.php");
        }
    }
}

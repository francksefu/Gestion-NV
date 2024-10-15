<?php flash('bonusperte'); ?>
<main class="container-fluid">
    <h2 class="text-secondary m-2 text-center">Bonus ou Perte</h2>
    <div class="row">
        <div class="col-md-7"></div>
        <div class="col-md-4"><small>total : <?php echo $total ?> </small></div>
    </div>
    <?php echo recherche_dans_tableau(); ?>
    <div class="row">
        <div class="col-md-8">
        </div>
        <button type='button' id="add1" class='btn btn-primary col-md-3 p-2 m-2' data-bs-toggle='modal' data-bs-target='#add'>
            Ajouter bonus ou perte        
        </button>
    </div>
    
<div class='horizontal'>
<table class="table table-bordered">
    <thead>
        <tr>
        <th scope="col">id</th>
        <th scope="col">Produit</th>
        <th scope="col">Quantite Gagne</th>
        <th scope="col">Quantite Perdu</th>
        <th scope="col">Motif</th>
        <th scope="col">Dates</th>
        <th scope="col">Valeur</th>
        <th scope="col">Quantite actuel en stock</th>
        
        <th scope="col">action</th>
        </tr>
    </thead>
    <tbody id='tbody'>
        <?php
            //$auth = (isset($_SESSION['post']) && $_SESSION['post'] !=='directeur');
            foreach($default_array as $array) {
                $array_produit = $produit->read($array['idProduit'])[0];
                $picture = ! empty($array_produit['ImageLink']) && str_contains($array_produit['ImageLink'], '.') ? "upload_files/".$array_produit['ImageLink'] : 'banane.png';
                $see_image_dossier = "<img src='$picture' class='card-img-top'  alt='".$array_produit['DescriptionP']."'>";
                $suppression = "<button type='button' class='btn btn-danger col-md-5 m-1' data-bs-toggle='modal' data-bs-target='#delete_".$array['idBonusPerte']."'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                            <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                          </svg>
                                </button>

                                <button type='button' class='btn btn-primary col-md-5 m-1' data-bs-toggle='modal' data-bs-target='#update_".$array['idBonusPerte']."'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-pen' viewBox='0 0 16 16'>
                            <path d='m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z'/>
                        </svg>
                                </button>";
                
                $line = "
                        <tr>
                            <th>".$array['idBonusPerte']."</th>
                            <td>
                                <div class='d-flex flex-row' id='taille'>
                                    <img src ='$picture' class=' photo m-0' width='70px' height='70px' alt='produit'>
                                    <div class='ps-2 m-0'>
                                    <h4 class='text-end'>".$array_produit['Nom']."</h4>
                                    <small class='text-secondary'>".$array_produit['DescriptionP']."</small><br>
                                    <button type='button' class='btn btn-success m-1' data-bs-toggle='modal' data-bs-target='#picture_".$array['idBonusPerte']."'> Voir photo</button>
                                    </div>
                                </div>
                            </td>
                            <td>".$array['QuantiteGagne']."</td>
                            <td>".$array['QuantitePerdu']."</td>
                            <td>".$array['Motif']."</td>
                            <td>".$array['DatesD']."</td>
                            <td>".($array['QuantiteGagne'] * $array_produit['PrixVente']) - ($array['QuantitePerdu'] * $array_produit['PrixVente'])." $</td>
                            <td>".$array_produit['QuantiteStock']."</td>
                            <td class='row'>
                            
                                $suppression
                                
                            </td>
                        </tr>
                ";
                //
                $content_update = add_update_bonusperte(htmlspecialchars($_SERVER['PHP_SELF']), '', $array['idProduit'], $array['QuantiteGagne'], $array['QuantitePerdu'], $array['DatesD'], $array['Motif'], 'update', $array['idBonusPerte']);
                echo true ? modal("delete_".$array['idBonusPerte']."", "Supprimer le bonus ou perte ".$array['idBonusPerte']."", "Voulez-vous vraiment supprimer le bons ou perte du ".$array['DatesD']." qui a l ID : ".$array['idBonusPerte']."", htmlspecialchars($_SERVER["PHP_SELF"]), 'delete', "delete_".$array['idBonusPerte']."", 'supprimer') : '';
                echo true ? modal("update_".$array['idBonusPerte']."", 'Modifier le bonus ou perte', $content_update, htmlspecialchars($_SERVER["PHP_SELF"]), 'update', "update_".$array['idBonusPerte']."", 'modifier', '', false) : '' ;
                echo true ? modal("picture_".$array['idBonusPerte']."", 'Voir la photo du produit', $see_image_dossier, htmlspecialchars($_SERVER["PHP_SELF"]), 'update', "picture_".$array['idProduit']."", 'modifier', '', false) : '' ;
                echo $line;
            }
            $content_add = add_update_bonusperte(htmlspecialchars($_SERVER['PHP_SELF']), '');
            echo true ? modal("add", 'Ajouter un cliernt', $content_add, htmlspecialchars($_SERVER["PHP_SELF"]), 'add', "Add", 'Ajouter', '', false) : '' ;
        ?>
        
    </tbody>
</table>
</div>
<!-- Button trigger modal -->


<?php
    
?>
</main>
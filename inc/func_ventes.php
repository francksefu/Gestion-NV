<?php
function add_update_ventes($url, $flash = '', $idClient = '', $array_of_selected_products = [], $DatesVente = null, $idPersonnel = '', $MontantPaye = '', $reste = '', $total = '', $addorupdate = 'add', $operation = '') 
{
    global $array_of_products, $change;
    $allProduct = json_encode($array_of_products);
    $optionClient = selectOptionForClient($idClient);
    $optionProduit = selectOptionForProduct();
    $line_of_selected_products = '';
    $date = $DatesVente ?? date('Y-m-d');
    
    if(! empty($array_of_selected_products)) {
        $arr_p_q = $array_of_selected_products;
        foreach($arr_p_q as $product_quantity) {
            foreach($array_of_products as $product) {
                if($product_quantity['idProduit'] == $product['idProduit']) {
                    $line_of_selected_products .= "<tr class='line_show'><td>".$product_quantity['ImageLink']."</td><td>".$product['Nom']."</td><td>" .$product_quantity['QuantiteVendu']. "</td><td>" .$product_quantity['PU']. "</td><td>" .$product_quantity['PT']. "</td><td> <a href='#' class='btn btn-danger supprime'> Supprimer </a> </td></tr>";
                    break;
                }
            }
        }
    }
    
    $content = "
$flash
<div class='container bg-transparent pt-5'>
<h1 class='p-2'>Ajouter ventes</h1>
<hr class='w-auto'>
<form action='$url' method='POST'>
<div class='row border border-1 mt-3 pt-3 w-75 d-block mx-auto'>
        <div class='input-group mb-3' >
            <div class='input-group mb-3' id='ancien-client'>
                <span class='input-group-text' id='basic-addon1'>Nom*</span>
                    <select name='idClient' class='js-example-basic-single form-select form-select-lg'>
                        $optionClient
                    </select>
            </div>
            <small id='clientVide'></small>
        </div>
        
    </div>
        
    <div class='input-group mb-3 pt-5 pb-4' id='ajoutons'>
        <a id='remove' href='#' class='text-decoration-none'><span class='input-group-text bg-danger text-white'>&cross;</span></a>
        <span class='input-group-text border border-primary'>Nom</span>
            <select id='idProduit' name='idProduit' class='js-example-basic-single form-select form-select-lg'>
                $optionProduit
            </select>

        <span class='input-group-text border border-success'>Quantite</span>
        <input id='quantite' type='number' step='0.0001' class='form-control border border-success' placeholder='Quantite' aria-label='Server'>
        <span class='input-group-text'>PV Unitaire</span>
        <input id='pvu' type='number' step='0.0001' class='form-control' placeholder='prix de vente' aria-label='Server'>
        <span class='input-group-text'>$</span>
        <a id='add' href='#' class='text-decoration-none'><span class='input-group-text bg-success text-white'>&plus;</span></a>
        
    </div>
     <small id='error'></small>
    <small id='produitVide'></small>
    <small id='quantiteVide'></small>
    <small id='pvuVide'></small>
    <small id='quantiteGrand'></small>
    <p id='txtHint1'></p>
    <table class='table border border-1'>
        <thead class='bg-transparent text-secondary'>
          <tr>
            <th>Nom du produit</th>
            <th>Quantite vendu</th>
            <th>Prix de vente unitaire</th>
            <th>Prix de vente total</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id='long-list-of-selected-products'>
                                  
        </tbody>
    </table>

    <div class='row'>
        <div class='border border-1 p-4 col-md-4 m-2'>
        <div class='input-group mb-3 '>
            <span class='input-group-text'>Nom du vendeur</span>
            <input type='text' readonly id='personnel' class='form-control' value='1'>
            <datalist id='dataPersonnel_'>
            
          </datalist>
          <small id='personnelVide'></small>
        </div>

            <div class='input-group mb-3'>
                <label class='input-group-text' for='inputGroupSelect01'>Choisir stock</label>
                <select class='form-select' id='inputGroupSelect01'>
                  <option selected value='1'>Stock 1</option>
                </select>
            </div>
            <div class='input-group mb-3'>
                <span class='input-group-text' id='basic-addon1'>Date*</span>
                <input required type='date'  name='dates' id='date-vente' class='form-control w-50' placeholder='mettre la date' aria-label='Username' aria-describedby='nom' value='$date'>
            </div>
            
            <small>1 commande en cours ...</small>
        </div>

            <div class='border border-1 m-2 col-md-4'>
                <h4>Status</h4>
                <div class='input-group mb-3'>
                    <label class='input-group-text' for='status'>status</label>
                    <select class='form-select' id='status'>
                      <option selected>en attente</option>
                      <option value='paid'>paye</option>
                      <option value='dette'>dette</option>
                    </select>
                    <button id='envoi' type='button' class='btn btn-primary'>Valider</button>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text'>Montant</span>
                    <input type='number' step='0.0001' name='MontantPaye' value='$MontantPaye' id='montant'  class='form-control' aria-label='Amount (to the nearest dollar)'>
                    <span class='input-group-text'>$</span>
                </div>
                <small id='montantVide'></small>
                <div class='input-group mb-3 '>
                    <span class='input-group-text'>Reste</span>
                    <input readonly type='number' step='0.00001' id='reste' class='form-control'  aria-label='Amount (to the nearest dollar)'>
                    <span class='input-group-text'>$</span>
                </div>
            </div>
            <div class='border border-1 col-md-3 m-2 bg-warning moinClaire'>
                <h4 class='text-secondary'>Calcul du total</h4>
                <div class='input-group mb-3'>
                    <input type='float' id='total' readonly class='form-control' placeholder='0.00' aria-label='Recipient's username' aria-describedby='basic-addon0'>
                    <span class='input-group-text' id='basic-addon0'>$</span>
                </div>
                <div class='input-group mb-3'>
                    <input type='float' id='cdf' readonly class='form-control' placeholder='0.00' aria-label='Recipient's username' aria-describedby='basic-addon1'>
                    <span class='input-group-text' id='basic-addon'>Fc</span>
                </div>
                <div class='input-group mb-3'>
                    <input type='float' id='chilling' readonly class='form-control' placeholder='0.00' aria-label='Recipient's username' aria-describedby='basic-addon2'>
                    <span class='input-group-text' id='basic-addon2'>chilling</span>
                </div>
                <div class='input-group mb-3'>
                    <input type='float' id='rwandais' readonly class='form-control' placeholder='0.00' aria-label='Recipient's username' aria-describedby='basic-addon2'>
                    <span class='input-group-text' id='basic-addon2'>RWD</span>
                </div>

            </div>
           
     
    </div>
<!-- just using to make difference between add, remove, and update -->
    <input type='hidden' id='state' >
    <input type='hidden' id='i' value=''>
    <input type='hidden' id='operation'/>
    <input type='hidden' id='object_of_change' value='".json_encode($change)."'>
    <input type='hidden' id='array_of_selected_products' value='".json_encode($array_of_selected_products)."'>
    <input type='hidden' id='allProduct' value='$allProduct'>
    <input type='hidden' name='addorupdate' value='$addorupdate'>
    <input type='hidden' name='operation' value='$operation'>
    <input type='hidden' id='stock' value='stock1' />
</form>
</div>

<form class='input-group col-md-10 mt-3 mb-3' action='imprimer.php' method='POST'>
<span class='input-group-text'>choisissez une facture : </span>
<input required type='text' id='imprimer' name='Facture' list='dataBesoin' class='form-control' placeholder='metez quelque chose dont vous vous rappeler pour l imprimer' >
    <datalist id='dataBesoin'>
        <?php 
            dataVente();
        ?>
    </datalist>
<span class='input-group-text pointe' id='cross'>&cross;</span>
<span class='input-group-text pointe' id='btn'>
<input type='submit' value='Imprimer' />  
</span>
</form>";

return $content;
}
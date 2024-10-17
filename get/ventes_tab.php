<?php flash('client'); ?>
<main class="container-fluid">
    <h2 class="text-secondary m-2 text-center">Ventes</h2>
    <div class="row">
        <div class="col-md-7"></div>
        <div class="col-md-4"><small>total : <?php echo $total ?> </small></div>
    </div>
    <?php echo recherche_dans_tableau(); ?>
    <div class="row">
        <div class="col-md-8">
            
        </div>
        <button type='button' class='btn btn-primary col-md-3 p-2 m-2' data-bs-toggle='modal' data-bs-target='#add'>
            Ajouter vente         
        </button>
    </div>
    
<div class='horizontal'>
<table class="table table-bordered">
    <thead>
        <tr>
        <th scope="col">Operation</th>
        <th scope="col">Dates</th>
        <th scope="col">Client</th>
        <th scope="col">Total</th>
        <th scope="col">Payé</th>
        <th scope="col">Status</th>
        <th scope="col">Reste</th>
        
        <th scope="col">action</th>
        </tr>
    </thead>
    <tbody id='tbody'>
        <?php
            //$auth = (isset($_SESSION['post']) && $_SESSION['post'] !=='directeur');
            foreach($default_array as $array) {
                

                $suppression = "
                <button type='button' class='btn btn-danger col-md-5 m-1' data-bs-toggle='modal' data-bs-target='#voir_".$array['Operation']."'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                        <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                        <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                    </svg>
                </button>
                <button type='button' class='btn btn-danger col-md-5 m-1' data-bs-toggle='modal' data-bs-target='#delete_".$array['Operation']."'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                            <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                          </svg>
                                </button>

                                <button type='button' class='btn btn-primary col-md-5 m-1' data-bs-toggle='modal' data-bs-target='#update_".$array['Operation']."'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-pen' viewBox='0 0 16 16'>
                            <path d='m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z'/>
                        </svg>
                                </button>";

                
                $line = "
                        <tr>
                            <th>".$array['Operation']."</th>
                            <td>".$array['DatesVente']."</td>
                            <td>Client</td>
                            <td>".$array['TotalFacture']."</td>
                            <td>".$array['MontantPaye']."</td>
                            <td>Status</td>
                            <td>".$array['Reste']."</td>
                            <td class='row'>
                            
                                $suppression
                                
                            </td>
                        </tr>
                ";
                //
                $content_update = add_update_client(htmlspecialchars($_SERVER['PHP_SELF']), '', $array['NomClient'], $array['Telephone'], 'update', $array['idClient']);
                echo true ? modal("delete_".$array['idClient']."", "Supprimer le client ".$array['NomClient']."", "Voulez-vous vraiment supprimer le client ".$array['NomClient']." qui a l ID : ".$array['idClient']."", htmlspecialchars($_SERVER["PHP_SELF"]), 'delete', "delete_".$array['idClient']."", 'supprimer') : '';
                echo true ? modal("update_".$array['idClient']."", 'Modifier le client', $content_update, htmlspecialchars($_SERVER["PHP_SELF"]), 'update', "update_".$array['idClient']."", 'modifier', '', false) : '' ;
                echo $line;
            }
            $content_add = add_update_client(htmlspecialchars($_SERVER['PHP_SELF']), '');
            echo true ? modal("add", 'Ajouter un cliernt', $content_add, htmlspecialchars($_SERVER["PHP_SELF"]), 'add', "Add", 'Ajouter', '', false) : '' ;
        ?>
        
    </tbody>
</table>
</div>
<!-- Button trigger modal -->


<?php
    
?>
</main>
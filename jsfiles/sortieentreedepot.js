function isValidNumber(input) {
    let pattern = /^[0-9.]+$/;
    return pattern.test(input);
}
$(document).ready(function(){
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    
    $('#button').on('click', function() {
        if ($('#contenu_produit').val() !== '' && $('#quantite').val() !== '') {
            let tab = JSON.parse($('#contenu_produit').val());
            let line = "<tr class='line_show'><td>"+tab['id']+"</td><td>"+tab['nom']+"</td><td>" + $('#quantite').val() + ' ' +tab['unite_mesure']+ "</td><td> <a href='#' class='btn btn-danger supprime'> Supprimer </a> </td></tr>";
            $('#tbody').append(line);
            let array_product_quantity_to_insert = {idProduit: tab['id'], quantite: $('#quantite').val()}
            let arr = [];
            if($('#array_of_product_and_quantity').val() === '') {
                arr = [];
            } else {
                arr = JSON.parse($('#array_of_product_and_quantity').val());
            }
            arr.push(array_product_quantity_to_insert);
            $('#array_of_product_and_quantity').val(JSON.stringify(arr));
            
            $('#myInput').val('');
            $('#contenu_produit').val('');
            $('#quantite').val('');
            $('#unite_de_mesure').text('');
        }
    });
    
    $('#quantite').on('blur', function() {
        let text = $('#quantite').val();
        
        if(! isValidNumber(text)) {
            $(this).addClass('border border-danger');
            $('#button').hide();
            $('#info-quantity').text('Dans le champs de quantite vous ne pouvez mettre que les chiffres, corrigez, ensuite cliquez a l exterieur du champ et le button reapparaitra');
        } else {
            $(this).removeClass('border border-danger');
            $('#button').show();
            $('#info-quantity').text('');
        }
    });
    $('#generale-table').on('mouseover', function() {
        const arrnew = JSON.parse($('#array_of_product_and_quantity').val());
        $('.supprime').each(function(index) {
            $(this).on('click',function() {
                arrnew.splice(index, 1);
                $(this).parents('tr').remove();
                $('#array_of_product_and_quantity').val(JSON.stringify(arrnew));
            });
        });
    });
    

  });

  $(document).ready(function() {
    var age = 'i';
    $('#age_number').on('change', function() {
         age = $('#age_precis').val() +' '+ $(this).val() +' '+ $('#age_time').val();
        $('#age').val(age);
    });

    $('#age_time').on('change', function() {
         age = $('#age_precis').val() +' '+ $('#age_number').val() +' '+ $(this).val();
        $('#age').val(age);
    });

    $('#age_precis').on('change', function() {
         age = $(this).val() +' '+ $('#age_number').val() +' '+ $('#age_time').val();
        $('#age').val(age);
    });
  })

  $(document).ready(function() {
    $('#ajouter_album').on('click', function() {
        $('.type').val('album');
    });

    $('#ajouter_dossier').on('click', function() {
        $('.type').val('dossier');
    })
  });

  $(document).ready(function(){
    $("#recherche").on("keyup", function() {
      var valu = $(this).val().toLowerCase();
      $("#tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(valu) > -1)
      });
    });
  });
  
  function put(id, date1ou2) {
    $(id).on('click', function() {
        $('#request').val($(this).attr('id'));
        if(date1ou2 == 'une') {
            $('.date1').show();
            $('.date2').hide();
            $('.type_trie').hide();
        } else if(date1ou2 == 'uneetdemi') {
            $('.date1').show();
            $('.date2').hide();
            $('.type_trie').show();
        } else if( date1ou2 == 'deux') {
            $('.date1').show();
            $('.date2').show();
            $('.type_trie').hide();
        } else {
            $('.date1').show();
            $('.date2').show();
            $('.type_trie').hide();
        }
    });
  }
  $(document).ready(function() {
    put('#entree_comptabilite', 'une');
    put('#sortie_comptabilite', 'une');
    put('#entree_comptabilite_trie', 'uneetdemi');
    put('#sortie_comptabilite_trie', 'uneetdemi');
    put('#entree_depot', 'une');
    put('#sortie_depot', 'une');
    put('#entree_inventaire', 'une');
    put('#sortie_inventaire', 'une');
    put('#tous_inventaire', 'une');

    put('#entree_comptabilite2', 'deux');
    put('#sortie_comptabilite2', 'deux');
    put('#entree_comptabilite_trie2', 'deuxetdemi');
    put('#sortie_comptabilite_trie2', 'deuxetdemi');
    put('#entree_depot2', 'deux');
    put('#entree_depot2', 'deux');
    put('#entree_inventaire2', 'deux');
    put('#sortie_inventaire2', 'deux');
    put('#tous_inventaire2', 'deux');
    put('#enfant2', 'deux');
  });
// uniquement les chiffres pas encore ajustE
  $(document).ready(function() {
    
    $('#submit').on('click', function(e) {
        
        let text = $('.number').val();
        if(! isValidNumber(text)) {
            e.preventDefault();
            $('.number-text').text('le champ ci haut ne doit contenir que des chiffres, corriger le d abord avant d evoluer');
        }
      });
  })


  

$(document).ready(function() {
    $('.js-example-basic-single').select2();

});
function findProduct(idProduit) {
    let allProduct = $('#allProduct').val();
    allProduct = JSON.parse(allProduct);

    for(let product of allProduct) {
        if(product['idProduit'] != idProduit) {
            continue;
        } else {
            return product;
        }
    }
}

function isItAnEmptyString(element, message) {
    if(element.val() == '') {
        throw new Error(message);
    }
    return '';
}
$(document).ready(function() {
    let array_of_selected_products = $('#array_of_selected_products').val();
    array_of_selected_products = JSON.parse(array_of_selected_products);
    let inputIdProduit = $('#idProduit');
    let inputQuantite = $('#quantite');
    let inputPrixVenteU = $('#pvu');
    $('#add').on('click', function() {
        
        try {
            isItAnEmptyString(inputIdProduit, 'Le produit ne doit pas etre vide <br>');
            isItAnEmptyString(inputQuantite, 'Veuillez completer la quantite svp <br>');
            isItAnEmptyString(inputPrixVenteU, 'Veuillez completer le prix de vente svp <br>');
            if (! isValidNumber(inputQuantite.val())) {
                throw new Error('La quantite doit etre des chiffres uniquement, pas des lettres svp <br>');
            }

            if (! isValidNumber(inputPrixVenteU.val())) {
                throw new Error('Le prix de vente unitaire doit etre des chiffres uniquement, pas des lettres svp <br>');
            }
            let produit = findProduct(inputIdProduit.val());
            if ($(inputQuantite).val() > produit['QuantiteStock']) {
                throw new Error('La quantite que vous entrez est le superieur a la quantite en stock');
            }
            if ($(inputPrixVenteU).val() < produit['PrixVmin']) {
                throw new Error('Vous voulez vendre ce produit a un tres bas prix, veuillez verifier le prix de vente minimum de ce produit dans le menu produit svp. merci<br>');
            }
            let image = (produit['ImageLink']) && (produit['ImageLink'].includes('.')) ? produit['ImageLink'] : 'banane.png';
            let line_product = `
                <div class='d-flex flex-row' id='taille'>
                    <img src ='upload_files/${image}' class=' photo m-0' width='70px' height='70px' alt='produit'>
                    <div class='ps-2 m-0'>
                        <h4 class='text-end'>"${produit['Nom']}"</h4>
                        <small class='text-secondary'>"${produit['DescriptionP']}"</small><br>
                        <button type='button' class='btn btn-success m-1' data-bs-toggle='modal' data-bs-target='#picture_".$array['idBonusPerte']."'> Voir photo</button>
                    </div>
                </div>
            `;
            let line = "<tr class='line_show'><td>"+line_product+"</td><td>" + $('#quantite').val() + "</td><td>" + $('#pvu').val() + "</td><td>" + ($('#quantite').val() * 1) * ($('#pvu').val()*1) + "</td><td> <a href='#' class='btn btn-danger supprime'> Supprimer </a> </td></tr>";
            $('#long-list-of-selected-products').append(line);
            array_of_selected_products.push({produit: produit, QuantiteVendu: $('#quantite').val(), PU: $('#pvu').val(), PT: function(){return this.QuantiteVendu * this.PU}});
            $('#array_of_selected_products').val(JSON.stringify(array_of_selected_products));
            
            $(inputIdProduit).val('0');
            $(inputQuantite).val('');
            $(inputPrixVenteU).val('');
            $('#error').html('');
            $('#error').attr('class', '');
        } catch(error) {
            $('#error').html(error.message);
            $('#error').addClass('alert alert-danger');
        } finally {
            if (array_of_selected_products) {
                let total = 0;
                for(let selected_produit of array_of_selected_products) {
                    total += selected_produit['PT']();
                }
                $('#total').val(total);
            }
        }
        
    });
    $(inputIdProduit).on('change', function(){
        $(inputPrixVenteU).val(findProduct(inputIdProduit.val())['PrixVente']);
    });
});





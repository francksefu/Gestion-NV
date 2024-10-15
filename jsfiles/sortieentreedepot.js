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
    $('#myInput').on('focus', function() {
        $('#all-table-product').show();
        
        $('.line_to_take').on('click', function() {
            var unite = $(this).children('.unite_de_mesure').text();
            var content = $(this).children('.nom').text();
            var contenu_produit = {id: $(this).children('.id').text(), nom: $(this).children('.nom').text(), quantite: $(this).children('.quantiteStock').text(), unite_mesure: $(this).children('.unite_de_mesure').text()};
            $('#contenu_produit').val(JSON.stringify(contenu_produit));
            $('#unite_de_mesure').text(unite);
            $('#myInput').val(content);
            $('#all-table-product').hide();
        })
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
    //$('.js-example-basic-single').select2();
    // JavaScript
    $(function () {
        $('#country').select2({
            dropdownParent: $('.myModal')
        });
    });

});





/*!
* Start Bootstrap - SB Admin 2 v3.3.7+1 (http://startbootstrap.com/template-overviews/sb-admin-2)
* Copyright 2013-2016 Start Bootstrap
* Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
*/
$(function() {
  $('#side-menu').metisMenu();

  //Loads the correct sidebar on window load,
  //collapses the sidebar on window resize.
  // Sets the min-height of #page-wrapper to window size

  $(window).bind("load resize", function() {
    var topOffset = 50;
    var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
    if (width < 768) {
      $('div.navbar-collapse').addClass('collapse');
      topOffset = 100; // 2-row-menu
    } else {
      $('div.navbar-collapse').removeClass('collapse');
    }

    var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
    height = height - topOffset;
    if (height < 1) height = 1;
    if (height > topOffset) {
      $("#page-wrapper").css("min-height", (height) + "px");
    }
  });

  var url = window.location;
  var element = $('ul.nav a').filter(function() {
    return this.href == url;
  }).addClass('active').parent();

  while (true) {
    if (element.is('li')) {
      element = element.parent().addClass('in').parent();
    } else {
      break;
    }
  }


  // Déclenchement des popover pour les boutons avec droit d'admin
  $('[data-toggle="popover"]').popover({ trigger: "hover" });

  // Déclenchement des tooltips dans page annonces.php
  $('[data-toggle="tooltip"]').tooltip();

  // Récupération de la valeur de la note attribuée
  $('.rating a').on('click', function() {
    var valeur = $(this).attr('value');
    $('.rating input').val(valeur);
  });


  $('#triSelect').val([name = "triSelect"]).change( function(event) {
    event.preventDefault();

    // console.log('ça marche !');

    $.ajax({

      url: 'include/select-tri.php?triSelect=',
      method: 'GET',
      data: $("#triSelect option:selected").val().toLowerCase(),
      // $(this).serialize(),
      // {tri_annonces: },
      dataType: 'json',
      success: function(annonces, success) {
        console.log('Connexion : '+success);
        console.log('retour réussi !');
        // console.log(annonces);

      }
    });
  });


  // Mise à jour de la disponibilité de l'annonce par AJAX sur page annonce-fiche.php -------------------

  $('input[name="dispo"]').on('click', function (event) {

    event.preventDefault();

    var active = $('input[name="dispo"]:checked').val();
    var annonce_id = $(this).attr('class');
    console.log(active);
    console.log(annonce_id);

    $.post(
      'dist/xhr/disponibilite.php',
      {
        dispo : active,
        idAnnonce: annonce_id
      },
      function (reponse) {
        console.log(reponse);

        $('#dispoMAJ').append(reponse);

      },
      'text'
    );
  });


  // Réponse au commentaire dans la page profil.php -------------------

  var bouton = document.querySelectorAll('.boutonComment');
  for (i=0; i<bouton.length; i++) {
    bouton[i].onclick = function () {
      var idAnnonce = this.getAttribute('value');
      var idMembre = this.getAttribute('data-idMembre');
      var idVendeur = this.getAttribute('data-idVendeur');
      console.log(idAnnonce);
      console.log(idMembre);
      console.log(idVendeur);

      $('#commentSubmit').click( function (event) {

        var textarea = $('#commentaire').val();
        var note = $('input[name="note"]:checked').val();
        var avis = $('#avis').val();
        console.log(textarea);
        console.log(note);
        console.log(avis);

        event.preventDefault();
        $.post(
          'dist/xhr/commentaireNoteAvis.php',
          // 'dist/xhr/commentaireReponse.php',
          {
            idAnnonce: idAnnonce,
            idMembre: idMembre,
            idVendeur: idVendeur,
            commentaire : textarea,
            note: note,
            avis: avis
          },
          function (reponse) {
            console.log(reponse);
            $('button[class="close"]').trigger('click');
            $('#dispoMAJ').html(reponse);
            $('#commentaire').val('');
          },
          'html'
        );
      });
    }
  }




  // Tri de la liste des annnonces dans la page annonces.php ----------------------------------------------

  // $('select[name="triSelect"]').on('change', function (event) {
  //
  //   event.preventDefault();
  //
  //   // var choix = $(this).val('option selected');
  //   var choix = $("#triSelect option:selected").val();
  //   console.log(choix);
  //
  //   $.post (
  //     '../dist/xhr/triSelect.php',
  //     {
  //       triSelect : choix
  //     },
  //     function (reponse, success) {
  //       console.log(reponse);
  //       console.log(success);
  //
  //       },
  //       'json'
  //     );
  //   });


    // Autocompletion dans la zone de recherche de la navbar --------------------------
    // function evenement(event) {
    //   $('#zone-de-chargement').html('');
    //
    //   if ($('#q').val().trim() !== '') {
    //
    //     console.log('Soumission du formulaire');
    //     event.preventDefault();
    //
    //     jQuery.ajax({
    //       url: 'xhr/langages.php', // L'URL du fichier texte.
    //       method: 'GET', // La méthode est du GET.
    //       data: {
    //         q: $('#q').val()
    //       }, // Pas de données à envoyer.
    //       dataType: 'json', // Le type de données attendu.
    //       success: function(donnees) {
    //         // Fonction exécutée en cas de succés.
    //         // Deboggage des données reçues dans la console.
    //
    //         if (donnees.length) {
    //
    //           // var suggestions = '<ul>';
    //           // for (var i = 0; data[i]; i++) {
    //           //   suggestions += '<li>' + data[i] + '</li>';
    //           // }
    //           // suggestions += '</ul>';
    //           // $('#suggestions').html(suggestions);
    //
    //           var liste = $('#zone-de-chargement').append('<ul>');
    //           for (var i = 0; i < donnees.length; i++) {
    //             liste = liste.append('<li>' + donnees[i] + '</li>');
    //           }
    //           liste += '</ul>';
    //           console.log(liste);
    //         }  else {
    //           $('#zone-de-chargement').html('<p><em>Aucun résultat<em></p>');
    //         }
    //       },
    //       error : function (error) {
    //         console.log(error);
    //       }
    //     });
    //   }
    // }
    //
    // jQuery('form').on('keyup', function (event) {
    //   evenement(event);
    // });



    // Table des annonces responsive dans annonces.php
    // $('#tableAnnonces').DataTable({
    //   responsive: true
    // });



  });  //end DOM Ready

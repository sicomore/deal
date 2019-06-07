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

  // Pagination page d'accueil ------------------------
  var liste = $('body .pagination.liste_annonces');
  liste.find('li.disabled').on('click', function(e) {
    e.preventDefault();
    // var pageChoisie = $(this).html();
    // console.log(pageChoisie);
  });


  // Déclenchement des popover pour les boutons avec droit d'admin
  $('[data-toggle="popover"]').popover({ trigger: "hover" });

  // Déclenchement des tooltips dans page annonces.php
  $('[data-toggle="tooltip"]').tooltip();

  // Récupération de la valeur de la note attribuée
  $('.rating a').on('click', function() {
    var valeur = $(this).attr('value');
    $('.rating input').val(valeur);
  });

  // $('.selection-select').click( function(e) {
  //   switch (this) {
  //     case 'categories':
  //
  //       break;
  //     default:
  //
  //   }
  //   console.log(e.target.value);
  // });


  // $('#triSelect').val([name = "triSelect"]).change( function(event) {
  //   event.preventDefault();
  //
  //   // console.log('ça marche !');
  //
  //   $.ajax({
  //
  //     url: 'include/select-tri.php?triSelect=',
  //     method: 'GET',
  //     data: $("#triSelect option:selected").val().toLowerCase(),
  //     // $(this).serialize(),
  //     // {tri_annonces: },
  //     dataType: 'json',
  //     success: function(annonces, success) {
  //       console.log('Connexion : '+success);
  //       console.log('retour réussi !');
  //       // console.log(annonces);
  //
  //     }
  //   });
  // });


  // ---------------------------------------------------------------
  // Mise à jour de la disponibilité de l'annonce par AJAX sur page annonce-fiche.php -------------------

  $('input[name="dispo"]').each( function () {
    var valeur = $(this).val();
    console.log(valeur);

    $(this).on('click', function (event) {

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

  });

  // --------------------------------------------------------------------
  // Réponse au commentaire dans la page profil.php et annonce-fiche.php
  // --------------------------------------------------------------------

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
    };
  }

  // --------------------------------------------------------------------
  // Envoi de mail au propriétaire de l'annonce dans annonce-fiche.php
  // --------------------------------------------------------------------

  $('#messageSubmit').click( function (event) {

    var message = $('#message').val();
    var idClient = $('input[name="idClient"]').val();
    var idVendeur = $('input[name="idVendeur"]').val();
    var idAnnonce = $('input[name="idAnnonce"]').val();
    console.log(message);
    console.log(idClient);
    console.log(idAnnonce);
    console.log(idVendeur);

    event.preventDefault();
    $.post(
      'dist/xhr/commentaireNoteAvis.php',
      {
        message: message,
        idClient: idClient,
        idVendeur: idVendeur,
        idAnnonce: idAnnonce
      },
      function (reponse) {
        console.log(reponse);
        $('button[class="close"]').trigger('click');
        $('#dispoMAJ').html(reponse);
        $('#message').val('');
      },
      'html'
    );
  });

  // Autocompletion dans la zone de recherche de la navbar --------------------------
  //
  // $('#input-recherche').on('keyup', function (event) {
  //
  //   var zone = $('#input-recherche').val().trim();
  //
  //   if (zone !== '') {
  //     console.log(zone);
  //
  //     event.preventDefault();
  //
  //
  //     $.post(
  //       'dist/xhr/recherche.php',
  //       {
  //         mot: zone
  //       },
  //       function (reponse) {
  //         console.log(reponse);
  //       },
  //       'html'
  //     );
  //   }
  // });


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





  // Table des annonces responsive dans annonces.php
  // $('#tableAnnonces').DataTable({
  //   responsive: true
  // });



});  //end DOM Ready

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



  // Table des annonces responsive dans annonces.php
  // $('#tableAnnonces').DataTable({
  //   responsive: true
  // });


  // Tri des annonces
  // function affichage(choix) {
  //   if (choix !='') {
  //     // console.log(choix);
  //     for (var i = 0; i < select.length; i++) {
  //       var titre = select.eq(i).attr('title');
  //       var toutesFiches = select.eq(i);
  //       if (titre != choix) {
  //         if (choix == 'default') {
  //           toutesFiches.fadeIn(500);
  //         } else {
  //           toutesFiches.hide(1000);
  //         }
  //       } else {
  //         toutesFiches.fadeIn(500);
  //       }
  //     }
  //   }
  // }

});  //end DOM Ready

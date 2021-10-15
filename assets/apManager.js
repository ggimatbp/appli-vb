

// On import les notifications

import { vNotify } from './app';

   $(document).ready(function () {
      vNotify();
    })

   
import $ from 'jquery';

import 'bootstrap/js/dist/dropdown'

//// logique de filtre pour les employées //////

$("#btn-employee-search-filter").unbind("click").click(function(e){
    e.preventDefault();
    let ajaxActive = $('#filter-user-active-select').val();
    let ajaxRoleId = $('#filter-user-role-select').val();
    let ajaxEmail = $('#filter-user-email-input').val();
    let ajaxFirstname = $('#filter-user-firstname-input').val();
    let ajaxLastname = $('#filter-user-lastname-input').val();
    let ajaxId = $('#filter-user-id-input').val();
    console.log(ajaxEmail);
   $.ajax({
      url:'/manager/' + '?&ajax=1',
      type: "GET",
      dataType: "json",
      data: {
         "ajaxActive": ajaxActive,
         "ajaxRoleId": ajaxRoleId,
         "ajaxEmail": ajaxEmail,
         "ajaxFirstname": ajaxFirstname,
         "ajaxLastname": ajaxLastname,
         "ajaxId": ajaxId,
      },
      async: true,
      success: function (response)
      {
        $("#content-filtered").empty();
        $("#content-filtered").append(response.content);
        vNotify().success({ text: 'Vos préférences ont bien été prises en compte.', title: 'Filtre' });
      },
      error: function ()
      {
        vNotify().error({ text: 'Erreur lors du traitement des filtres', title: 'Erreur filtre' });
      }
  });
})

//// logique pour effacer les filtres //////

$("#btn-employee-erease-filter").unbind("click").click(function(e){
  e.preventDefault();
  console.log(123);
   $('.employee-filter').each((function() {
    console.log($(this).val());
    $(this).val("")
   }))
})
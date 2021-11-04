

// On import les notifications

import { vNotify } from './app';

   $(document).ready(function () {
      vNotify();
    })

   
import $ from 'jquery';

import 'bootstrap/js/dist/dropdown'


//// logique ajax pour les employées (pagination et filtre) //////

function ajaxFilter(element, ajaxOrder = null, ajaxFilterNameOrder = null){

  let ajaxActive = $('#filter-user-active-select').val();
  let ajaxRoleId = $('#filter-user-role-select').val();
  let ajaxEmail = $('#filter-user-email-input').val();
  let ajaxFirstname = $('#filter-user-firstname-input').val();
  let ajaxLastname = $('#filter-user-lastname-input').val();
  let ajaxId = $('#filter-user-id-input').val();
  let ajaxLimit = $('#employeeSelectLimitLine').val();
  let ajaxPage = element;

  let ajaxRoleName = $('#filter-user-role-select option:selected').text();

   if(ajaxOrder == null)
    {
      ajaxOrder = $("#hidden-input-order-and-name").data('ajaxorder');
    }

    if(ajaxFilterNameOrder == null)
    {
      ajaxFilterNameOrder = $("#hidden-input-order-and-name").data('ajaxfilternameorder');
    }

   $.ajax({
      url:'/manager/' + '?&ajax=1',
      type: "GET",
      dataType: "json",
      data: {
         "ajaxActive": ajaxActive,
         "ajaxRoleId": ajaxRoleId,
         "ajaxRoleName":ajaxRoleName,
         "ajaxEmail": ajaxEmail,
         "ajaxFirstname": ajaxFirstname,
         "ajaxLastname": ajaxLastname,
         "ajaxId": ajaxId,
         "ajaxLimit": ajaxLimit,
         "ajaxPage": ajaxPage,
         "ajaxOrder": ajaxOrder,
         "ajaxFilterNameOrder": ajaxFilterNameOrder,

      },
      async: true,
      
      success: function (response)
      {
        $("#content-filtered").empty();
        $("#content-filtered").append(response.content);
        $("#pagination_filtered").empty();
        $("#pagination_filtered").append(response.content2)
        paginationOnclick()
        paginationOnSubmit()
        employeeLimitModification()
      },
      error: function ()
      {
        vNotify().error({ text: 'Erreur lors du traitement des filtres', title: 'Erreur filtre' });
      }
  });
}


//// logique de filtre pour les employées //////


$("#btn-employee-search-filter").unbind("click").click(function(e){
    e.preventDefault();
    ajaxFilter($('#hidden-val-page').val());
})

//// logique pour effacer les filtres //////

$("#btn-employee-erease-filter").unbind("click").click(function(e){
  e.preventDefault();
   $('.employee-filter').each((function() {
    $(this).val("")
    $("#hidden-input-order-and-name").data('ajaxorder', '');
    $("#hidden-input-order-and-name").data('ajaxfilternameorder', '');
   }))
   $("#employee-tr-order th button").each(function(){
    $(this).removeClass("btn-orderby-highlighted")
  })
})

//// logique pour changer de page /////

paginationOnclick()

function paginationOnclick()
{
  $("#paginator-select-id li button" ).each(function() {
    $(this).unbind("click").click(function(e){
      ajaxFilter($(this).data("page"))
  });
})
}


// Logique de changement de page dans la barre de recherche//

 paginationOnSubmit()

function paginationOnSubmit()
{
  $('#pageNumber-input-search').on('keypress',function(e) {
    if(e.which == 13) {
      ajaxFilter($(this).val())
  }})
}

// order ASC DESC //

$("#employee-tr-order th button").each(function() {
  
  $(this).unbind("click").click(function(e)
  {
    e.preventDefault();
    ajaxFilter($('#hidden-val-page').val(), $(this).data("order"), $(this).data("name"));
    $("#hidden-input-order-and-name").data('ajaxorder', $(this).data("order"));
    console.log($("#hidden-input-order-and-name").data('ajaxorder'))
    $("#hidden-input-order-and-name").data('ajaxfilternameorder', $(this).data("name"));
    console.log($("#hidden-input-order-and-name").data('ajaxfilternameorder'))
    $("#employee-tr-order th button").each(function(){
      $(this).removeClass("btn-orderby-highlighted")
    })
    $(this).addClass("btn-orderby-highlighted")

  })
})


// ///Logique de limite du nombre de ligne du tableau de employee /// 

employeeLimitModification()

function employeeLimitModification()
{
  $("#employeeSelectLimitLine").change(function(e){
    e.preventDefault();
      console.log($("#employeeSelectLimitLine").val() + $(this).data("page") +  $("#hidden-input-order-and-name").data('ajaxRoleOrder'))
    
      ajaxFilter($(this).data("page"))
  });
}

//logique pour mettre de la couleur au btn ASC DESC en fonction de si ils sont ou non le bouton dont les datas sont enregistré en session via un input hidden

$("#employee-tr-order th button").each(function() {

  if($("#hidden-input-order-and-name").data('ajaxfilternameorder') == $(this).data('name'))
  {
    if($("#hidden-input-order-and-name").data('ajaxorder') == $(this).data('order'))
    {
      $(this).addClass("btn-orderby-highlighted")
    }
  }
})


//
//ROLE//
//
// logique pour les filtres des roles//
//
//

function ajaxRoleFilter(element, ajaxRoleOrder = null, ajaxRoleOrderName = null){

let ajaxFilterRoleName = $('#filter-role-lastname-input').val();
let ajaxRolePage = element;
let ajaxRoleLimit = $("#hidden-role-input-order-and-name").data('ajaxlimitrole');
if(ajaxRoleOrder == null)
  {
    ajaxRoleOrder = $("#hidden-role-input-order-and-name").data('ajaxorderrole')
  }

   $.ajax({
      url:'/manager/' + '?&ajax1=1',
      type: "GET",
      dataType: "json",
      data: {
         "ajaxFilterRoleName": ajaxFilterRoleName,
         "ajaxRoleOrder": ajaxRoleOrder,
         "ajaxRoleLimit": ajaxRoleLimit,
         "ajaxRolePage": ajaxRolePage,
         "ajaxRoleOrderName": ajaxRoleOrderName,
      },

      async: true,
      
      success: function (response)
      {
        $("#content-role-filtered").empty();
        $("#content-role-filtered").append(response.content);
        $("#pagination-role-filtered").empty();
        $("#pagination-role-filtered").append(response.content2)
        paginationRoleOnclick()
        roleLimitModification()
        paginationRoleOnSubmit()
        $("#roleSelectLimitLine").val($("#hidden-role-input-order-and-name").data('ajaxLimitRole'));
      },
      error: function ()
      {
        vNotify().error({ text: 'Erreur lors du traitement des filtres des roles', title: 'Erreur filtre' });
      }
  });
}

//// logique de filtre pour les roles //////

$("#btn-role-search-filter").unbind("click").click(function(e){
  e.preventDefault();
  ajaxRoleFilter($('#hidden-val-pageRole').val());
})

//// Logique pour effacer les filtres des roles ////

$("#btn-role-erease-filter").unbind("click").click(function(e){
  e.preventDefault();
    $('#filter-role-lastname-input').val("");
   $("#hidden-role-input-order-and-name").data('ajaxorderrole', '3');
   $("#role-tr-order th button").each(function(){
    $(this).removeClass("btn-orderby-highlighted")
  })
})

///// Logique pour les role order ////

$("#role-tr-order th button").each(function() {
  $(this).unbind("click").click(function(e)
    {
      e.preventDefault();

      //ici je dois faire passer un element (la page) et un data order role name
      ajaxRoleFilter($('#hidden-val-page').val(), $(this).data("orderrole"), $(this).data("namerole"));
      $("#hidden-role-input-order-and-name").data('ajaxorderrole', $(this).data("orderrole"));
      //le role ne serta a rien pour l'instant (dans lhypothése qu'il y aura d'autre élément)
      $("#hidden-role-input-order-and-name").data('ajaxrolefilternameorder', $(this).data("namerole"));
      $("#role-tr-order th button").each(function(){
        $(this).removeClass("btn-orderby-highlighted")
      })
      $(this).addClass("btn-orderby-highlighted")
  
    })
})
$("#hidden-role-input-order-and-name").data('ajaxorder', $(this).data("order"));
$("#hidden-role-input-order-and-name").data('ajaxfilternameorder', $(this).data("name"));

/// logique pagination pour les role on click///

paginationRoleOnclick()

function paginationRoleOnclick()
{
  $("#paginator-role-select-id li button" ).each(function() {
    $(this).unbind("click").click(function(e){
      ajaxRoleFilter($(this).data("pagerole"))
  });
})
}

/// Barre de recherche pour la pagination du role///

paginationRoleOnSubmit()

function paginationRoleOnSubmit()
{
  $('#pageRoleNumber-input-search').on('keypress',function(e) {
    if(e.which == 13) {
      ajaxRoleFilter($(this).val())
  }})
}

///Logique de limite du nombre de ligne du tableau de Role /// 

roleLimitModification()

function roleLimitModification()
{
  $("#roleSelectLimitLine").change(function(e){
    e.preventDefault();
      $("#hidden-role-input-order-and-name").data('ajaxlimitrole', $("#roleSelectLimitLine").val());
      ajaxRoleFilter($(this).data("pagerole"), $("#hidden-role-input-order-and-name").data('ajaxRoleOrder')) 
 //     console.log( $("#hidden-role-input-order-and-name").data('ajaxlimitrole'))
  });
}


//logique pour mettre de la couleur au btn ASC DESC en fonction de si ils sont ou non le bouton dont les datas sont enregistré en session via un input hidden


$("#role-tr-order th button").each(function() {
  if($("#hidden-role-input-order-and-name").data('ajaxorderrole') == $(this).data('orderrole'))
  {
    $(this).addClass("btn-orderby-highlighted")
  }
})
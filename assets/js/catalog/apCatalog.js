//#region import 

// On importe les notifications

import { vNotify } from '../app';

   $(document).ready(function () {
      vNotify();
    })


//on import le dropdown de bootstrap (technique pour que la modale ne bloque pas le système de dropdown bootstrap)

// import 'bootstrap/js/dist/dropdown';

   
import $ from 'jquery';

//#endregion import

//region batteries-prod

  //#region model search
// document.querySelector('input[list]').addEventListener('input', function(e) {

   $('#model-suggestion-choice').on('propertychange input', function(e){
   let input = e.target,
       list = input.getAttribute('list'),
       options = document.querySelectorAll('#' + list + ' option'),
       inputValue = input.value;
   for(let i = 0; i < options.length; i++) {
       let option = options[i];
       if($(option).val() === inputValue) {
         $("#answerInput-hidden").val($(option).data("value"))

           break;
       }
   }

// $('#model-suggestion-choice').onchange =   $('#btnModelValue').trigger()


});

$('#model-suggestion-choice').on('change', function(e){
  $('#btnModelValue').trigger("click")
})
  //#endregion model search

  //#region customer search

$('#customer-search-choice').on('propertychange input', function(e){
  let input = e.target,
      list = input.getAttribute('list'),
      options = document.querySelectorAll('#' + list + ' option'),
      inputValue = input.value;

  for(let i = 0; i < options.length; i++) {
      let option = options[i];

      if($(option).val() === inputValue) {
        $("#customerAnswerInput-hidden").val($(option).data("value"))
          break;
      }
  }
  // $('#btnCustomerValue').click()

  // $('#customer-search-choice').keydown(function(event){
  //   if (event.keyCode === 13) {
  //   $('#btnCustomerValue').trigger("click")
  //   }})
});

$('#customer-search-choice').on('change', function(e){
  $('#btnCustomerValue').trigger("click")
})

  //endregion customer search

  //#region folder change
$('.folder-change i').mouseenter(function(e){
  $(this).removeClass( "fa-folder fa-6x" ).addClass( "fa-folder-open  fa-6x" );
}).mouseleave( function(e){
  $(this).removeClass( "fa-folder-open fa-6x" ).addClass( "fa-folder  fa-6x" );
})
  //#endregion folder change
//#endregion batteries-Prod

//#region veloBatterie
  //#region pack search

  $('#case-search-choice').on('click input', function(e){
    let input = e.target,
        list = input.getAttribute('list'),
        options = document.querySelectorAll('#' + list + ' option'),
        inputValue = input.value;
    for(let i = 0; i < options.length; i++) {
        let option = options[i];
        if($(option).val() === inputValue) {
          $("#caseAnswerInput-hidden").val($(option).data("value"))
            break;
        }
    }
    // $('#btnPackValue').click()
    // $('#case-search-choice').on('select'(function(event){

    //   $('#btnPackValue').trigger()
    // }
    // ))
    // $('#case-search-choice').keydown(function(event){
    //   if (event.keyCode === 13 || on('click')) {
    //   $('#btnPackValue').trigger()
    //   }})
  });

  $('#case-search-choice').on('change', function(e){
    $('#btnPackValue').trigger("click")
  })

  //#endregion pack search
//#endregion velobatterie
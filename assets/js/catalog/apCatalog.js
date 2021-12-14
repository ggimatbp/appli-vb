//#region import 

// On importe les notifications

import { vNotify } from '../app';

   $(document).ready(function () {
      vNotify();
    })


//on import le dropdown de bootstrap (technique pour que la modale ne bloque pas le système de dropdown bootstrap)

import 'bootstrap/js/dist/dropdown';

   
import $ from 'jquery';

//#endregion import

//#region model search
// document.querySelector('input[list]').addEventListener('input', function(e) {
   $('#model-suggestion-choice').on('propertychange input', function(e){
   let input = e.target,
       list = input.getAttribute('list'),
       options = document.querySelectorAll('#' + list + ' option'),
       inputValue = input.value;
console.log(inputValue)
   for(let i = 0; i < options.length; i++) {
       let option = options[i];
       if($(option).val() === inputValue) {
         $("#answerInput-hidden").val($(option).data("value"))
         console.log($("#answerInput-hidden").val())
           break;
       }
   }
});
//#endregion model search

//#region customer search

$('#customer-search-choice').on('propertychange input', function(e){
  let input = e.target,
      list = input.getAttribute('list'),
      options = document.querySelectorAll('#' + list + ' option'),
      inputValue = input.value;
console.log(inputValue)
  for(let i = 0; i < options.length; i++) {
      let option = options[i];
     console.log(option.innerText)
      if($(option).val() === inputValue) {
        $("#customerAnswerInput-hidden").val($(option).data("value"))
        console.log($("#customerAnswerInput-hidden").val())
          break;
      }
  }
});

//endregion customer search

//#region folder change
$('.folder-change i').mouseenter(function(e){
  $(this).removeClass( "fa-folder fa-6x" ).addClass( "fa-folder-open  fa-6x" );
}).mouseleave( function(e){
  $(this).removeClass( "fa-folder-open fa-6x" ).addClass( "fa-folder  fa-6x" );
})
//#endregion folder change
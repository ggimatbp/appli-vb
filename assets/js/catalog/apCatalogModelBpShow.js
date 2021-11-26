//#region import 

// On importe les notifications

import { vNotify } from '../app';

   $(document).ready(function () {
      vNotify();
    })

// On importe les notifications
   
import $ from 'jquery';

//#endregion import

$(".btn-launch-modal").each(function(){
    $(this).unbind("click").click(function(e){
    $("#hidden-data-picture-id").val($(this).data('img-id'))
                $('.carousel-item').attr('class', 'carousel-item');
                $("#active" + $(this).data('img-id')).addClass('active');
     })
});


$('#allCardFromCatalogModelShowBp .delete-btn-files').each(function(){
  $(this).unbind('click').click(function (e) {
      $("#fileIdToDelete").val($(this).data('file-img-id'))
  })
})


//#region ajax delete
$('#deleteModal .delete-files-secure').each(function(){
    $(this).unbind('click').click(function (e) {

            let filesId =$("#fileIdToDelete").val()
            console.log(filesId)
            // let filesToDelete = $(this).parents('.card-design')
            let filesToDelete = $('.card' + filesId)
             console.log(filesToDelete)
            //  $(this).parents('.card-design').remove();

            $.ajax({
              url:'/ap/catalog/files/bp/delete/' + filesId,
               type: "GET",
              dataType: "json",
              data: {
                   "filesId": filesId
              },
              async: true,
              success: function ()
              {
                
                vNotify().success({ text: 'Changement pris en compte.', title: 'Éléments supprimés' });
                $(filesToDelete).remove()
              },
              error: function ()
              {
                vNotify().error({ text: 'Erreur lors de la suppression.', title: 'Erreur' });
              }
          });
          })
})
  //#endregion ajax delete
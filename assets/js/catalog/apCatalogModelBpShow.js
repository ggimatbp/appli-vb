//#region import 

// On importe les notifications

import { vNotify } from '../app';

   $(document).ready(function () {
      vNotify();
    })

// On importe les notifications
   
import $ from 'jquery';

//on import le dropdown de bootstrap (technique pour que la modale ne bloque pas le système de dropdown bootstrap)

// import 'bootstrap/js/dist/dropdown';

//#endregion import

// //pdf reader

//  console.log(pdfjsLib)

// const pdfjsWorker = pdfjsLib.PDFWorker
// console.log(pdfjsWorker)


// pdfjsLib.GlobalWorkerOptions.workerSrc =
// "pdf.js/build/pdf.worker.js";

// let url =''

//  $(".pdfFileRoad").each(function(index){
//    url = $(this).data("src")
//    console.log(url);
//  })

// //  let pdfDoc = null,
// //     pageNum = 1,
// //     pageIsRendering = false
//     // pageNumIsPending = null;
  
//   const scale = 1.5,
//   canvas = document.querySelector('#pdf-render'),
//   ctx = canvas.getContext('2d');

//   //render the page 

//   const renderPage = num => {

//   }

//   //Get document

//   pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
//     pdfDoc = pdfDoc_;
//     console.log(pdfDoc)
//   });



  // pdfjsLib.getDocument(pdfRoad)

  // console.log(pdfjsLib.GlobalWorkerOptions.workerSrc)


// // Loading a document.
// const loadingTask = pdfjsLib.getDocument(pdfPath);
// loadingTask.promise
//   .then(function (pdfDocument) {
//     // Request a first page
//     return pdfDocument.getPage(1).then(function (pdfPage) {
//       // Display page on the existing canvas with 100% scale.
//       const viewport = pdfPage.getViewport({ scale: 1.0 });
//       const canvas = document.getElementById("theCanvas");
//       canvas.width = viewport.width;
//       canvas.height = viewport.height;
//       const ctx = canvas.getContext("2d");
//       const renderTask = pdfPage.render({
//         canvasContext: ctx,
//         viewport,
//       });
//       return renderTask.promise;
//     });
//   })
//   .catch(function (reason) {
//     console.error("Error: " + reason);
//   });









//#region pdf reader

$(".card-pdf-vich-miniature").each(function(){
  $(this).click(function(){
  let urlPdf = $(".pdfFileRoad" + $(this).data("id")).data("src");
      let pdfDoc = null,
  pageNum = 1,
  pageIsRendering = false,
  pageNumIsPending = null;
  
  const scale = 2,
  canvas = document.querySelector("#pdf-render" + $(this).data("id")),
  ctx = canvas.getContext('2d');
  
  //Render the page
  let renderPage = num => {
  pageIsRendering = true
      // Get page
      pdfDoc.getPage(num).then(page => {
          // Set scale
          const viewport = page.getViewport({ scale });
          canvas.height = viewport.height;
          canvas.width = viewport.width;
  
          const renderCtx = {
              canvasContext: ctx,
              viewport
          }
  
          page.render(renderCtx).promise.then(() => {
              pageIsRendering = false;
  
              if(pageNumIsPending !== null) {
                  renderPage(pageNumIsPending);
                  pageNumIsPending = null;
              }
          })
  
          //output current page
          document.querySelector('#page-num' + $(this).data("id")).textContent = num;
      })
   
  }

  
//check for pages rendering 

const queuRenderPage = num => {
  if(pageIsRendering) {
      pageNumIsPending = num;
  }else {
      renderPage(num);
  }
}

//show prev page 

const showPrevPage = () => {
  if(pageNum <= 1) {
      return;
  }
  pageNum--;
  queuRenderPage(pageNum);
}

//show Next Page 
const showNextPage = () => {
  console.log("2")
  console.log(pdfDoc)
  if(pageNum >= pdfDoc.numPages) {
      return;
  }
  pageNum++;
  queuRenderPage(pageNum);
}

// Get Document
pdfjsLib.getDocument(urlPdf).promise.then(pdfDoc_ => {
  pdfDoc = pdfDoc_;

  document.querySelector('#page-count' +  $(this).data("id") ).textContent = pdfDoc.numPages;
console.log("1")
// console.log(pdfDoc.numPages)
// console.log(pageNum)
  renderPage(pageNum)
});


// Button Events
console.log("prevpage" + $(this).data("id"))
console.log($('#prev-page' + $(this).data("id")))

// $('#prev-page' + $(this).data("id")).click(showPrevPage())
// $('#next-page' + $(this).data("id")).click(showNextPage())
// $('#prev-page' +  $(this).data("id")).click(showPrevPage());
document.querySelector('#prev-page' + $(this).data("id")).addEventListener('click', showPrevPage);
document.querySelector('#next-page' + $(this).data("id")).addEventListener('click', showNextPage);




$('.btn-close-pdf-destroy' + $(this).data("id")).click(function(){
  // console.log(123456)
  // pageIsRendering = false;
  //  pdfDoc = null;
  // pageNumIsPending = null;
  // pageNum = 1;
  // $(this).find($('.pdf-view #pdf-render')).remove()
})
//this.pdf_doc.destroy();

})

})

//#endregion pdf reader


//For show the good picture
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
  //#region BP



$('#deleteModal .delete-files-secure').each(function(){
    $(this).unbind('click').click(function (e) {
            let csrf = $("#fileIdToDelete").data('token')
            let filesId =$("#fileIdToDelete").val()
            console.log(filesId)
            // let filesToDelete = $(this).parents('.card-design')
            let filesToDelete = $('.card' + filesId)
             console.log(filesToDelete)
            //  $(this).parents('.card-design').remove();

            $.ajax({
              url: '/ap/catalog/files/bp/delete/' + filesId,

              type: "GET",
              dataType: "json",
              data: {
                   "filesId": filesId,
                   'csrf': csrf 
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
  //#endregion BP

  //#region vb
  
    //#region road choice
    let loc = $("#fileIdToDelete").data('localisation')
    let route = "pensez_a_modifier_le_JS"
    if(loc == "case"){
      //bulk image
      route = '/ap/catalog/vb/bulk/image/delete/'
    } else {
      // file vb
      route = '/ap/catalog/files/vb/delete/'
    }
   //#endregion road choice


  $('#deleteModalVb .delete-files-secure').each(function(){
    $(this).unbind('click').click(function (e) {

            let filesId =$("#fileIdToDelete").val()
            let csrf = $("#fileIdToDelete").data('token')
            // console.log(csrf)
            // let filesToDelete = $(this).parents('.card-design')
            let filesToDelete = $('.card' + filesId)
             console.log(route + filesId)
             console.log($("#fileIdToDelete").val())
            //  $(this).parents('.card-design').remove();

            $.ajax({
              url: route + filesId,
               type: "GET",
              dataType: "json",
              data: {
                   "csrf": csrf,
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




  //#endregion
//#endregion ajax delete

  //#region right click forbidden

//!!!!!!!!!!!!!!!!a remettre en fin de test !!!!!!!!!!!!!!!!!

  // document.addEventListener('contextmenu', event => event.preventDefault());

  //#endregion

  //#region zoom image modal

  // let zoomPlus = document.getElementsByClassName('zoom-plus')
  // let zoomMinus = document.getElementsByClassName('zoom-minus')

  // for (let i = 0; i < zoomPlus.length ; i++) {
  //   zoomPlus[i].onclick = moreZoom;
  // }

  // for (let i = 0; i < zoomMinus.length ; i++) {
  //   zoomMinus[i].onclick = lessZoom;
  // }

  // function moreZoom



  //#endregion

//#region import 

// On importe les notifications

import { vNotify } from '../app';

   $(document).ready(function () {
      vNotify();
    })

// On importe les notifications
   
import $ from 'jquery';

//#endregion import

//#region pdf reader

// $(".card-pdf-vich-miniature").each(function(){
//     $(this).click(function(){
    let urlPdf = $(".pdfFileRoad").data("src");
        let pdfDoc = null,
    pageNum = 1,
    pageIsRendering = false,
    pageNumIsPending = null;
    
    const scale = 1.7,
    canvas = document.querySelector("#pdf-render"),
    ctx = canvas.getContext('2d');
    let scaleize = 1;
    
    //Render the page
    let renderPage = num => {
    pageIsRendering = true
        // Get page
        pdfDoc.getPage(num).then(page => {
            // Set scale
            const viewport = page.getViewport({ scale });
            canvas.height = viewport.height * scaleize;
            canvas.width = viewport.width * scaleize;
    
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
            // document.querySelector('#page-num').textContent = num;
            let pageNumeroo = document.querySelectorAll('.page-num');
            pageNumeroo.forEach(element => element.innerText = num);
            if(pageNum == pdfDoc.numPages && $('#csrf-edit').data('state') == 0)
            {
              document.getElementById('btnParapher').classList.replace('button-on-hold', 'btn');
              document.getElementById('btnParapher').addEventListener('click', onClickAddParapher);
            }
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
    if(pageNum >= pdfDoc.numPages) {
        return;
    }
    pageNum++;
    queuRenderPage(pageNum);
  }

  // Get Document
  pdfjsLib.getDocument(urlPdf).promise.then(pdfDoc_ => {
    pdfDoc = pdfDoc_;
  
     let TotalpagesNumber = document.querySelectorAll('.page-count');
     TotalpagesNumber.forEach(element => element.textContent = pdfDoc.numPages)
      renderPage(pageNum)

  });
  

  

  // $('#prev-page' + $(this).data("id")).click(showPrevPage())
  // $('#next-page' + $(this).data("id")).click(showNextPage())
  // $('#prev-page' +  $(this).data("id")).click(showPrevPage());
  // document.querySelectorAll('.prev-page').addEventListener('click', showPrevPage);
  let previousPage = document.querySelectorAll('.prev-page');

  previousPage.forEach(element => element.addEventListener('click', showPrevPage));
  
  // document.querySelector('#next-page').addEventListener('click', showNextPage);

  let nextPage = document.querySelectorAll('.next-page');

  nextPage.forEach(element => element.addEventListener('click', showNextPage));
  
  
  
  $('.btn-close-pdf-destroy').click(function(){
    // pageIsRendering = false;
    //  pdfDoc = null;
    // pageNumIsPending = null;
    // pageNum = 1;
    // $(this).find($('.pdf-view #pdf-render')).remove()
  })
  //this.pdf_doc.destroy();
  
  
  //#endregion pdf reader

  //#region form
    //#region parapher




    function onClickAddParapher(e) {
        e.preventDefault();
        let editCsrf = $('#csrf-edit').val();
        let parapherId = $('#btnParapher').data('id');
        $.ajax({
          type: 'GET',
          url: '/information/files/parapher/' + parapherId,
          dataType: 'json',
          data: {
            "editCsrf": editCsrf,
            "parapherId": parapherId,
          },
          async: true,
      
          success: function (response) {
          vNotify().success({ text: 'Ce document a été lu et approuvé.', title: 'Validé' });
              // icone.classList.replace('fa-times-circle', 'fa-check-square');
              // icone.classList.replace('text-danger', 'text-success');
              document.getElementById('btnParapher').classList.replace('btn', 'button-success');
              document.getElementById('parapher-check').classList.replace('fa-false', 'fa-check');
          },
          error: function () {
            vNotify().error({ text: 'Vous allez commettre une terrible erreur !', title: 'Erreur' });
          },
        });
      }
    //#endregion
  //#endregion



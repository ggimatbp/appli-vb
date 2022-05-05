
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
  
  
  // Button Events  
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



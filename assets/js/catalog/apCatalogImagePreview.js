
//#region import 

// On importe les notifications

import { vNotify } from '../app';

   $(document).ready(function () {
      vNotify();
    })

// On importe les notifications


   
import $ from 'jquery';

//#endregion import

//#region image preview form
const inpFile = document.getElementById("ap_catalog_files_bp_imageFile_file")
const previewContainer = document.getElementById("imagePreview")
const previewImage = previewContainer.querySelector(".image-preview__image")
const previewDefaultText = previewContainer.querySelector(".image-preview__default-text")

inpFile.addEventListener("change", function(){
   const file = this.files[0]
   if(file) {
   console.log(file);
      const reader = new FileReader();

      previewDefaultText.style.display = "none";
      previewImage.style.display = "block";

      reader.addEventListener("load", function(){
         console.log(this);
            previewImage.setAttribute("src", this.result);
      });
      reader.readAsDataURL(file);
   }
})

//#endregion image preview form
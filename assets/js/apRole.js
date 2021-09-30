const { default: axios } = require("axios");


const apaccesses = document.querySelectorAll('li.apaccesses')
apaccesses.forEach((apaccess) => {
  addapaccessFormDeleteLink(apaccess)
})


// add an access form on click //

function addFormToCollection(e) {
  const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

  const item = document.createElement('li');

  item.innerHTML = collectionHolder
    .dataset
    .prototype
    .replace(
      /__name__/g,
      collectionHolder.dataset.index
    );
  addapaccessFormDeleteLink(item);
  collectionHolder.appendChild(item);

  //add add event litsener refresh on click when select option


  // replace option
  refreshOptionOnclick()
  replaceOptionOnAdd()
  collectionHolder.dataset.index++;


};



document
  .querySelectorAll('.add_item_link')
  .forEach(btn => btn.addEventListener("click", addFormToCollection));

const addapaccessFormDeleteLink = (apaccessFormLi) => {
  const removeFormButton = document.createElement('button')
  removeFormButton.classList
  removeFormButton.innerText = 'Delete this access'

  apaccessFormLi.append(removeFormButton);

  removeFormButton.addEventListener('click', (e) => {
    e.preventDefault()
    let optionToPutBack = '<option value="' + $(removeFormButton).parent().find('select option').last().val() + '">' + $(removeFormButton).parent().find('select option').last().text() + '</option>'
    
    // remove the li for the tag form
    apaccessFormLi.remove();
    putBackOption(optionToPutBack)
  });
}


function onClickBtnDelete(event) {

  
  let optionToPutBack = '<option value="' + $(this).parent().find('select option').last().val() + '">' + $(this).parent().find('select option').last().text() + '</option>'
  const url = this.href;
  let element = this;

  axios.get(url).then(function (response) {
    $(element).closest('li').remove()
  })
  putBackOption(optionToPutBack)

}

document.querySelectorAll('a.js-delete').forEach(function (link) {
  link.addEventListener('click', onClickBtnDelete)
})


///////////////* Ondelete logical for add back the option to the pool */////////////////

function putBackOption(optionToPutBack){
  let arrayOptionSelect = [];
  // arrayOptionSelect.push(optionToPutBack)
  $('.apaccesses li select').first().find('option').each(function () {
    arrayOptionSelect.push('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
  }
  );
  arrayOptionSelect.push(optionToPutBack)


  // we put all the selected tabs on an array
  let arrayOptionSelected = [];
  $('.apaccesses li').find('select').each(function (index) {
    arrayOptionSelected.push('<option value="' + $(this).val() + '">' + $(this).children("option").filter(":selected").text() + '</option>');
  })

  // we create an array of tabs without the selected one
  let arrayAllOptionWithoutSelected = arrayOptionSelect;

  for (let i = 0; i < arrayOptionSelected.length; i++) {
    for (let y = 0; y < arrayOptionSelect.length; y++) {
      if (arrayOptionSelected[i] == arrayOptionSelect[y]) {
        arrayAllOptionWithoutSelected.splice([y], 1)
      }
    }
    console.log('putBackOption')
  }

// we add the selected value to the array and we change the select value with the new one


  let option = arrayAllOptionWithoutSelected
  
  $('.apaccesses li select').each(function (index) {
    option = arrayAllOptionWithoutSelected
    option.push('<option value="' + $(this).val() + '" selected="selected">' + $(this).children("option").filter(":selected").text() + '</option>');
    $(this).empty()
    $(this).append(option)
    option.pop()
    // $(this).append(arrayAllOptionWithoutSelected)
  })
  console.log('replace with putBackOption')
}


// *** JS logical to not have twice the same select option ***

// we put in a variable all the tabs options 


/***************************** REPLACE OPTION WHEN ADDING APACCESSES ***************/

function replaceOptionOnAdd(){
  
  let arrayOptionSelect = [];
  $('.apaccesses li select').first().find('option').each(function () {
    arrayOptionSelect.push('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
  }
  );


  // we put all the selected tabs on an array
  let arrayOptionSelected = [];
  $('.apaccesses li').find('select').each(function () {
    arrayOptionSelected.push('<option value="' + $(this).val() + '">' + $(this).children("option").filter(":selected").text() + '</option>');
  })
  // we create an array of tabs without the selected one
  let arrayAllOptionWithoutSelected = arrayOptionSelect;

  for (let i = 0; i < arrayOptionSelected.length; i++) {
    for (let y = 0; y < arrayOptionSelect.length; y++) {
      if (arrayOptionSelected[i] == arrayOptionSelect[y]) {
        arrayAllOptionWithoutSelected.splice([y], 1)
      }
    }
  }

// we add the selected value to the array and we change the select value with the new one


  let option = arrayAllOptionWithoutSelected
  let lastIndex = $('.apaccesses li select')
  $('.apaccesses li select').each(function (index) {

    option = arrayAllOptionWithoutSelected
    if (index != lastIndex.length - 1 ){
      
    option.push('<option value="' + $(this).val() + '" selected="selected">' + $(this).children("option").filter(":selected").text() + '</option>');
    }
    else {
      let firstChoice = ('<option value="' + $(this).children("option").last().val() + '" selected="selected">' + $(this).children("option").last().text() + '</option>')
      option.push(firstChoice)

    }
    
    $(this).empty()
    $(this).append(option)
    option.pop()
    // $(this).append(arrayAllOptionWithoutSelected)
  })
  console.log('replaceOptionOnAdd')
}


function replaceOption(){

  let arrayOptionSelect = [];
  $('.apaccesses li select').first().find('option').each(function () {
    arrayOptionSelect.push('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
  }
  );


  // we put all the selected tabs on an array
  let arrayOptionSelected = [];
  $('.apaccesses li').find('select').each(function () {
    arrayOptionSelected.push('<option value="' + $(this).val() + '">' + $(this).children("option").filter(":selected").text() + '</option>');
  })
  // we create an array of tabs without the selected one
  let arrayAllOptionWithoutSelected = arrayOptionSelect;

  for (let i = 0; i < arrayOptionSelected.length; i++) {
    for (let y = 0; y < arrayOptionSelect.length; y++) {
      if (arrayOptionSelected[i] == arrayOptionSelect[y]) {
        arrayAllOptionWithoutSelected.splice([y], 1)
      }
    }
  }

// we add the selected value to the array and we change the select value with the new one


  let option = arrayAllOptionWithoutSelected
  $('.apaccesses li select').each(function () {

    option = arrayAllOptionWithoutSelected
    option.push('<option value="' + $(this).val() + '" selected="selected">' + $(this).children("option").filter(":selected").text() + '</option>');
    $(this).empty()
    $(this).append(option)
    option.pop()
    // $(this).append(arrayAllOptionWithoutSelected)
  })
  console.log('replaceOption')

}


// ********   AddEventlistener to modify the list every time you click on the selected option. ***********  //

function refreshOptionOnclick(){
  
  

  $('.apaccesses li select').on("click", function (index) {
    // il faut que je trouve le slected puis que je le mette dans le pool des select pour éviter qu'il disparraisse
    let theLostOne = ('<option value="' + $(this).val() + '">' + $(this).children("option").filter(":selected").text() + '</option>')
    console.log(theLostOne + 123)
    $('.apaccesses li select')
.each(function (){
      // *** JS logical to not have twice the same select option ***
      console.log(this)
      // we put in a variable all the tabs options 
      let arrayOptionSelect = [];
      $('.apaccesses li select').first().find('option').each(function () {
        arrayOptionSelect.push('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
      }
      );
      
      // il faut que je trouve le slected puis que je le mette dans le pool des select pour éviter qu'il disparraisse
      console.log('<option value="' + $(this).val() + '">' + $(this).children("option").filter(":selected").text() + '</option>')

      // we put all the selected tabs on an array
      let arrayOptionSelected = [];
      $('.apaccesses li').find('select').each(function (index) {
        arrayOptionSelected.push('<option value="' + $(this).val() + '">' + $(this).children("option").filter(":selected").text() + '</option>');
      })

      // we create an array of tabs without the selected one
      let arrayAllOptionWithoutSelected = arrayOptionSelect;

      for (let i = 0; i < arrayOptionSelected.length; i++) {
        for (let y = 0; y < arrayOptionSelect.length; y++) {
          if (arrayOptionSelected[i] == arrayOptionSelect[y]) {
            arrayAllOptionWithoutSelected.splice([y], 1)
          }
        }
      }

      // we add the selected value to the array and we change the select value with the new one

      let option = arrayAllOptionWithoutSelected
      console.log(arrayOptionSelect.length + arrayOptionSelected.length)
      console.log(arrayOptionSelected.length + " / Selected")
      console.log(arrayOptionSelect.length + " / arrayOptionSelect")
      //  $('.apaccesses li select').each(function () {
        console.log(('<option value="' + $(this).val() + '">' + $(this).children("option").filter(":selected").text() + '</option>'))
        option = arrayAllOptionWithoutSelected
        // il faut que je trouve le slected puis que je le mette dans le pool des select pour éviter qu'il disparraisse
        if( theLostOne != ('<option value="' + $(this).val() + '">' + $(this).children("option").filter(":selected").text() + '</option>') )
        {
          option.push(theLostOne)
        }
     // })
      //   console.log(theLostOne + 'le operduye')
      //   console.log(('<option value="' + $(this).val() + '">' + $(this).children("option").filter(":selected").text() + '</option>') + 'le récup')
        option.push('<option value="' + $(this).val() + '" selected="selected">' + $(this).children("option").filter(":selected").text() + '</option>');
         $(this).empty()
         $(this).append(option)
         
        //console.log(option + ' on refreshOptionOnclick')
          // option.pop()
        // $(this).append(arrayAllOptionWithoutSelected)
       })

      // $(this).append(arrayAllOptionWithoutSelected)
    // })

  
console.log('refreshOptionOnclick')
      })   
}

$(document).ready(function () {
  refreshOptionOnclick()
  replaceOption()
});
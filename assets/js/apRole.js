const { default: axios } = require("axios");


const apaccesses = document.querySelectorAll('li.apaccesses')
apaccesses.forEach((apaccess) => {
    addapaccessFormDeleteLink(apaccess)
})

function addFormToCollection(e){
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
        // remove the li for the tag form
        apaccessFormLi.remove();
    });
}

// delete access function for edit 

// function deleteAccess(id) {
//   $.ajax({
//     type: "POST",
//     url: "{{ path('ap_role_index') }}",
//     data: {
//       id_access: id
//     },
//     success: success,
//     dataType: dataType
//   });
// }

// $('.delete-btn').unbind('click').click(function(e) {
//   let id = $(this).data('idaccess')
//   console.log(id)
//   deleteAccess(id)
// });

// var deletebtn = document.getElementsByClassName("delete-btn")

// deletebtn.addEventListener("click", deleteAccess)
// function deleteAccess(id){
//   console.log(id)
//   fetch("/ap/access/" + id, {
//     method: 'POST'
//   })
//   .then((response) => response.text()) // or res.json()
//   .then(res => console.log(res))

// }*

function onClickBtnDelete(event){
  event.preventDefault();

  const url = this.href;
  let element = this;

  axios.get(url).then(function(response){
    $(element).closest('li').remove()
  })
}

document.querySelectorAll('a.js-delete').forEach(function(link){
  link.addEventListener('click', onClickBtnDelete)
})
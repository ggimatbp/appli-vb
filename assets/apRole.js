
// On import le jquery

import $ from 'jquery';

// On import les notifications

import { vNotify } from './app';

$(document).ready(function () {
  vNotify();
})

const { default: axios } = require("axios");

document.querySelectorAll('a.js-check').forEach(function (link) {
  link.addEventListener('click', onClickAddAuth);
})


function onClickAddAuth(e) {

  e.preventDefault();
  const url = this.href;
  const icone = this.querySelector('i');
  axios.get(url).then(function () {

    if (icone.classList.contains('fa-times-circle')) {
      vNotify().success({ text: 'Changement pris en compte.', title: 'Ajout de droit' });
      icone.classList.replace('fa-times-circle', 'fa-check-square');
      icone.classList.replace('text-danger', 'text-success');
    } else {
      vNotify().success({ text: 'Changement pris en compte.', title: 'Retrait de droit' });
      icone.classList.replace("fa-check-square", "fa-times-circle");
      icone.classList.replace('text-success', 'text-danger');

    }
  }).catch(function () {
    vNotify().error({ text: 'This is an error notification.', title: 'Error' });
  })
}

// logic pour le changement de nom en ajax

$('#role-name-btn').unbind('click').click(function (e) {
  let roleName = $('#role-name').val();
  let roleId = $('#role-name').data('id');
  $.ajax({
    url:'/ap/role/editNameOnClick/' + roleId,
    type: "POST",
    dataType: "json",
    data: {
        "task": roleName
    },
    async: true,
    success: function ()
    {
      vNotify().success({ text: 'Changement pris en compte.', title: 'changement de nom du rôle' });

    },
    error: function ()
    {
      vNotify().error({ text: 'Erreur lors du changement de nom.', title: 'Erreur' });
    }
});
})

// logique pour le changement de mot de passe 


$('#passwor-modificator-btn').unbind('click').click(function (e) {
  let userPassword = $('#user-password').val();
  let userId = $('#user-password').data('id');
  $.ajax({
    url:'/user/editPasswordOnClick/' + userId,
    type: "POST",
    dataType: "json",
    data: {
        "task": userPassword
    },
    async: true,
    success: function ()
    {
      vNotify().success({ text: 'Changement pris en compte.', title: 'changement du mot passe' });

    },
    error: function ()
    {
      vNotify().error({ text: 'Le changement de mot de passe a échoué, merci de soumettre un mot de passe créé par le générateur de mot de passe ', title: 'Erreur' });
    }
});
})



$('#password-generator-btn').unbind('click').click(function (e) {
  e.preventDefault();
  $.ajax({
    url:'/user/password/generator',
    type: "POST",
    dataType: "json",
    data: { 
    },
    async: true,
    success: function (response)
    {
      //      alert("nouveau mot de passe:" + response + <br> + "Ce mot de passe est directement écrit dans la barre veuillez le copier ici");


      vNotify().success({ text: 'Génération de mot de passe réussie celui-ci a été copié dans votre presse-papier', title: 'Génération réussie' });
      $("#registration_form_plainPassword").val(response);
      $("#visualisation-password-generator").val(response);
        // $("#visualisation-password-generator").html("<p>" + response + "</p>"); 
        // copyText($("#visualisation-password-generator").html());
        let copyFrom = document.createElement("textarea");
        document.body.appendChild(copyFrom);
        copyFrom.textContent = response;
        copyFrom.select();
        document.execCommand("copy");
        copyFrom.remove();
        
    },
    error: function ()
    {
      vNotify().error({ text: 'La génération de mot de passe a échoué', title: 'Erreur' });
    }
});
})





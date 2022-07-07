let tab = document.getElementsByClassName('nav-info')

function tabChangement () {
    targetId = this.dataset.idcontent;
    targetContent = document.getElementById(targetId);
    console.log(targetId);
    for (let i = 0; i < tab.length ; i++) {
        tab[i].classList.remove('nav-info-active');
       targetIdAll = tab[i].dataset.idcontent;
       targetContentAll = document.getElementById(targetIdAll);
       targetContentAll.classList.remove('info-content-visible');
      }
      targetContent.classList.add('info-content-visible');
      this.classList.add('nav-info-active')
  }

//   console.log(document.getElementById('archivedFileContent'));
  for (let i = 0; i < tab.length ; i++) {
    tab[i].onclick = tabChangement;
  }




// {
// element.onclick = tabChangement;
// console.log(123)
// })


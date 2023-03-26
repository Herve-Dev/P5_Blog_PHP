document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.slider');
    var instances = M.Slider.init(elems);
});

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.dropdown-trigger');
    var instances = M.Dropdown.init(elems);
});

window.onload = () => {
  let buttons = document.querySelectorAll(".switch")
  for (let button of buttons) {
    button.addEventListener("click", activeComment)
  }
}

function activeComment() {
  let xmlhttp = new XMLHttpRequest;
  xmlhttp.open('GET', '/admin/activeComment/'+this.dataset.id)
  xmlhttp.send()
}

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.sidenav');
  var instances = M.Sidenav.init(elems);
});

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.parallax');
  var instances = M.Parallax.init(elems);
});

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.modal');
  var instances = M.Modal.init(elems);
  
});

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.collapsible');
  var instances = M.Collapsible.init(elems);
});

window.onload = () => {
  let collapsComments = document.querySelectorAll(".update-com")
  for (let collapsComment of collapsComments) {
    collapsComment.addEventListener("click", FormUpdateComment)
  }
}

function FormUpdateComment() {

  let options = {
    method: 'GET',      
    headers: {}
  };
  
  fetch('/post/findCom/'+this.dataset.comment, options)
  .then(response => response.json())
  .then(data => {

    const formExist = document.querySelector('.form-js'+this.dataset.comment)

      if (formExist) {
        formExist.remove()
      }
    

    const resData = JSON.stringify(data).replace('"' ,'').replace('"', '')
    
    console.log( resData );
    
    let formUpdate = document.querySelector(`.span-form${this.dataset.comment}`)

    let form = document.createElement('form')
    Object.assign(form, {
      action: '#',
      method: 'POST',
      enctype: 'multipart/form-data',
      className: 'form-js'+this.dataset.comment
    })


    let label = document.createElement('label')
    label.setAttribute('for', 'comment_content')
    label.textContent = 'Votre commentaire :'

    
    let input = document.createElement('input')
    Object.assign(input, {
      type: 'text',
      name: 'comment_content',
      className: 'validate',
      id: 'update-input',
    })
    input.setAttribute('value', resData)

    let btn = document.createElement('button')
    btn.setAttribute('class', `btn waves-effect waves-light btn-update${this.dataset.comment}`)
    btn.textContent = 'Mettre à jour mon commentaire'

    form.append(label, input, btn)
    formUpdate.appendChild(form)

  })
}


function updateCom(id, data){

  let options = {
    method: 'POST',      
    headers: {}
  };

  fetch(`/post/updateCom/${id}/${data}`, {
    method: "POST",
    body: data
    })
    .then((reponse) => {
        // Gestion de la réponse
    })
    .catch((erreur) => {
        // Gestion des erreurs
    });
}




let buttons = document.querySelectorAll(".switch-button")
for (let button of buttons) {
  button.addEventListener("click", activeComment)
}

function activeComment() {

  const dataset = this.dataset.id
  let commentIsActive = document.querySelector(`.td-comment-${dataset}`)
  let switchs = document.getElementById(`switch${dataset}`).checked

  if (switchs) {
    commentIsActive.textContent = 1
    M.toast({ html: '<p> Commentaire activé </p>', classes: "green" })
  }else{
    commentIsActive.textContent = 0
    M.toast({ html: '<p> Commentaire désactivé </p>', classes: "orange foncé-1" })
  }

  const urlFetch = "/admin/activeComment/" + this.dataset.id;
  fetch(urlFetch, { method: "GET" })
    .then((response) => response.json())
    .then((response) => response)
    .catch((err) => {
      console.log(err);
    });

     /*M.toast({ html: response.success, classes: "green" })*/
}
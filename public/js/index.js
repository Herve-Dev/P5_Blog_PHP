import Form from "./formJS";


document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.slider');
    var instances = M.Slider.init(elems);
});

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.dropdown-trigger');
    var instances = M.Dropdown.init(elems);
});

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

window.onload = async () => {
  let collapsComments = document.querySelectorAll(".update-com")
  for (let collapsComment of collapsComments) {
    collapsComment.addEventListener("click", FormUpdateComment)
  }
}

function FormUpdateComment() {
  
  const dataset = this.dataset.comment
  const dataForInput = document.getElementById(`comment-${dataset}`).innerText;
  const form = new Form(dataset, dataForInput)

}

console.log(document.querySelector('.bloc-msg'));





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


function addclass() {
  var check = document.getElementById("input-search").value;
  search = document.getElementById("search-box");
  check != "" ? search.classList.add("open") : search.classList.remove("open");
}

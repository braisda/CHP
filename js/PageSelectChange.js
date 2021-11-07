function selectChange(selectedElement, entity) {
    let urlRoute = "./" + entity + "Controller.php?currentPage=1&itemsPerPage=" + selectedElement.value;
    window.location.href = urlRoute;
}
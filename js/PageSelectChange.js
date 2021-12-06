function selectChange(selectedElement, entity) {
    let urlRoute = "./" + entity + "Controller.php?page=1&pageItems=" + selectedElement.value;
    window.location.href = urlRoute;
}
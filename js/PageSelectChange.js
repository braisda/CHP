function selectChange(selectedElement, entity) {
    let urlRoute = "./" + entity + "controller.php?page=1&pageItems=" + selectedElement.value;
    window.location.href = urlRoute;
}
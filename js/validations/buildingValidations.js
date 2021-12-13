function checkNameBuilding(field) {
    const name = "nombre";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkLength(field,'30', name)) === ""
        && (toret = checkText(field,'30', name)) === "" && (toret = checkAlphabetical(field,'30', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('name-div', name, toret, field);
        return false;
    }
}

function checkNameEmptyBuilding(field) {
    if (field.value.length > 0) {
        return checkNameBuilding(field);
    } else {
        return true;
    }
}

function checkLocationBuilding(field) {
    const name = "localización";
    const nameDiv = "location";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkLength(field,'30', name)) === ""
        && (toret = checkText(field,'30', name)) === "" && (toret = checkAlphabetical(field,'30', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('location-div', nameDiv, toret, field);
        return false;
    }
}

function checkLocationEmptyBuilding(field) {
    if (field.value.length > 0) {
        return checkLocationBuilding(field);
    } else {
        return true;
    }
}

function areBuildingFieldsCorrect() {
    const form = $('#buildingForm')[0];
    if(checkNameBuilding(form.elements[0]) && checkLocationBuilding(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

function areBuildingSearchFieldsCorrect() {
    const form = $('#buildingSearchForm')[0];
    if(checkNameEmptyBuilding(form.elements[0]) && checkLocationEmptyBuilding(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

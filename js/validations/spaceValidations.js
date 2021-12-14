function checkNameSpace(field) {
    const name = "nombre";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkLength(field,'30', name)) === ""
        && (toret = checkText(field,'30', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('name-div', name, toret, field);
        return false;
    }
}

function checkNameEmptySpace(field) {
    if (field.value.length > 0) {
        return checkNameSpace(field);
    } else {
        return true;
    }
}

function checkCapacitySpace(field) {
    const name = "capacidad";
    if ((toret = checkEmpty(field, name)) === ""
        && (toret = checkLength(field,'3', name)) === "") {
        deleteMessage('capacity-div');
        return true;
    } else {
        console.log(toret)
        showMessage('capacity-div', name, toret, field);
        return false;
    }
}

function checkCapacityEmptySpace(field) {
    if (field.value.length > 0) {
        return checkCapacitySpace(field);
    } else {
        return true;
    }
}

function areSpaceFieldsCorrect() {
    const form = $('#spaceForm')[0];
    if(checkNameSpace(form.elements[0]) && checkCapacitySpace(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

function areSpaceSearchFieldsCorrect() {
    const form = $('#spaceSearchForm')[0];
    if(checkNameEmptySpace(form.elements[0]) && checkCapacityEmptySpace(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

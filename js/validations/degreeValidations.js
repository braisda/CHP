function checkNameDegree(field) {
    const name = "nombre";
    if ((result = checkEmpty(field, name)) === "" && (result = checkLength(field,'30', name)) === ""
        && (result = checkText(field,'30', name)) === "" && (result = checkAlphabetical(field,'30', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('name-div', name, result);
        return false;
    }
}

function checkNameEmptyDegree(field) {
    if (field.value.length > 0) {
        return checkNameDegree(field);
    } else {
        return true;
    }
}

function checkCapacityDegree(field) {
    const name = "plazas";
    if ((result = checkEmpty(field, name)) === "" && (result = checkInteger(field,0, 999, name)) === ""
        && (result = checkLength(field,'3', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('places-div', name, result);
        return false;
    }
}

function checkCapacityEmptyDegree(field) {
    if (field.value.length > 0) {
        return checkCapacityDegree(field);
    } else {
        return true;
    }
}

function checkCreditsDegree(field) {
    const name = "créditos";
    const nameDiv = "credits";
    if ((result = checkEmpty(field, name)) === "" && (result = checkInteger(field,0, 999, name)) === ""
        && (result = checkLength(field,'3', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('credits-div', name, result);
        return false;
    }
}

function checkCreditsEmptyDegree(field) {
    if (field.value.length > 0) {
        return checkCreditsDegree(field);
    } else {
        return true;
    }
}

function checkDescriptionDegree(field) {
    const name = "descripción";
    const nameDiv = "description";
    if ((result = checkEmpty(field, name)) === "" && (result = checkLength(field,'50', name)) === ""
        && (result = checkText(field,'50', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('description-div', nameDiv, result);
        return false;
    }
}

function checkDescriptionEmptyDegree(field) {
    if (field.value.length > 0) {
        return checkDescriptionDegree(field);
    } else {
        return true;
    }
}

function areDegreeFieldsCorrect() {
    const form = $('#degreeForm')[0];
    if(checkNameDegree(form.elements[0]) && checkCapacityDegree(form.elements[3]) && checkCreditsDegree(form.elements[4]) && checkDescriptionDegree(form.elements[5])) {
        return true;
    } else {
        return false;
    }
}

function areDegreeSearchFieldsCorrect() {
    const form = $('#degreeSearchForm')[0];
    if(checkNameEmptyDegree(form.elements[0]) && checkCapacityEmptyDegree(form.elements[3]) && checkCreditsEmptyDegree(form.elements[4]) && checkDescriptionEmptyDegree(form.elements[5])) {
        return true;
    } else {
        return false;
    }
}
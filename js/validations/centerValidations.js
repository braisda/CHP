function checkNameCenter(field) {
    const name = "nombre";
    if ((result = checkEmpty(field, name)) === "" && (result = checkLength(field,'30', name)) === ""
        && (result = checkText(field,'30', name)) === "" && (result = checkAlphabetical(field,'30', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('name-div', name, result, field);
        return false;
    }
}

function checkNameEmptyCenter(field) {
    if (field.value.length > 0) {
        return checkNameCenter(field);
    } else {
        return true;
    }
}

function areCenterFieldsCorrect() {
    const form = $('#centerForm')[0];
    if(checkNameCenter(form.elements[0])) {
        return true;
    } else {
        return false;
    }
}

function areCenterSearchFieldsCorrect() {
    const form = $('#centerSearchForm')[0];
    if(checkNameEmptyCenter(form.elements[0])) {
        return true;
    } else {
        return false;
    }
}
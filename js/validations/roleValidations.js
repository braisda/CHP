function checkNameRole(field) {
    const name = "nombre";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkLength(field,'60', name)) === "" 
        && (toret = checkText(field,'60', name)) === "" && (toret = checkAlphabetical(field,'60', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('name-div', name, toret, field);
        return false;
    }
}

function checkNameEmptyRole(field) {
    if (field.value.length > 0) {
        return checkNameRole(field);
    } else {
        return true;
    }
}

function checkDescriptionRole(field) {
    const name = "descripción";
	const nameDiv = "description";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkLength(field,'100', name)) === "" 
        && (toret = checkText(field,'100', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('description-div', nameDiv, toret, field);
        return false;
    }
}

function checkDescriptionEmptyRole(field) {
    if (field.value.length > 0) {
        return checkDescriptionRole(field);
    } else {
        return true;
    }
}

function areRoleFieldsCorrect() {
    form = $('#actionForm')[0];
    if(checkNameRole(form.elements[0]) && checkDescriptionRole(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

function areRoleSearchFieldsCorrect() {
    form = $('#roleSearchForm')[0];
    if(checkNameEmptyRole(form.elements[0]) && checkDescriptionEmptyRole(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

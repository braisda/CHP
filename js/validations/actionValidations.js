function checkNameAction(field) {
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

function checkNameEmptyAction(field) {
    if (field.value.length > 0) {
        return checkNameAction(field);
    } else {
        return true;
    }
}

function checkDescriptionAction(field) {
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

function checkDescriptionEmptyAction(field) {
    if (field.value.length > 0) {
        return checkDescriptionAction(field);
    } else {
        return true;
    }
}

function areActionFieldsCorrect() {
    form = $('#actionForm')[0];
    if(checkNameAction(form.elements[0]) && checkDescriptionAction(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

function areActionSearchFieldsCorrect() {
    form = $('#actionSearchForm')[0];
    if(checkNameEmptyAction(form.elements[0]) && checkDescriptionEmptyAction(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

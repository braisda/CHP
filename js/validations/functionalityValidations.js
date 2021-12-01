function checkNameFunctionality(field) {
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

function checkNameEmptyFunctionality(field) {
    if (field.value.length > 0) {
        return checkNameFunctionality(field);
    } else {
        return true;
    }
}

function checkDescriptionFunctionality(field) {
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

function checkDescriptionEmptyFunctionality(field) {
    if (field.value.length > 0) {
        return checkDescriptionFunctionality(field);
    } else {
        return true;
    }
}


function areFunctionalityFieldsCorrect() {
    form = $('#actionForm')[0];
    if(checkNameFunctionality(form.elements[0]) && checkDescriptionFunctionality(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

function areFunctionalitySearchFieldsCorrect() {
    form = $('#functionalitySearchForm')[0];
    if(checkNameEmptyFunctionality(form.elements[0]) && checkDescriptionEmptyFunctionality(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}
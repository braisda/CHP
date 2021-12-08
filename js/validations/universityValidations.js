function checkNameUniversity(field) {
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

function checkNameEmptyUniversity(field) {
    if (field.value.length > 0) {
        return checkNameUniversity(field);
    } else {
        return true;
    }
}

function areUniversityFieldsCorrect() {
    const form = $('#universityForm')[0];
    if(checkNameUniversity(form.elements[0])) {
        return true;
    } else {
        return false;
    }
}

function areUniversitySearchFieldsCorrect() {
    const form = $('#universitySearchForm')[0];
    if(checkNameEmptyUniversity(form.elements[0])) {
        return true;
    } else {
        return false;
    }
}
function checkNameDepartment(field) {
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

function checkNameEmptyDepartment(field) {
    if (field.value.length > 0) {
        return checkNameDepartment(field);
    } else {
        return true;
    }
}

function checkCodeDepartment(field) {
    const name = "código";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkLength(field,'6', name)) === ""
        && (toret = checkText(field,'6', name)) === "" && (toret = checkStartsWith(field, 'D', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('code-div', name, toret, field);
        return false;
    }
}

function checkCodeEmptyDepartment(field) {
    if (field.value.length > 0) {
        return checkCodeDepartment(field);
    } else {
        return true;
    }
}

function areDepartmentFieldsCorrect() {
    const form = $('#departmentForm')[0];
    if(checkNameDepartment(form.elements[0]) && checkCodeDepartment(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

function areDepartmentSearchFieldsCorrect() {
    const form = $('#departmentSearchForm')[0];
    if(checkNameEmptyDepartment(form.elements[0]) && checkCodeEmptyDepartment(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}
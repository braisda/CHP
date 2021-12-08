function checkDedicationTeacher(field) {
    const name = "dedicación";
    const nameDiv = "dedication";
    if ((result = checkEmpty(field, name)) === "" && (result = checkLength(field,'4', name)) === ""
        && (result = checkText(field,'4', name)) === "" && (result = checkWhiteSpaces(field, name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('dedication-div', nameDiv, result);
        return false;
    }
}

function checkDedicationEmptyTeacher(field) {
    if (field.value.length > 0) {
        return checkDedicationTeacher(field);
    } else {
        return true;
    }
}

function areTeacherFieldsCorrect() {
    const form = $('#teacherForm')[0];
    if(checkDedicationTeacher(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

function areTeacherSearchFieldsCorrect() {
    const form = $('#teacherSearchForm')[0];
    if(checkDedicationEmptyTeacher(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}
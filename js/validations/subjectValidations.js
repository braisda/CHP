
function checkCodeSubject(field) {
    const name = "código";
    const nameDiv = "code-div";
    if ((result = checkEmpty(field, name)) === "" && (result = checkWhiteSpaces(field, name)) === ""
        && (result = checkLength(field,'10', name)) === "" && (result = checkText(field,'10', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('code-div', nameDiv, result);
        return false;
    }
}

function checkCodeEmptySubject(field) {
    if (field.value.length > 0) {
        return checkCodeSubject(field);
    } else {
        return true;
    }
}

function checkAcronymSubject(field) {
    const name = "acrónimo";
    const nameDiv = "acronym";
    if ((result = checkLength(field,'8', name)) === "" && (result = checkText(field,'8', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('acronym-div', nameDiv, result);
        return false;
    }
}

function checkAcronymEmptySubject(field) {
    if (field.value.length > 0) {
        return checkAcronymSubject(field);
    } else {
        return true;
    }
}

function checkContentSubject(field) {
    const name = "contenido";
    if ((result = checkEmpty(field, name)) === ""
        && (result = checkLength(field,'100', name)) === "" && (result = checkText(field,'100', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('content-div', name, result);
        return false;
    }
}

function checkContentEmptySubject(field) {
    if (field.value.length > 0) {
        return checkContentSubject(field);
    } else {
        return true;
    }
}

function checkTypeSubject(field) {
    const name = "tipo";
    if ((result = checkEmpty(field, name)) === "" && (result = checkWhiteSpaces(field, name)) === ""
        && (result = checkLength(field,'2', name)) === "" && (result = checkAlphabetical(field,'2', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('type-div', name, result);
        return false;
    }
}

function checkTypeEmptySubject(field) {
    if (field.value.length > 0) {
        return checkTypeSubject(field);
    } else {
        return true;
    }
}

function checkAreaSubject(field) {
    const name = "area";
    if ((result = checkEmpty(field, name)) === "" && (result = checkWhiteSpaces(field, name)) === ""
        && (result = checkLength(field,'5', name)) === "" && (result = checkText(field,'5', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('area-div', name, result);
        return false;
    }
}

function checkAreaEmptySubject(field) {
    if (field.value.length > 0) {
        return checkAreaSubject(field);
    } else {
        return true;
    }
}

function checkCourseSubject(field) {
    const name = "curso";
    if ((result = checkEmpty(field, name)) === "" && (result = checkLength(field,'5', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('course-div', name, result);
        return false;
    }
}

function checkCourseEmptySubject(field) {
    if (field.value.length > 0) {
        return checkCourseSubject(field);
    } else {
        return true;
    }
}

function checkQuarterSubject(field) {
    const name = "cuatrimestre";
    if ((result = checkEmpty(field, name)) === "" && (result = checkLength(field,'5', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('quarter-div', name, result);
        return false;
    }
}

function checkQuarterEmptySubject(field) {
    if (field.value.length > 0) {
        return checkQuarterSubject(field);
    } else {
        return true;
    }
}

function checkHoursSubject(field) {
    const name = "horas";
    if ((result = checkEmpty(field, name)) === "" && (result = checkInteger(field,0, 9999, name)) === ""
        && (result = checkLength(field,'5', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('hours-div', name, result);
        return false;
    }
}

function checkHoursEmptySubject(field) {
    if (field.value.length > 0) {
        return checkHoursSubject(field);
    } else {
        return true;
    }
}

function checkNewRegistrationSubject(field) {
    const name = "nueva matrícula";
    const nameDiv = "registration"
    if ((result = checkEmpty(field, name)) === "" && (result = checkInteger(field,0, 999, name)) === ""
        && (result = checkLength(field,'3', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('new-registration-div', nameDiv, result);
        return false;
    }
}

function checkNewRegistrationEmptySubject(field) {
    if (field.value.length > 0) {
        return checkNewRegistrationSubject(field);
    } else {
        return true;
    }
}

function checkRepeatersSubject(field) {
    const name = "repetidores";
    if ((result = checkEmpty(field, name)) === "" && (result = checkInteger(field,0, 999, name)) === ""
        && (result = checkLength(field,'3', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('repeaters-div', name, result);
        return false;
    }
}

function checkRepeatersEmptySubject(field) {
    if (field.value.length > 0) {
        return checkRepeatersSubject(field);
    } else {
        return true;
    }
}

function checkEffectiveStudentsSubject(field) {
    const name = "efectivos";
    if ((result = checkEmpty(field, name)) === "" && (result = checkInteger(field,0, 999, name)) === ""
        && (result = checkLength(field,'3', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('effective-students-div', name, result);
        return false;
    }
}

function checkEffectiveStudentsEmptySubject(field) {
    if (field.value.length > 0) {
        return checkEffectiveStudentsSubject(field);
    } else {
        return true;
    }
}

function checkEnrolledHoursSubject(field) {
    const name = "horas matriculadas";
    const nameDiv = "enrolled";
    if ((result = checkEmpty(field, name)) === "" && (result = checkLength(field,'8', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('enrolled-hours-div', nameDiv, result);
        return false;
    }
}

function checkEnrolledHoursEmptySubject(field) {
    if (field.value.length > 0) {
        return checkEnrolledHoursSubject(field);
    } else {
        return true;
    }
}

function checkTaughtHoursSubject(field) {
    const name = "horas impartidas";
    const nameDiv = "taught";
    if ((result = checkEmpty(field, name)) === "" && (result = checkLength(field,'5', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('taught-hours-div', nameDiv, result);
        return false;
    }
}

function checkTaughtHoursEmptySubject(field) {
    if (field.value.length > 0) {
        return checkTaughtHoursSubject(field);
    } else {
        return true;
    }
}

function checkCreditsSubject(field) {
    const name = "créditos";
    const nameDiv = "credits";
    if ((result = checkEmpty(field, name)) === "" && (result = checkLength(field,'5', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('credits-div', nameDiv, result);
        return false;
    }
}

function checkCreditsEmptySubject(field) {
    if (field.value.length > 0) {
        return checkCreditsSubject(field);
    } else {
        return true;
    }
}

function checkStudentsSubject(field) {
    const name = "estudiantes";
    if ((result = checkEmpty(field, name)) === "" && (result = checkInteger(field,0, 999, name)) === ""
        && (result = checkLength(field,'3', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('students-div', name, result);
        return false;
    }
}

function checkStudentsEmptySubject(field) {
    if (field.value.length > 0) {
        return checkStudentsSubject(field);
    } else {
        return true;
    }
}


function areSubjectFieldsCorrect() {
    const form = $('#subjectForm')[0];
    if(checkCodeSubject(form.elements[0]) && checkContentSubject(form.elements[1]) &&
        checkTypeSubject(form.elements[2]) && checkAreaSubject(form.elements[4]) &&
        checkCourseSubject(form.elements[5]) && checkQuarterSubject(form.elements[6]) &&
        checkCreditsSubject(form.elements[7]) && checkNewRegistrationSubject(form.elements[8]) &&
        checkRepeatersSubject(form.elements[9]) && checkEffectiveStudentsSubject(form.elements[10]) &&
        checkEnrolledHoursSubject(form.elements[11]) && checkTaughtHoursSubject(form.elements[12]) &&
        checkHoursSubject(form.elements[13]) && checkStudentsSubject(form.elements[14])
    ) {
        return true;
    } else {
        return false;
    }
}

function areSubjectSearchFieldsCorrect() {
    const form = $('#subjectSearchForm')[0];
    if(checkCodeEmptySubject(form.elements[0]) && checkContentEmptySubject(form.elements[1]) &&
        checkTypeEmptySubject(form.elements[2]) && checkAreaEmptySubject(form.elements[4]) &&
        checkCourseEmptySubject(form.elements[5]) && checkQuarterEmptySubject(form.elements[6]) &&
        checkCreditsEmptySubject(form.elements[7]) && checkNewRegistrationEmptySubject(form.elements[8]) &&
        checkRepeatersEmptySubject(form.elements[9]) && checkEffectiveStudentsEmptySubject(form.elements[10]) &&
        checkEnrolledHoursEmptySubject(form.elements[11]) && checkTaughtHoursEmptySubject(form.elements[12]) &&
        checkHoursEmptySubject(form.elements[13]) && checkStudentsEmptySubject(form.elements[14])
    ) {
        return true;
    } else {
        return false;
    }
}




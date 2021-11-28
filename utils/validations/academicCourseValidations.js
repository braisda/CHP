function checkStartYearIntegerAcademicCourse(field, minValue, maxValue) {
    const name = "inicio";
    if ((toret = checkInteger(field, minValue, maxValue, name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('start-year-div', name, toret, field);
        return false;
    }
}

function checkStartYearEmptyAcademicCourse(field) {
    if (field.value.length > 0) {
        return checkStartYearIntegerAcademicCourse(field, 2000, 9999);
    } else {
        return true;
    }
}

function checkEndYearIntegerAcademicCourse(field, minValue, maxValue) {
    const name = "fin";
    if ((toret = checkInteger(field, minValue, maxValue, name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('end-year-div', name, toret, field);
        return false;
    }
}

function checkEndYearEmptyAcademicCourse(field) {
    if (field.value.length > 0) {
        return checkEndYearIntegerAcademicCourse(field, 2000, 9999);
    } else {
        return true;
    }
}

function checkYearsAcademicCourse(field1, field2) {
    const name = "diferencia"
    if ((toret = checkStartYearBeforeEndYearAcademicCourse(field1, field2)) === "" &&
        (toret = checkOneYearPeriodAcademicCourse(field1, field2)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('end-year-div', name, toret, field2);
        return false;
    }
}

function checkOneYearPeriodAcademicCourse(field1, field2) {
    if ((parseInt(field1.value) + 1) === parseInt(field2.value)) {
        return ""
    } else {
        return "La diferencia debe ser igual a 1 año";
    }
}

function checkStartYearBeforeEndYearAcademicCourse(field1, field2) {
    if (field1.value >= field2.value) {
        console.log(field1);
        console.log(field2);
        return "El año de finalización debe ser mayor que el de comienzo";
    } else {
        return "";
    }

}

function checkYearsAbbreviate(field) {
    const name = "abreviatura";
    if (field.value.length > 0) {
        return checkTextAbbreviate(field, name);
    } else {
        return true;
    }
}

function checkTextAbbreviate(field, name) {
    var i;
    for (i = 0; i < field.value.length; i++) {
        if (/[^/0123456789]/.test(field.value.charAt(i))) {
            toret = 'El atributo ' + name + ' contiene algún carácter no válido: %' + field.value.charAt(i) + '%.';
            showMessage('end-abbreviate-div', name, toret, field);
            return false;
        }
    }
    deleteMessage(name);
    return true;

}

function areAcademicCourseFieldsCorrect() {
    form = $('#academicCourseForm')[0];
    if (checkStartYearEmptyAcademicCourse(form.elements[0]) && checkEndYearEmptyAcademicCourse(form.elements[1]) &&
        checkYearsAcademicCourse(form.elements[0], form.elements[1])) {
        return true;
    } else {
        return false;
    }
}

function areAcademicCourseEditFieldsCorrect() {
    form = $('#academicCourseEditForm')[0];
    if (checkStartYearEmptyAcademicCourse(form.elements[2]) && checkEndYearEmptyAcademicCourse(form.elements[3]) &&
        checkYearsAcademicCourse(form.elements[2], form.elements[3])) {
        return true;
    } else {
        return false;
    }
}

function areAcademicCourseSearchFieldsCorrect() {
    form = $('#academicCourseSearchForm')[0];
    if (checkStartYearEmptyAcademicCourse(form.elements[1]) && checkEndYearEmptyAcademicCourse(form.elements[2]) &&
        checkYearsAbbreviate(form.elements[0])) {
        return true;
    } else {
        return false;
    }
}
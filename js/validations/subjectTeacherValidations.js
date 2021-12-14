function checkHoursSubjectTeacher(field) {
    const name = "horas";
    if ((value = checkEmpty(field, name)) === "" && (value = checkInteger(field,0, 24, name)) === ""
        && (value = checkLength(field,'2', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('hours-div', name, value);
        return false;
    }
}

function areSubjectTeacherFieldsCorrect() {
    const form = $('#subjectTeacherForm')[0];
    if(checkHoursSubjectTeacher(form.elements[1])) {
        return true;
    } else {
        return false;
    }
}
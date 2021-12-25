function checkNumStudents(field) {
    const name = "número de asistentes";
    const nameDiv = "numStudents"
    if ((result = checkEmpty(field, name)) === "" && (result = checkInteger(field,0, 999, name)) === ""
        && (result = checkLength(field,'3', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('num-students-div', nameDiv, result);
        return false;
    }
}

function checkAttendaceNumStudents(field) {
    if (field.value.length > 0) {
        return checkNumStudents(field);
    } else {
        return false;
    }
}

function areAttendanceFieldsCorrect() {
    const form = $('#attendanceForm')[0];
    if(checkAttendaceNumStudents(form.elements[0])) {
        return true;
    } else {
        return false;
    }
}
function checkTotalHoursTutorial(field) {
    const name = "horas totales";
    const nameDiv = "total_horas";
    if ((toret = checkEmpty(field, name)) === "" && (toret = checkInteger(field,0, 10, name)) === ""
        && (toret = checkLength(field,'3', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('total-hours-div', nameDiv, toret, field);
        return false;
    }
}

function checkTotalHoursEmptyTutorial(field) {
    if (field.value.length > 0) {
        return checkTotalHoursTutorial(field);
    } else {
        return true;
    }
}

function areTutorialFieldsCorrect() {
    const form = $('#tutorialForm')[0];
    if(checkTotalHoursTutorial(form.elements[2])) {
        return true;
    } else {
        return false;
    }
}

function areTutorialSearchFieldsCorrect() {
    const form = $('#tutorialSearchForm')[0];
    if(checkTotalHoursEmptyTutorial(form.elements[2])
    ) {
        return true;
    } else {
        return false;
    }
}




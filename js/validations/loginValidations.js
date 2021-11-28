 /* Valida el login */
 function checkLogin(field) {
     const name = "login";
     if ((result = checkEmpty(field, name)) === "" && (result = checkWhiteSpaces(field, name)) === ""
         && (result = checkLength(field,'9', name)) === "" && (result = checkText(field,'9', name)) === "") {
         deleteMessage(name);
         return true;
     } else {
         showMessage('login', name, result);
         return false;
     }
 }

 /* Valida la contraseña */
 function checkPassword(field) {
     const name = "contraseña";
     if ((result = checkEmpty(field, name)) === "" && (result = checkWhiteSpaces(field, name)) === ""
         && (result = checkLength(field,'20', name)) === "" && (result = checkText(field,'20', name)) === "") {
         deleteMessage(name);
         return true;
     } else {
         showMessage('password', name, result);
         return false;
     }
 }

 function checkPasswordUser(field) {
     const name = "password1";
     if ((result = checkEmpty(field, name)) === "" && (result = checkWhiteSpaces(field, name)) === ""
         && (result = checkLength(field,'20', name)) === "" && (result = checkText(field,'20', name)) === "") {
         deleteMessage(name);
         return true;
     } else {
         showMessage('password-div', name, result);
         return false;
     }
 }

 function checkPasswordUser(field) {
     const name = "contraseña";
     if ((result = checkEmpty(field, name)) === "" && (result = checkWhiteSpaces(field, name)) === ""
         && (result = checkLength(field,'20', name)) === "" && (result = checkText(field,'20', name)) === "") {
         deleteMessage(name);
         return true;
     } else {
         showMessage('password-div', name, result);
         return false;
     }
 }

function checkEmptyPassword(field) {
    if (field.value.length > 0) {
        return checkPasswordUser(field);
    } else {
        return true;
    }
}

function checkConfirmPassword(field) {
    const name = "confirmar contraseña";
    nameDiv = "confirmation";
    password = $('#password1').val();
    if ((value = checkEmpty(field, name)) === "" && (value = checkWhiteSpaces(field, name)) === ""
        && (value = checkLength(field,'20', name)) === "" && (value = checkText(field,'20', name)) === "") {
        if(password !== field.value) {
            showMessage('confirm-password-div', nameDiv, "Las contraseñas no coinciden.", field);
        } else {
            deleteMessage(nameDiv);
            return true;
        }
    } else {
        showMessage('confirm-password-div', nameDiv, value);
        return false;
    }
}

function checkConfirmPasswordEmpty(field) {
    if (field.value.length > 0) {
        return checkConfirmPassword(field);
    } else {
        return true;
    }
}

 /* Valida el login */
 function validateLogin() {
     const form = $('#loginForm')[0];
     return (checkLogin(form.elements[0]) && checkPassword(form.elements[1]));
 }

function checkDniUser(field) {
    const name = "dni";
    if ((value = checkEmpty(field, name)) === "" && (value = checkWhiteSpaces(field, name)) === ""
        && (value = checkLength(field,'9', name)) === "" && (value = checkText(field,'9', name)) === "" &&
        (value = checkDni(field, name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('dni-div', name, value);
        return false;
    }
}

function checkName(field) {
    const name = "nombre";
    if ((value = checkEmpty(field, name)) === "" && (value = checkLength(field,'30', name)) === ""
        && (value = checkText(field,'30', name)) === "" && (value = checkAlphabetical(field,'30', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('name-div', name, value);
        return false;
    }
}

function checkSurname(field) {
    const name = "apellido";
    if ((value = checkEmpty(field, name)) === "" && (value = checkLength(field,'50', name)) === ""
        && (value = checkText(field,'50', name)) === "" && (value = checkAlphabetical(field,'50', name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('surname-div', name, value);
        return false;
    }
}

function checkEmailUser(field) {
    const name = "email";
    if ((value = checkEmpty(field, name)) === "" && (value = checkLength(field,'40', name)) === ""
        && (value = checkText(field,'40', name)) === "" && (value = checkEmail(field, name)) === "") {
        deleteMessage(name);
        return true;
    } else {
        showMessage('email-div', name, value);
        return false;
    }
}

function checkAddress(field) {
    const name = "dirección";
    nameDiv = "direccion";
    if ((value = checkEmpty(field, name)) === "" && (value = checkLength(field,'60', name)) === ""
        && (value = checkText(field,'60', name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('address-div', nameDiv, value);
        return false;
    }
}

function checkTelephone(field) {
    const name = "teléfono";
    nameDiv = "telefono";
    if ((value = checkEmpty(field, name)) === "" && (value = checkLength(field,'11', name)) === ""
        && (value = checkTelf(field, name)) === "") {
        deleteMessage(nameDiv);
        return true;
    } else {
        showMessage('telephone-div', nameDiv, value);
        return false;
    }
}

function areUserEditFieldsCorrect() {
    const form = $('#userEditForm')[0];
    if(checkLogin(form.elements[0]) && checkEmptyPassword(form.elements[1]) &&
    checkConfirmPasswordEmpty(form.elements[2]) && checkDniUser(form.elements[3]) &&
    checkName(form.elements[4]) && checkSurname(form.elements[5]) &&
    checkEmailUser(form.elements[6]) && checkAddress(form.elements[7]) &&
    checkTelephone(form.elements[8])) {
        return true;
    } else {
        return false;
    }
}

function areUserFieldsCorrect() {
    const form = $('#userForm')[0];
    if(checkLogin(form.elements[0]) && checkPassword(form.elements[1]) &&
    checkConfirmPassword(form.elements[2]) && checkDniUser(form.elements[3]) &&
    checkName(form.elements[4]) && checkSurname(form.elements[5]) &&
    checkEmailUser(form.elements[6]) && checkAddress(form.elements[7]) &&
    checkTelephone(form.elements[8])) {
        return true;
    } else {
        return false;
    }
}
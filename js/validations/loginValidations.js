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

 /* Valida el login */
 function validateLogin() {
     const form = $('#loginForm')[0];
     return (checkLogin(form.elements[0]) && checkPassword(form.elements[1]));
 }
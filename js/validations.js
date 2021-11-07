/* Comprueba si existen espacios en blanco */
function checkWhiteSpaces(field, name) {
    return (/[\s]/.test(field.value)) ? 'El atributo ' + name + ' no puede tener espacios en blanco.' : "";
}

/* Comprueba que es un texto válido */
function checkText(field, size, name) {
    var i;
    for (i = 0; i < size; i++) {
        if (/[^!"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~ñáéíóúÑÁÉÍÓÚüÜ ]/.test(field.value.charAt(i))) {
            return 'El atributo ' + name + ' contiene el carácter no válido: %' + field.value.charAt(i) + '%.';
        }
    }
    return "";
}

/* Comprueba la longitud */
function checkLength(field, size, name) {
    return (field.value.length > size) ? 'El atributo ' + name + ' puede tener una longitud máxima de %' + size + '% caracteres.' : "";
}

/* Comprueba si la cadena es vacía */
function checkEmpty(field, name) {
    return (field.value == null || field.value.length == 0 || /^\s+$/.test(field.value)) ? "El atributo " + name + " no puede estar vacío." : "";
}

/* Muestra un mensaje */
function showMessage(parentNode, name, message) {
    parentNode = '#' + parentNode;
    node = '#message-error-' + name;
    if($(node).length)
    {
        $(node).html("<p data-translate='" + message + "'></p>");
        translatePage();
    } else {
        $('<div id="message-error-' + name + '" class="message-error"><p data-translate="' + message + '"></p></div>').appendTo(parentNode);
        translatePage();
    }
}

/* Elimina el mensaje */
function deleteMessage(node) {
    node = '#message-error-' + node;
    if($(node).length) {
        $(node).remove();
    }
}

<?php
class UserAddView {

    function __construct(){
        $this->render();
    }

    function render() {
                        ?>
<!DOCTYPE html>
<html>
<head>
    <script src="../js/validations/loginValidations.js"></script>
</head>
<body>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
            <h2 data-translate="Añadir usuario"></h2>
            <a class="btn btn-primary" role="button" href="../controllers/userController.php" data-translate="Volver"></a>
        </div>
        <form id="userForm" action='../controllers/userController.php?action=add' method='POST' onsubmit="return areUserFieldsCorrect()">
            <div id="login-div" class="form-group">
                <label for="login" data-translate="Login"></label>
                <input type="text" class="form-control" id="login" name="login" max-length="9" data-translate="Nombre de usuario"
                required oninput="checkLogin(this);">
            </div>

            <div id="password-div" class="form-group">
                <label for="password1" data-translate="Contraseña"></label>
                <input type="password" class="form-control" id="password1" name="password1" max-length="20" data-translate="Contraseña"
                required oninput="checkPassword(this);" >
            </div>

            <div id="confirm-password-div" class="form-group">
                <label for="password2" data-translate="Confirmar contraseña"></label>
                <input type="password" class="form-control" id="password2" max-length="20" data-translate="Confirmar contraseña"
                       required oninput="checkConfirmPassword(this);">
            </div>

            <div id="dni-div" class="form-group">
                <label for="dni" data-translate="DNI"></label>
                <input type="text" class="form-control" id="dni" name="dni" max-length="9" data-translate="DNI"
                required oninput="checkDniUser(this);">
            </div>

            <div id="name-div" class="form-group">
                <label for="name" data-translate="Nombre"></label>
                <input type="text" class="form-control" id="nombre" name="nombre" max-length="30" data-translate="Nombre"
                       required oninput="checkName(this);">
            </div>

            <div id="surname-div" class="form-group">
                <label for="surname" data-translate="Apellido"></label>
                <input type="text" class="form-control" id="apellido" name="apellido" max-length="50" data-translate="Apellido"
                required oninput="checkSurname(this);">
            </div>

            <div id="email-div" class="form-group">
                <label for="email" data-translate="Email"></label>
                <input type="email" class="form-control" id="email" name="email" max-length="40" data-translate="Email"
                       required oninput="checkEmailUser(this);">
            </div>

            <div id="address-div" class="form-group">
                <label for="address" data-translate="Dirección">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" max-length="60" data-translate="Dirección"
                       required oninput="checkAddress(this);">
            </div>

            <div id="telephone-div" class="form-group">
                <label for="telephone"  data-translate="Teléfono"></label>
                <input type="text" class="form-control" id="telefono" name="telefono" max-length="11" data-translate="Teléfono"
                required oninput="checkTelephone(this);">
            </div>

            <button id="btn-add-user" name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
        </form>
    </main>
</body>
</html>
<?php
    }
}
?>
<head>
    <link rel="stylesheet" href="../css/login.css" />
    <script src="../js/validations/loginValidations.js"></script>
</head>
<div class="sidenav">
    <div class="login-main-text">
        <h2>CHP<br> Control Horario de Profesorado</h2>
    </div>
</div>
<div class="main">
    <div class="col-md-7 col-sm-12">
        <div class="login-form">
            <form id="loginForm" name="formLogin" action='../controllers/loginController.php' method="post" onsubmit="return validateLogin()">
                <div id="login" class="form-group">
                     <label data-translate="Nombre de usuario"></label>
                     <input type="text" class="form-control" id="login" name="login" maxlength="9" size ="9" data-translate="Nombre de usuario"
                            oninput="checkLogin(this);">
                </div>
                <div id="password" class="form-group">
                    <label data-translate="Contraseña"></label>
                    <input type="password" class="form-control" id="password" name="password" maxlength="20" size ="20" data-translate="Contraseña"
                        oninput="checkPassword(this);">
                </div>
                <button type="submit" name="action" value="login-user" class="btn btn-black">
                    <p data-translate="Iniciar sesión"></p>
                </button>
            </form>
        </div>
    </div>
    <li class="nav-item row flags">
        <a href="javascript:setCookie('language-selected', 'en'); translatePage();"><img class="flag" src="../assets/english.jpg"></a>
        <a href="javascript:setCookie('language-selected', 'es'); translatePage();"><img class="flag" src="../assets/espanol.png"></a>
        <a href="javascript:setCookie('language-selected', 'gl'); translatePage();"><img class="flag" src="../assets/gallego.png"></a>
    </li>
</div>

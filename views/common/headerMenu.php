
    <!-- Barra de herramientas / Menú -->
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a id="button-sidebar" class="navbar-brand col-sm-3 col-md-2 mr-0" href="../index.php">
            <button id="button-show-sidebar" class="navbar-toggler" type="button" onclick="showSidebar()">
                <span class="navbar-toggler-icon"></span>
            </button>
            CHP
        </a>
        <!-- Acciones en md y lg -->
        <ul class="navbar-nav px-1 d-none d-sm-block">
            <div class="row margin-right">
                <!-- Language -->
                <li class="nav-item text-nowrap row flags mr-2">
                    <a href="javascript:setCookie('language-selected', 'gl'); translatePage();"><img class="flag" src="../assets/gallego.png"></a>
                    <a href="javascript:setCookie('language-selected', 'es'); translatePage();"><img class="flag" src="../assets/espanol.png"></a>
                    <a href="javascript:setCookie('language-selected', 'en'); translatePage();"><img class="flag" src="../assets/english.jpg"></a>
                </li>

                <!-- Logout -->
                <li class="nav-item text-nowrap">
                    <a class="btn btn-danger btn-logout" href="../utils/logout.php">
                        <p data-translate="Cerrar sesión"></p> <i class="bi bi-box-arrow-left"></i>
                    </a>
                </li>
            </div>
        </ul>
        <!-- Acciones en small -->
        <ul class="navbar-nav px-1 d-block d-sm-none">
            <div class="row margin-right">
                <li class="nav-item dropdown mr-2 ml-2 bg-dark">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        <p data-translate="Más"></p>
                    </a>
                    <div class="dropdown-menu  bg-dark">
                        <a href="javascript:setCookie('language-selected', 'gl'); translatePage();" class="text-decoration-none"><img class="flag" src="../assets/gallego.png"> <i class="text-white" data-translate="Gal"></i></a></br>
                        <a href="javascript:setCookie('language-selected', 'es'); translatePage();" class="text-decoration-none mt-1"><img class="flag" src="../assets/espanol.png"> <i class="text-white" data-translate="Esp"></i></a></br>
                        <a href="javascript:setCookie('language-selected', 'en'); translatePage();" class="text-decoration-none mt-1"><img class="flag" src="../assets/english.jpg"> <i class="text-white" data-translate="Ing"></i></a></br>
                    </div>
                </li>
                <li class="nav-item text-nowrap">
                    <a class="btn btn-danger" href="../utils/logout.php" role="button">
                        <i class="bi bi-box-arrow-left"></i>
                    </a>
                </li>
            </div>
        </ul>
    </nav>

    <!-- Menú lateral -->
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <nav id="sidebar-menu" class="d-md-block bg-light sidebar sidebar-expanded">
                    <div id="sidebar-contents" class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <?php
                        		if (checkPermission("usuario", "SHOWALL") ||
                        			checkPermission("Permission", "SHOWALL" ||
                        			checkPermission("FuncAction", "SHOWALL") ||
                        			checkPermission("Action", "SHOWALL") ||
                        			checkPermission("Functionality", "SHOWALL") ||
                        			checkPermission("Role", "SHOWALL") ||
                        			checkPermission("UserRole", "SHOWALL"))) {
                        	?>
                            <li class="nav-item">
                                <!-- Gestión de usuarios -->
                                <a class="nav-link nav-collapse" data-toggle="collapse" aria-expanded="false"
                                   aria-controls="collapseUsers" href="#collapseUsers">
                                    <span class="fas fa-users"></span>
                                    <p data-translate="Gestión básica"></p>
                                </a>
                                <!-- Submenús -->
                                <ul class="flex-column collapse items-collapsed" id="collapseUsers">
                                    <?php
                                         if (checkPermission("usuario", "SHOWALL")) {
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../controllers/userController.php">
                                            <p data-translate="Usuarios"></p>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php
                                        if (checkPermission("Permission", "SHOWALL")) {
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../controllers/permissionController.php">
                                            <p data-translate="Permisos"></p>
                                        </a>
                                     </li>
                                     <?php } ?>
                                     <?php
                                        if (checkPermission("Role", "SHOWALL")) {
                                     ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../controllers/roleController.php">
                                            <p data-translate="Roles"></p>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            <!-- Gestión de acciones -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/actionController.php">
                                    <span class="far bi-tools"></span>
                                    <p data-translate="Gestión de acciones"></p>
                                </a>
                            </li>
                            <!-- Gestión de funcionalidades -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/functionalityController.php">
                                    <span class="far bi-box-seam"></span>
                                    <p data-translate="Gestión de funcionalidades"></p>
                                </a>
                            </li>
                            <!-- Gestión de cursos academicos -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/academicCourseController.php">
                                    <span class="far bi-calendar2"></span>
                                    <p data-translate="Gestión de cursos académicos"></p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </nav>
        </div>
    </div>



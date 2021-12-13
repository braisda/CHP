
    <!-- Barra de herramientas / Menú -->
    <nav class="navbar fixed-top flex-md-nowrap p-0 shadow">
        <button id="button-show-sidebar" class="navbar-toggler mt-1" data-toggle="collapse" type="button" onclick="showSidebar()">
            <i class="navbar-toggler-icon bi bi-justify"></i>
        </button>        
        <a id="button-sidebar" class="text-white navbar-brand col-sm-3 col-md-2 mr-0" href="../index.php">CHP</a>
        <!-- Acciones en md y lg -->
        <ul class="navbar-nav px-1 d-none d-sm-block">
            <div class="row margin-right">
                <!-- Language -->
                <li class="nav-item text-nowrap row flags mr-2">
                    <a href="javascript:setCookie('language-selected', 'gl'); translatePage();"><img height="25" width="30" class="flag" src="../assets/gallego.png"></a>
                    <a href="javascript:setCookie('language-selected', 'es'); translatePage();"><img height="25" width="30" class="flag" src="../assets/espanol.png"></a>
                    <a href="javascript:setCookie('language-selected', 'en'); translatePage();"><img height="25" width="30" class="flag" src="../assets/english.jpg"></a>
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
                    <a class="nav-link dropdown-toggle text-white p-1" href="#" id="navbardrop" data-toggle="dropdown">
                        <p data-translate="Más"></p>
                    </a>
                    <div class="dropdown-menu  bg-dark">
                        <a href="javascript:setCookie('language-selected', 'gl'); translatePage();" class="text-decoration-none"><img height="25" width="30" class="flag" src="../assets/gallego.png"> <i class="text-white" data-translate="Gal"></i></a></br>
                        <a href="javascript:setCookie('language-selected', 'es'); translatePage();" class="text-decoration-none mt-1"><img height="25" width="30" class="flag" src="../assets/espanol.png"> <i class="text-white" data-translate="Esp"></i></a></br>
                        <a href="javascript:setCookie('language-selected', 'en'); translatePage();" class="text-decoration-none mt-1"><img height="25" width="30" class="flag" src="../assets/english.jpg"> <i class="text-white" data-translate="Ing"></i></a></br>
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
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span data-translate="Gestiones"></span>
                        </h6>
                        <ul class="nav flex-column">
                            <?php
                        		if (checkPermission("usuario", "SHOWALL") ||
                        			checkPermission("Permission", "SHOWALL" ||
                        			checkPermission("FuncAccion", "SHOWALL") ||
                        			checkPermission("accion", "SHOWALL") ||
                        			checkPermission("Functionality", "SHOWALL") ||
                        			checkPermission("Role", "SHOWALL") ||
                        			checkPermission("UsuarioRole", "SHOWALL"))) {
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
                            <?php
                                if (checkPermission("accion", "SHOWALL")) {
                            ?>
                            <!-- Gestión de acciones -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/actionController.php">
                                    <span class="far bi-tools"></span>
                                    <p data-translate="Gestión de acciones"></p>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                                if (checkPermission("Functionality", "SHOWALL")) {
                            ?>
                            <!-- Gestión de funcionalidades -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/functionalityController.php">
                                    <span class="far bi-box-seam"></span>
                                    <p data-translate="Gestión de funcionalidades"></p>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                                if (checkPermission("Academiccurso", "SHOWALL")) {
                            ?>
                            <!-- Gestión de cursos academicos -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/academicCourseController.php">
                                    <span class="far bi-calendar2"></span>
                                    <p data-translate="Gestión de cursos académicos"></p>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                                if (checkPermission("centro", "SHOWALL")) {
                            ?>
                            <!-- Gestión de centros -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/centerController.php">
                                    <span class="far bi-house"></span>
                                    <p data-translate="Gestión de centros"></p>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                                if (checkPermission("universidad", "SHOWALL")) {
                            ?>
                            <!-- Gestión de cursos universidades -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/universityController.php">
                                    <span class="far bi-bank"></span>
                                    <p data-translate="Gestión de universidades"></p>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                                if (checkPermission("grado", "SHOWALL")) {
                            ?>
                            <!-- Gestión de titulaciones -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/degreeController.php">
                                    <span class="far bi-stickies"></span>
                                    <p data-translate="Gestión de titulaciones"></p>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                                if (checkPermission("profesor", "SHOWALL")) {
                            ?>
                            <!-- Gestión de profesores -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/teacherController.php">
                                    <span class="far bi-person-fill"></span>
                                    <p data-translate="Gestión de profesores"></p>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                                if (checkPermission("tutoria", "SHOWALL")) {
                            ?>
                            <!-- Gestión de tutorias -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/tutorialController.php">
                                    <span class="far bi-info-square"></span>
                                    <p data-translate="Gestión de tutorías"></p>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                                if (checkPermission("departamento", "SHOWALL")) {
                            ?>
                            <!-- Gestión de departamentos -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/departmentController.php">
                                    <span class="far bi-inboxes"></span>
                                    <p data-translate="Gestión de departamentos"></p>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                                if (checkPermission("materia", "SHOWALL")) {
                            ?>
                            <!-- Gestión de materias -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/subjectController.php">
                                    <span class="far bi-book"></span>
                                    <p data-translate="Gestión de materias"></p>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                                if (checkPermission("edificio", "SHOWALL")) {
                            ?>
                            <!-- Gestión de edificios -->
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/buildingController.php">
                                    <span class="far bi-building"></span>
                                    <p data-translate="Gestión de edificios"></p>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
						<?php
							if (checkPermission("pda", "SHOWALL")) {
						?>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span data-translate="Documentos"></span>
                        </h6>
                        <ul class="nav flex-column mb-2">
						<?php
							if (checkPermission("pda", "SHOWALL")) {
						?>
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/pdaController.php">
                                    <span class="fas fa-file-alt"></span>
                                    <p data-translate="PDA"></p>
                                </a>
                            </li>
                        <?php } ?>
                        </ul>
						<?php } ?>
                    </div>
                </nav>
            </nav>
        </div>
    </div>
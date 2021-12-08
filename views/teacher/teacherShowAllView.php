<?php
include_once '../utils/CheckPermission.php';

class TeacherShowAllView {

    private $teachers;
    private $pageItems;
    private $page;
    private $totalTeachers;
    private $totalPages;
    private $search;

    function __construct($teachersData, $pageItems = NULL, $page = NULL, $totalTeachers = NULL, $search = NULL)
    {
        $this->teachers = $teachersData;
        $this->pageItems = $pageItems;
        $this->page = $page;
        $this->totalTeachers = $totalTeachers;
        $this->totalPages = ceil($totalTeachers / $itemsPerPage);
        $this->search = $search;
        $this->render();
    }

    function render()
    {
        ?>
<!DOCTYPE html>
<html>
<head>
    <script src="../js/validations/teacherValidations.js"></script>
    <script src="../js/validations/loginValidations.js"></script>
</head>
<body>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
            <h2 data-translate="Listado de profesores"></h2>
            <!-- Search -->
            <a class="btn btn-primary button-specific-search" data-toggle="modal" data-target="#searchModal" role="button">
                <span class="text-white" data-feather="search"></span>
                <p class="btn-show-view text-white" data-translate="Buscar"></p>
            </a>
            <!-- Modal -->
            <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><p class="btn-show-view" data-translate="Búsqueda avanzada"></p></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="row" id="searchTeacher" action='../controllers/teacherController.php?action=search' method='POST'>
                                <div id="name-div" class="form-group col-12">
                                    <label for="name" data-translate="Nombre"></label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" data-translate="Nombre" max-length="30" oninput="checkName(this);">
                                </div>

                                 <div id="login" class="form-group col-12">
                                    <label for="login" data-translate="Login"></label>
                                    <input type="text" class="form-control" id="login" name="login" max-length="9" data-translate="Login" oninput="checkLogin(this);">
                                </div>

                                  <div id="dedication-div" class="form-group col-12">
                                     <label for="dedicacion" data-translate="Dedicación"></label>
                                     <input type="text" class="form-control" id="dedicacion" name="dedicacion" data-translate="Dedicación" maxlength="4" oninput="checkDedicationTeacher(this)">
                                 </div>

                                <div id="dni-div" class="form-group col-12">
                                    <label for="dni" data-translate="DNI"></label>
                                    <input type="text" class="form-control" id="dni" name="dni" max-length="9" data-translate="DNI">
                                </div>
                            </form>
                        </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-translate="Volver"></button>
                                <button type="button" class="btn btn-primary" name="submit" type="submit" data-translate="Buscar" onclick="form_submit()"></button>
                            </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($this->search)){ ?>
                <a class="btn btn-primary mr-1" role="button" href="../controllers/teacherController.php">
                    <p data-translate="Volver"></p>
                </a>
            <?php } else {
                if (checkPermission("profesor", "ADD")) { ?>
                    <a class="btn btn-success" role="button" href="../controllers/teacherController.php?action=add">
                        <span data-feather="plus"></span>
                        <p data-translate="Añadir profesor"></p>
                    </a>
            <?php }} ?>
        </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="DNI"></label></th>
                        <th><label data-translate="Nombre"></label></th>
                        <th><label data-translate="Nombre de usuario"></label></th>
                        <th><label data-translate="Dedicación"></label></th>
                        <th><label data-translate="Despacho"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->teachers)): ?>
                    <tbody>
                    <?php foreach ($this->teachers as $teacher): ?>
                        <tr>
                            <td><?php echo $teacher->getUsuario()->getDNI() ;?></td>
                            <td><?php echo $teacher->getUsuario()->getNombre() . " " . $teacher->getUsuario()->getApellido() ;?></td>
                            <td><?php echo $teacher->getUsuario()->getId() ;?></td>
                            <td><?php echo $teacher->getDedicacion() ;?></td>
                            <?php if(!empty($teacher->getEspacio())): ?>
                            <td><?php echo $teacher->getEspacio()->getNombre() ;?></td>
                            <?php else: ?>
                            <td data-translate="No asignado"></td>
                            <?php endif; ?>
                            <td class="row">
                                <?php if (checkPermission("profesor", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/teacherController.php?action=show&id=<?php echo $teacher->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                    if (checkPermission("profesor", "EDIT")) { ?>
                                    <a href="../controllers/teacherController.php?action=edit&id=<?php echo $teacher->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                    if (checkPermission("profesor", "DELETE")) { ?>
                                    <a href="../controllers/teacherController.php?action=delete&id=<?php echo $teacher->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún profesor">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->pageItems, $this->page, $this->totalTeachers, "teacher") ?>

            </div>
        </main>

        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
</body>
<script type="text/javascript">
    function form_submit() {
        document.getElementById("searchTeacher").submit();
    }
</script>
</html>
<?php
    }
}
?>
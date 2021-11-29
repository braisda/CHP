<?php

class AcademicCourseShowAllView
{
    private $academicCourses;
    private $itemsPerPage;
    private $currentPage;
    private $totalAcademicCourses;
    private $totalPages;
    private $search;

    function __construct($academicCoursesData, $itemsPerPage = NULL, $currentPage = NULL, $totalAcademicCourses = NULL,
                         $search = NULL)
    {
        $this->academicCourses = $academicCoursesData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalAcademicCourses = $totalAcademicCourses;
        $this->totalPages = ceil($totalAcademicCourses / $itemsPerPage);
        $this->search = $search;
        $this->render();
    }

    function render()
    {
        ?>
<!DOCTYPE html>
    <html>
    <head>
        <script src="../js/validations/academicCourseValidations.js"></script>
    </head>
    <body>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 class="h2" data-translate="Listado de Cursos Académicos"></h2>
                <!-- Search -->
                <a class="btn btn-primary button-specific-search" data-toggle="modal" data-target="#searchModal" role="button">
                    <span data-feather="search"></span>
                    <p class="btn-show-view" data-translate="Buscar"></p>
                </a>
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
                                <form class="row" id="searchAcademicCourse" action='../controllers/academicCourseController.php?action=search' method='POST'>
                                    <div class="form-group col-12">
                                        <label for="nombre" data-translate="Identificador"></label>
                                        <input type="text" class="form-control" id="nombre" name="nombre">
                                    </div>
                                    <div id="start-year-div" class="form-group col-12">
                                        <label for="anoinicio" data-translate="Año de inicio"></label>
                                        <input type="number" min="2000" max="9999" class="form-control" id="anoinicio" name="anoinicio"
                                               oninput="checkStartYearEmptyAcademicCourse(this)">
                                    </div>
                                    <div id="end-year-div" class="form-group col-12">
                                        <label for="anofin" data-translate="Año de fin"></label>
                                        <input type="number" min="2000" max="9999" class="form-control" id="anofin" name="anofin"
                                              oninput="checkEndYearEmptyAcademicCourse(this)">
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
                <?php if (!empty($this->search)): ?>
                    <a class="btn btn-primary" role="button" href="../controllers/academicCourseController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (checkPermission("Academiccurso", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../controllers/academicCourseController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir curso académico"></p>
                        </a>
                    <?php endif; endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Identificador"></th>
                        <th><label data-translate="Año de inicio"></th>
                        <th><label data-translate="Año de fin"></th>
                        <th><label data-translate="Acciones"></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->academicCourses)): ?>
                    <tbody>
                    <?php foreach ($this->academicCourses as $academicCourse): ?>
                        <tr>
                            <td><?php echo $academicCourse->getNombre() ?></td>
                            <td><?php echo $academicCourse->getAnoinicio() ?></td>
                            <td><?php echo $academicCourse->getAnofin() ?></td>
                            <td class="row">
                                <?php if (checkPermission("Academiccurso", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/academicCourseController.php?action=show&id=<?php echo $academicCourse->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("Academiccurso", "EDIT")) { ?>
                                    <a href="../controllers/academicCourseController.php?action=edit&id=<?php echo $academicCourse->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("Academiccurso", "DELETE")) { ?>
                                    <a href="../controllers/academicCourseController.php?action=delete&id=<?php echo $academicCourse->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún curso académico">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalAcademicCourses,
                    "AcademicCourse") ?>

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
        document.getElementById("searchAcademicCourse").submit();
    }
</script>
        <?php
    }
}

?>
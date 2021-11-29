<?php

class AcademicCourseShowAllView
{
    private $academicCourses;
    private $itemsPerPage;
    private $currentPage;
    private $totalAcademicCourses;
    private $totalPages;
    private $stringToSearch;

    function __construct($academicCoursesData, $itemsPerPage = NULL, $currentPage = NULL, $totalAcademicCourses = NULL,
                         $stringToSearch = NULL)
    {
        $this->academicCourses = $academicCoursesData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalAcademicCourses = $totalAcademicCourses;
        $this->totalPages = ceil($totalAcademicCourses / $itemsPerPage);
        $this->stringToSearch = $stringToSearch;
        $this->render();
    }

    function render()
    {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 class="h2" data-translate="Listado de Cursos Académicos"></h2>
                <!-- Search -->
                <form class="row" action='../controllers/academicCourseController.php' method='POST'>
                    <div class="col-10 pr-1">
                        <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                    </div>
                    <div class="col-2 pl-0">
                        <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                    </div>
                </form>

                <?php if (!empty($this->stringToSearch)): ?>
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
        <?php
    }
}

?>
<?php

class UniversityShowAllView
{
    private $universities;
    private $academic_courses;
    private $users;
    private $itemsPerPage;
    private $currentPage;
    private $totalUniversities;
    private $searching;

    function __construct($universitiesData, $academic_coursesData, $usersData, $itemsPerPage = NULL, $currentPage = NULL, $totalUniversities = NULL, $toSearch = NULL, $searching = False)
    {
        $this->universities = $universitiesData;
        $this->academic_courses = $academic_coursesData;
        $this->users = $usersData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalUniversities = $totalUniversities;
        $this->searching = $searching;
        $this->render();
    }

    function render()
    {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de universidades"></h1>

                <!-- Search -->
                <a class="btn btn-primary button-specific-search" data-toggle="modal" data-target="#searchModal" role="button">
                    <span class="text-white" data-feather="search"></span>
                    <p class="btn-show-view text-white" data-translate="Buscar"></p>
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
                            <form class="row" id="searchUniversity" action='../controllers/universityController.php?action=search' method='POST'>
                                <div id="name-div" class="form-group col-12">
                                    <label for="name" data-translate="Nombre"></label>
                                    <input type="text" class="form-control" id="name" name="name" data-translate="Nombre"
                                        required maxlength="30" oninput="checkNameEmptyUniversity(this);">
                                </div>
                                <div class="form-group col-12">
                                    <label for="academic_course_id" data-translate="Curso académico"></label>
                                    <select class="form-control" id="academic_course_id" name="academic_course_id" ?>
                                        <option value="" data-translate="Seleccione"></option>
                                        <?php foreach ($this->academic_courses as $ac): ?>
                                            <option value="<?php echo $ac->getId() ?>"><?php echo $ac->getNombre() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label for="user_id" data-translate="Responsable"></label>
                                    <select class="form-control" id="user_id" name="user_id" ?>
                                        <option value="" data-translate="Seleccione"></option>
                                        <?php foreach ($this->users as $user): ?>
                                            <option value="<?php echo $user->getId() ?>"><?php echo $user->getNombre()." ".$user->getApellido() ?></option>
                                        <?php endforeach; ?>
                                    </select>
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

                <?php if ($this->searching): ?>
                    <a class="btn btn-primary" role="button" href="../controllers/universityController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (checkPermission("universidad", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../controllers/universityController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir universidad"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Nombre"></label></th>
                        <th><label data-translate="Curso académico"></label></th>
                        <th><label data-translate="Responsable"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->universities)): ?>
                    <tbody>
                    <?php foreach ($this->universities as $university): ?>
                        <tr>
                            <td><?php echo $university->getNombre() ;?></td>
                            <td><?php echo $university->getIdCursoAcademico()->getNombre() ;?></td>
                            <td><?php echo $university->getIdUsuario()->getNombre() . " " . $university->getIdUsuario()->getApellido() ;?></td>
                            <td class="row">
                                <?php if (checkPermission("universidad", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/universityController.php?action=show&id=<?php echo $university->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("universidad", "EDIT")) { ?>
                                    <a href="../controllers/universityController.php?action=edit&id=<?php echo $university->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("universidad", "DELETE")) { ?>
                                    <a href="../controllers/universityController.php?action=delete&id=<?php echo $university->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna universidad">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalUniversities,
                    "University") ?>

            </div>
        </main>

        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
        <script type="text/javascript">
            function form_submit() {
                document.getElementById("searchUniversity").submit();
            }
        </script>
        <?php
    }
}

?>

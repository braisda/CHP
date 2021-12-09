<?php

class DepartmentShowAllView
{
    private $depdepartments;
    private $teachers;
    private $itemsPerPage;
    private $currentPage;
    private $totalDepartments;
    private $searching;

    function __construct($departmentsData, $teachersData, $itemsPerPage = NULL, $currentPage = NULL, $totalDepartments = NULL, $searching = False)
    {
        $this->depdepartments = $departmentsData;
        $this->teachers = $teachersData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalDepartments = $totalDepartments;
        $this->searching = $searching;
        $this->render();
    }

    function render()
    {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de departamentos"></h1>

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
                            <form class="row" id="searchDepartment" action='../controllers/departmentController.php?action=search' method='POST'
                            onsubmit="areDepartmentSearchFieldsCorrect()">
                                <div id="code-div" class="form-group col-12">
                                    <label for="start_date" data-translate="Código"></label>
                                    <input type="text" max-length="30" class="form-control" id="code" name="code"
                                    oninput="checkCodeEmptyDepartment(this)">
                                </div>    
                                <div class="form-group col-12">
                                    <label for="teacher_id" data-translate="Profesor"></label>
                                    <select class="form-control" id="teacher_id" name="teacher_id" ?>
                                        <option value="" data-translate="Seleccione"></option>
                                        <?php foreach ($this->teachers as $t): ?>
                                            <option value="<?php echo $t->getId() ?>"><?php echo $t->getUsuario()->getLogin() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>  
                                <div id="name-div" class="form-group col-12">
                                    <label for="end_date" data-translate="Nombre"></label>
                                    <input type="text" max-length="30" class="form-control" id="name" name="name"
                                    oninput="checkNameEmptyDepartment(this)">
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
                    <a class="btn btn-primary" role="button" href="../controllers/departmentController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (checkPermission("departamento", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../controllers/departmentController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir departamento"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Código"></label></th>
                        <th><label data-translate="Profesor"></label></th>
                        <th><label data-translate="Nombre"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->depdepartments)): ?>
                    <tbody>
                    <?php foreach ($this->depdepartments as $department): ?>
                        <tr>
                            <td><?php echo $department->getCodigo() ;?></td>
                            <td><?php echo $department->getIdProfesor()->getUsuario()->getLogin() ;?></td>
                            <td><?php echo $department->getNombre() ;?></td>
                            <td class="row">
                                <?php if (checkPermission("departamento", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/departmentController.php?action=show&id=<?php echo $department->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("departamento", "EDIT")) { ?>
                                    <a href="../controllers/departmentController.php?action=edit&id=<?php echo $department->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("departamento", "DELETE")) { ?>
                                    <a href="../controllers/departmentController.php?action=delete&id=<?php echo $department->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún departamento">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalDepartments,
                    "department") ?>

            </div>
        </main>

        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
        <script type="text/javascript">
            function form_submit() {
                document.getElementById("searchDepartment").submit();
            }
        </script>
        <?php
    }
}

?>

<?php

class GroupShowAllView
{
    private $groups;
    private $subjects;
    private $itemsPerPage;
    private $currentPage;
    private $totalGroups;
    private $searching;

    function __construct($groupsData, $subjectsData, $itemsPerPage = NULL, $currentPage = NULL, $totalGroups = NULL, $searching = False)
    {
        $this->groups = $groupsData;
        $this->subjects = $subjectsData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalGroups = $totalGroups;
        $this->searching = $searching;
        $this->render();
    }

    function render()
    {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de grupos"></h1>

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
                            <form class="row" id="searchGroup" action='../controllers/groupController.php?action=search' method='POST'>
                                <div class="form-group col-12">
                                    <label for="subject_id" data-translate="Edificio"></label>
                                    <select class="form-control" id="subject_id" name="subject_id" ?>
                                        <option value="" data-translate="Seleccione"></option>
                                        <?php foreach ($this->subjects as $s): ?>
                                            <option value="<?php echo $s->getId() ?>"><?php echo $s->getCodigo() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="name-div" class="form-group col-12">
                                    <label for="name" data-translate="Nombre"></label>
                                    <input type="text" class="form-control" id="name" name="name">
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
                    <a class="btn btn-primary" role="button" href="../controllers/groupController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (checkPermission("grupo", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../controllers/groupController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir grupo"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Asignatura"></label></th>
                        <th><label data-translate="Nombre"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->groups)): ?>
                    <tbody>
                    <?php foreach ($this->groups as $group): ?>
                        <tr>
                            <td><?php echo $group->getIdmateria()->getCodigo() ;?> </td>
                            <td><?php echo $group->getNombre() ?></td>
                            <td class="row">
                                <?php if (checkPermission("grupo", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/groupController.php?action=show&id=<?php echo $group->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("grupo", "EDIT")) { ?>
                                    <a href="../controllers/groupController.php?action=edit&id=<?php echo $group->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("grupo", "DELETE")) { ?>
                                    <a href="../controllers/groupController.php?action=delete&id=<?php echo $group->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna grupo">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalGroups,
                    "group") ?>

            </div>
        </main>

        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
        <script type="text/javascript">
            function form_submit() {
                document.getElementById("searchGroup").submit();
            }
        </script>
        <?php
    }
}

?>

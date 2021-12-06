<?php

class ActionShowAllView
{
    private $actions;
    private $itemsPerPage;
    private $currentPage;
    private $totalPermissions;
    private $search;

    function __construct($actionsData, $itemsPerPage = NULL, $currentPage = NULL, $totalPermissions = NULL, $search = NULL)
    {
        $this->actions = $actionsData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalPermissions = $totalPermissions;
        $this->search = $search;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <script src="../js/validations/actionValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 class="h2" data-translate="Listado de acciones"></h2>
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
                            <form class="row" id="searchAction" action='../controllers/actionController.php?action=search' method='POST'>
                                <div id="name-div" class="form-group col-12">
                                    <label for="name" data-translate="Nombre"></label>
                                    <input type="text" class="form-control" id="name" name="name" maxlength="60"
                                    oninput="checkNameAction(this);">
                                </div>
                                <div id="description-div" class="form-group col-12">
                                    <label for="description" data-translate="Descripción"></label>
                                    <input type="text" class="form-control" id="description" name="description" maxlength="100"
                                    oninput="checkDescriptionAction(this);">
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
                    <a class="btn btn-primary mr-1" role="button" href="../controllers/actionController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (checkPermission("accion", "ADD")): ?>
                        <a class="btn btn-success" role="button" href="../controllers/actionController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir acción"></p>
                        </a>
                    <?php endif; endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th data-translate="Identificador"></th>
                        <th data-translate="Nombre"></th>
                        <th data-translate="Descripción"></th>
                        <th class="actions-row" data-translate="Acciones"></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->actions)): ?>
                    <tbody>
                    <?php foreach ($this->actions as $action): ?>
                        <tr>
                            <td><?php echo $action->getId() ?></td>
                            <td><?php echo $action->getNombre() ?></td>
                            <td><?php echo $action->getDescripcion() ?></td>
                            <td class="row">
                                <?php if (checkPermission("accion", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/actionController.php?action=show&id=<?php echo $action->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("accion", "EDIT")) { ?>
                                    <a href="../controllers/actionController.php?action=edit&id=<?php echo $action->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("accion", "DELETE")) { ?>
                                    <a href="../controllers/actionController.php?action=delete&id=<?php echo $action->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna acción">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalPermissions, "action"); ?>
            </div>
        </main>

        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace();
        </script>

        <script type="text/javascript">
            function form_submit() {
                document.getElementById("searchAction").submit();
            }
        </script>
        <?php
    }
}

?>
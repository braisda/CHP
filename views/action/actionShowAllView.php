<?php

class ActionShowAllView
{
    private $actions;
    private $itemsPerPage;
    private $currentPage;
    private $totalPermissions;
    private $stringToSearch;

    function __construct($actionsData, $itemsPerPage = NULL, $currentPage = NULL, $totalPermissions = NULL, $toSearch = NULL)
    {
        $this->actions = $actionsData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalPermissions = $totalPermissions;
        $this->stringToSearch = $toSearch;
        $this->render();
    }

    function render()
    {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 class="h2" data-translate="Listado de acciones"></h2>
                <!-- Search -->
                <form class="row" action='../controllers/actionController.php?action=search' method='POST'>
                    <div class="col-10 pr-1">
                        <input type="text" class="form-control" id="nombre" name="nombre" data-translate="Texto a buscar">
                    </div>
                    <div class="col-2 pl-0">
                        <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                    </div>
                </form>

                <?php if (!empty($this->stringToSearch)): ?>
                    <a class="btn btn-primary mr-1" role="button" href="../controllers/defaultController.php">
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

                <?php //new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalPermissions, "Action"); ?>
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
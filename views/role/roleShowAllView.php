<?php

class RoleShowAllView
{
    private $roles;
    private $itemsPerPage;
    private $currentPage;
    private $totalPermissions;
    private $stringToSearch;

    function __construct($rolesData, $itemsPerPage = NULL, $currentPage = NULL, $totalPermissions = NULL, $toSearch = NULL)
    {
        $this->roles = $rolesData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalPermissions = $totalPermissions;
        $this->stringToSearch = $toSearch;
        $this->render();
    }

    function render()
    {
        ?>
        
        <head>
            <link rel="stylesheet" href="../css/styles.css"/>
            <link rel="stylesheet" href="../css/table.css"/>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de Roles"></h1>
                <!-- Search -->
                <form class="row" action='../controllers/roleController.php?action=search' method='POST'>
                    <input type="text" class="form-control" id="nombre" name="nombre" data-translate="Texto a buscar">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </form>

                <?php //if (!empty($this->stringToSearch)): ?>
                    <a class="btn btn-primary mr-1" role="button" href="../controllers/defaultController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php //else:
                    //if (HavePermission("Action", "ADD")): ?>
                        <a class="btn btn-success" role="button" href="../controllers/roleController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir Rol"></p>
                        </a>
                    <?php //endif; endif; ?>
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
                    <?php if (!empty($this->roles)): ?>
                    <tbody>
                    <?php foreach ($this->roles as $role): ?>
                        <tr>
                            <td><?php echo $role->getId() ?></td>
                            <td><?php echo $role->getNombre() ?></td>
                            <td><?php echo $role->getDescripcion() ?></td>
                            <td class="row">
                                <?php // if (HavePermission("role", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/roleController.php?action=show&id=<?php echo $role->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php //}
                                //if (HavePermission("role", "EDIT")) { ?>
                                    <a href="../controllers/roleController.php?action=edit&id=<?php echo $role->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php //}
                                //if (HavePermission("role", "DELETE")) { ?>
                                    <a href="../controllers/roleController.php?action=delete&id=<?php echo $role->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php //} ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna funcinoalidad">. </p>
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
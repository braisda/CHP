<?php
include_once '../utils/CheckPermission.php';

class PermissionShowAllView {

    private $permissions;
    private $pageItems;
    private $page;
    private $totalPermissions;
    private $totalPages;
    private $stringToSearch;

    function __construct($permissionData, $pageItems = NULL, $page = NULL, $totalPermissions = NULL, $stringToSearch = NULL) {
        $this->permissions = $permissionData;
        $this->pageItems = $pageItems;
        $this->page = $page;
        $this->totalPermissions = $totalPermissions;
        $this->totalPages = ceil($totalPermissions / $itemsPerPage);
        $this->stringToSearch = $stringToSearch;
        $this->render();
    }

    function render()
        {
         ?>
<!DOCTYPE html>
<html id="home">
<head>
     <?php include_once '../views/common/head.php';?>
</head>
<body>
<?php include_once '../views/common/headerMenu.php'; ?>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
            <h2 data-translate="Listado de permisos"></h2>
            <!-- Search -->
            <form class="row" action='../controllers/permissionController.php' method='POST'>
                <div class="col-10 pr-1">
                    <input type="text" class="form-control" id="search" name="search" data-translate="Texto a buscar">
                </div>
                <div class="col-2 pl-0">
                    <button name="submit" type="submit" class="btn btn-primary" data-translate="Buscar"></button>
                </div>
            </form>

            <?php if (!empty($this->stringToSearch)){ ?>
                <a class="btn btn-primary mr-1" role="button" href="../controllers/defaultController.php">
                    <p data-translate="Volver"></p>
                </a>
            <?php } else {
                if (checkPermission("Permission", "ADD")) { ?>
                    <a class="btn btn-success" role="button" href="../controllers/permissionController.php?action=add">
                        <span data-feather="plus"></span>
                        <p data-translate="Añadir permiso"></p>
                    </a>
            <?php }} ?>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th data-translate="Rol"></th>
                        <th data-translate="Funcionalidad"></th>
                        <th data-translate="Acción"></th>
                        <th class="actions-row" data-translate="Acciones"></th>
                    </tr>
                </thead>
                    <?php if (!empty($this->permissions)): ?>
                <tbody>
                    <?php foreach ($this->permissions as $permission): ?>
                         <tr>
                            <td><?php echo $permission->getRol()->getNombre() ?></td>
                            <td><?php echo $permission->getFuncAccion()->getFuncionalidad()->getNombre() ?></td>
                            <td><?php echo $permission->getFuncAccion()->getAccion()->getNombre() ?></td>
                            <td class="row">
                                <?php if (checkPermission("Permission", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/permissionController.php?action=show&id=<?php echo $permission->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                    if (checkPermission("Permission", "EDIT")) { ?>
                                    <a href="../controllers/permissionController.php?action=edit&id=<?php echo $permission->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                    if (checkPermission("Permission", "DELETE")) { ?>
                                    <a href="../controllers/permissionController.php?action=delete&id=<?php echo $permission->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                         </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            </table>
                <p data-translate="No se ha obtenido ningun permiso">. </p>
            <?php endif; ?>
            <?php //new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalPermissions, "Permission"); ?>
        </div>
    </main>

    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>
</html>
<?php
        }
    }
?>
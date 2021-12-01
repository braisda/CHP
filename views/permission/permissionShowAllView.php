<?php
include_once '../utils/CheckPermission.php';

class PermissionShowAllView {

    private $permissions;
    private $pageItems;
    private $page;
    private $totalPermissions;
    private $totalPages;
    private $search;

    private $roles;
    private $funcActions;

    function __construct($permissionData, $pageItems = NULL, $page = NULL, $totalPermissions = NULL, $search = NULL, $roles = NULL, $funcActions = NULL) {
        $this->permissions = $permissionData;
        $this->pageItems = $pageItems;
        $this->page = $page;
        $this->totalPermissions = $totalPermissions;
        $this->totalPages = ceil($totalPermissions / $pageItems);
        $this->search = $search;
        $this->roles = $roles;
        $this->funcActions = $funcActions;
        $this->render();
    }

    function render()
        {
         ?>
<!DOCTYPE html>
<html>
<body>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
            <h2 data-translate="Listado de permisos"></h2>
            <!-- Search -->
            <a class="btn btn-primary button-specific-search" data-toggle="modal" data-target="#searchModal" role="button">
                <span data-feather="search"></span>
                <p class="btn-show-view" data-translate="Buscar"></p>
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
                            <form class="row" id="searchPermission" action='../controllers/permissionController.php?action=search' method='POST'>
                                <div class="form-group">
                                    <label for="idRol" data-translate="Rol"></label>
                                    <select class="form-control" id="idRol" name="idRol">
                                        <option value="" data-translate="Seleccione"></option>
                                        <?php foreach ($this->roles as $role): ?>
                                        <option value="<?php echo $role->getId()?>">
                                            <?php echo $role->getNombre() ?>
                                        </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="idFuncAccion" data-translate="Permiso"></label>
                                    <select class="form-control" id="idFuncAccion" name="idFuncAccion">
                                        <option value="" data-translate="Seleccione"></option>
                                        <?php foreach($this->funcActions as $funcAction): ?>
                                        <option value="<?php echo $funcAction->getId()?>" >
                                            <?php echo $funcAction->getAccion()->getNombre()." - ".$funcAction->getFuncionalidad()->getNombre(); ?>
                                        </option>
                                        <?php endforeach;?>
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

            <?php if (!empty($this->search)){ ?>
                <a class="btn btn-primary mr-1" role="button" href="../controllers/permissionController.php">
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
            <?php if (empty($this->search)) { new PaginationView($this->pageItems, $this->page, $this->totalPermissions, "Permission"); } ?>
        </div>
    </main>

    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>
<script type="text/javascript">
    function form_submit() {
        document.getElementById("searchPermission").submit();
    }
</script>
</html>
<?php
        }
    }
?>
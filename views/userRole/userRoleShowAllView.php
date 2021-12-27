<?php
include_once '../Functions/HavePermission.php';

class UserRoleShowAllView
{
    private $userRoles;
    private $users;
    private $roles;
    private $itemsPerPage;
    private $currentPage;
    private $totalUserRoles;
    private $totalPages;
    private $search;

    function __construct($userRoleData, $userData, $roleData, $itemsPerPage = NULL, $currentPage = NULL, $totalUserRoles = NULL, $search = NULL)
    {
        $this->userRoles = $userRoleData;
        $this->users = $userData;
        $this->roles = $roleData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalUserRoles = $totalUserRoles;
        $this->totalPages = ceil($totalUserRoles / $itemsPerPage);
        $this->search = $search;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
        <script src="../js/validations/userRoleValidations.js"></script>
        </head>
        <body>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 class="h2" data-translate="Asignación de roles a usuarios"></h2>

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
                            <form class="row" id="searchRole" action='../controllers/userRoleController.php?action=search' method='POST'>
                                <div id="name-div" class="form-group col-12">
                                <label for="user_id" data-translate="Usuario"></label>
                                    <select class="form-control" id="user_id" name="user_id">
                                        <?php foreach ($this->users as $user): ?>
                                            <option value="<?php echo $user->getLogin()?>"><?php echo $user->getLogin() ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div id="description-div" class="form-group col-12">
                                <label for="description" data-translate="Rol"></label>
                                    <select class="form-control" id="role_id" name="role_id"?>
                                        <?php foreach ($this->roles as $role): ?>
                                            <option value="<?php echo $role->getId() ?>"><?php echo $role->getNombre() ?></option>
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

                <?php if (!empty($this->search)): ?>
                    <a class="btn btn-primary" role="button" href="../Controllers/userRoleController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (checkPermission("usuarioRole", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../Controllers/userRoleController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Asignar rol a usuario"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Usuario"></label></th>
                        <th><label data-translate="Rol"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->userRoles)): ?>
                    <tbody>
                    <?php foreach ($this->userRoles as $userRole): ?>
                        <tr>
                            <td><?php echo $userRole->getIdusuario()->getLogin(); ?></td>
                            <td><?php echo $userRole->getIdrol()->getNombre(); ?></td>
                            <td class="row">
                                <?php if (checkPermission("usuarioRole", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/userRoleController.php?action=show&id=<?php echo $userRole->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("usuarioRole", "EDIT")) { ?>
                                    <a href="../controllers/userRoleController.php?action=edit&id=<?php echo $userRole->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("usuarioRole", "DELETE")) { ?>
                                    <a href="../controllers/userRoleController.php?action=delete&id=<?php echo $userRole->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún rol">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalUserRoles,
                    "usuarioRole") ?>

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
        document.getElementById("searchRole").submit();
    }
</script>
</html>
        <?php
    }
}

?>

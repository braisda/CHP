<?php
include_once '../utils/CheckPermission.php';

class UserShowAllView
{
    private $users;
    private $pageItems;
    private $page;
    private $totalUsers;
    private $totalPages;

    function __construct($usersData, $pageItems, $page, $totalUsers)
    {
        $this->users = $usersData;
        $this->pageItems = $pageItems;
        $this->page = $page;
        $this->totalUsers = $totalUsers;
        $this->totalPages = ceil($totalUsers / $pageItems);
        $this->render();
    }

    function render()
    {
        ?>
<!DOCTYPE html>
<html>
<head>
    <script src="../js/validations/loginValidations.js"></script>
</head>
<body>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
            <h2 data-translate="Listado de usuarios"></h2>
            <!-- Search -->
            <a class="btn btn-primary button-specific-search" data-toggle="modal" data-target="#searchModal" role="button">
                <span data-feather="search"></span>
                <p class="btn-show-view" data-translate="Buscar"></p>
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
                            <form class="row" id="searchUser" action='../controllers/userController.php?action=search' method='POST'>
                                 <div id="login-div" class="form-group col-12">
                                    <label for="login" data-translate="Login"></label>
                                    <input type="text" class="form-control" id="login" name="login" max-length="9" oninput="checkLogin(this);">
                                </div>

                                <div id="name-div" class="form-group col-12">
                                    <label for="name" data-translate="Nombre"></label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" max-length="30" oninput="checkName(this);">
                                </div>

                                <div id="surname-div" class="form-group col-12">
                                    <label for="surname" data-translate="Apellido"></label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" max-length="50" oninput="checkSurname(this);">
                                </div>

                                <div id="email-div" class="form-group col-12">
                                    <label for="email" data-translate="Email"></label>
                                    <input type="email" class="form-control" id="email" name="email" max-length="40" oninput="checkEmailUser(this);">
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
                <a class="btn btn-primary mr-1" role="button" href="../controllers/userController.php">
                    <p data-translate="Volver"></p>
                </a>
            <?php } else {
                if (checkPermission("usuario", "ADD")) { ?>
                    <a class="btn btn-success" role="button" href="../controllers/userController.php?action=add">
                        <span data-feather="plus"></span>
                        <p data-translate="Añadir usuario"></p>
                    </a>
            <?php }} ?>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                     <tr>
                        <th data-translate="Login"></th>
                        <th data-translate="Nombre"></th>
                        <th data-translate="Apellido"></th>
                        <th data-translate="Email"></th>
                        <th class="actions-row" data-translate="Acciones"></th>
                    </tr>
                </thead>
                <?php if (!empty($this->users)): ?>
                <tbody>
                    <?php foreach ($this->users as $user): ?>
                        <tr>
                             <td><?php echo $user->getLogin() ?></td>
                             <td><?php echo $user->getNombre() ?></td>
                             <td><?php echo $user->getApellido() ?></td>
                             <td><?php echo $user->getEmail() ?></td>
                             <td class="row">
                                 <?php if (checkPermission("usuario", "SHOWCURRENT")) { ?>
                                      <a href="../controllers/UserController.php?action=show&login=<?php echo $user->getLogin() ?>">
                                      <span data-feather="eye"></span></a>
                                 <?php }
                                      if (checkPermission("usuario", "EDIT")) { ?>
                                       <a href="../controllers/UserController.php?action=edit&login=<?php echo $user->getLogin() ?>">
                                       <span data-feather="edit"></span></a>
                                 <?php }
                                      if (checkPermission("usuario", "DELETE")) { ?>
                                      <a href="../controllers/UserController.php?action=delete&login=<?php echo $user->getLogin() ?>">
                                      <span data-feather="trash-2"></span></a>
                                 <?php } ?>
                             </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                </table>
                <?php else: ?>
                </table>
                <p data-translate="No se ha obtenido ningún usuario">.</p>
                <?php endif; ?>

                <?php new PaginationView($this->pageItems, $this->page, $this->totalUsers, "User"); ?>
        </div>
    </main>

    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>
<script type="text/javascript">
    function form_submit() {
        document.getElementById("searchUser").submit();
    }
</script>
</html>
<?php
    }
}
?>
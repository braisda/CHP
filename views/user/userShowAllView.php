<?php
include_once '../utils/CheckPermission.php';

class UserShowAllView
{
    private $users;
    private $pageItems;
    private $page;
    private $totalUsers;
    private $totalPages;
    private $stringToSearch;

    function __construct($usersData, $pageItems, $page, $totalUsers, $stringToSearch)
    {
        $this->users = $usersData;
        $this->pageItems = $pageItems;
        $this->page = $page;
        $this->totalUsers = $totalUsers;
        $this->totalPages = ceil($totalUsers / $pageItems);
        $this->stringToSearch = $stringToSearch;
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
            <h2 data-translate="Listado de usuarios"></h2>
            <!-- Search -->
            <form class="row" action='../controllers/userController.php' method='POST'>
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
<?php
class UserRoleAddView {
    private $users;
    private $roles;
function __construct($userData,$roleData){
    $this->users = $userData;
    $this->roles = $roleData;
    $this->render();
}
function render(){
?>
<head>
<script src="../js/validations/roleValidations.js"></script>
</head>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h1 class="h2" data-translate="Asignar rol a usuario"></h1>
            <a class="btn btn-primary" role="button" href="../controllers/userRoleController.php"><p data-translate="Volver"></p></a>
        </div>
        <form action='../controllers/userRoleController.php?action=add' method='POST'>
            <div class="form-group">
                <label for="user_id" data-translate="Usuario"></label>
                <select class="form-control" id="user_id" name="user_id">
                    <?php foreach ($this->users as $user): ?>
                        <option value="<?php echo $user->getLogin()?>"><?php echo $user->getLogin() ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="description" data-translate="Rol"></label>
                <select class="form-control" id="role_id" name="role_id"?>
                    <?php foreach ($this->roles as $role): ?>
                        <option value="<?php echo $role->getId() ?>"><?php echo $role->getNombre() ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
        </form>
    </main>
<?php
    }
}
?>

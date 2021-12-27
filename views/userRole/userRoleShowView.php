<?php
class UserRoleShowView {
private $userRole;

    function __construct($userRoleData){
        $this->userRole = $userRoleData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../CSS/default.css" />
            <link rel="stylesheet" href="../CSS/forms.css" />
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2" data-translate="Usuario-rol '%<?php echo $this->userRole->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/userRoleController.php"><p data-translate="Volver"></p></a>
            </div>
            <?php if(!empty($this->userRole)): ?>
            <form>
                <div class="form-group">
                    <label for="user_id" data-translate="Usuario"></label>
                    <input type="text" class="form-control" id="user_id" name="user_id"
                           value="<?php echo $this->userRole->getIdusuario()->getLogin(); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="role_id" data-translate="Rol"></label>
                    <input type="text" class="form-control" id="role_id" name="role_id"
                           value="<?php echo  $this->userRole->getIdrol()->getNombre() ?>" readonly>
                </div>
            </form>
            <?php else: ?>
                <p data-translate="El rol no existe">.</p>
            <?php endif; ?>
        </main>
        <?php
    }
}
?>

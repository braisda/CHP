<?php
class PermissionSearchView {
    private $roles;
    private $funcActions;

    function __construct($rolesData, $funcActionsData){
        $this->roles = $rolesData;
        $this->funcActions = $funcActionsData;
        $this->render();
    }

    function render(){
        ?>
<!DOCTYPE html>
<html>
<body>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h2 data-translate="Buscar permiso"></h2>
            <a class="btn btn-primary" role="button" href="../controllers/permissionController.php" data-translate="Volver"></a>
        </div>
        <form action='../controllers/permissionController.php?action=search' method='POST'>
            <div class="form-group">
                <label for="name" data-translate="Rol"></label>
                <select class="form-control" id="idRol" name="idRol">
                    <option data-translate="Rol" value=""></option>
                    <?php foreach ($this->roles as $rol): ?>
                        <option value="<?php echo $rol->getId() ?>"><?php echo $rol->getNombre() ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="description" data-translate="Permiso"></label>
                <select class="form-control" id="idFuncAccion" name="idFuncAccion"?>
                    <option data-translate="Permiso" value=""></option>
                    <?php foreach ($this->funcActions as $funcAction): ?>
                        <option value="<?php echo $funcAccion->getId() ?>">
                        <?php echo $funcAction->getAccion()->getNombre()." - ". $funcAction->getFuncionalidad()->getNombre(); ?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </form>
    </main>
</body>
</html>
<?php
    }
}
?>

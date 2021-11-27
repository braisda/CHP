<?php
class PermissionAddView {
    private $roles;
    private $funcActions;

    function __construct($rolesData, $funcActionData){
        $this->roles = $rolesData;
        $this->funcActions = $funcActionData;
        $this->render();
    }

    function render(){
            ?>
<!DOCTYPE html>
<html>
<body>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h2 data-translate="Insertar permiso"></h2>
            <a class="btn btn-primary" role="button" href="../controllers/permissionController.php" data-translate="Volver"></a>
        </div>
        <form action='../controllers/permissionController.php?action=add' method='POST'>
            <div class="form-group">
                <label for="name" data-translate="Rol"></label>
                <select class="form-control" id="idRol" name="idRol">
                    <?php foreach ($this->roles as $rol): ?>
                    <option value="<?php echo $rol->getId() ?>"><?php echo $rol->getNombre() ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                 <label for="description" data-translate="Permiso"></label>
                 <select class="form-control" id="idFuncAccion" name="idFuncAccion"?>
                    <?php foreach ($this->funcActions as $funcAction): ?>
                    <option value="<?php echo $funcAction->getId() ?>">
                    <?php echo $funcAction->getAccion()->getNombre()." - ". $funcAction->getFuncionalidad()->getNombre(); ?></option>
                    <?php endforeach;?>
                 </select>
            </div>

            <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
        </form>
    </main>
</body>
</html>
<?php
    }
}
?>
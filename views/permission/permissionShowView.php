<?php
class PermissionShowView {

private $permission;

    function __construct($permissionData) {
        $this->permission = $permissionData;
        $this->render();
        print_r($this->permission->getRol()->getNombre());
    }

    function render() {
        ?>
<!DOCTYPE html>
<html>
<body>
     <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h2 data-translate="Permiso '%<?php echo $this->permission->getFuncAccion()->getFuncionalidad()->getNombre(); $this->permission->getFuncAccion()->getAccion()->getNombre(); ?>%'"></h2>
            <a class="btn btn-primary" role="button" href="../controllers/permissionController.php"><p data-translate="Volver"></p></a>
        </div>
        <?php if(!is_null($this->permission)): ?>
        <form>
            <div class="form-group">
                <label for="rol" data-translate="Rol"></label>
                <input type="text" class="form-control" id="rol" name="rol"
                    value="<?php echo $this->permission->getRol()->getNombre(); ?>" readonly="readonly" />
            </div>
            <div class="form-group">
                <label for="funcionalidad" data-translate="Funcionalidad"></label>
                <input type="text" class="form-control" id="funcionalidad" name="funcionalidad"
                    value="<?php echo $this->permission->getFuncAccion()->getFuncionalidad()->getNombre(); ?>" readonly="readonly" />
            </div>
            <div class="form-group">
                <label for="accion" data-translate="Acción"></label>
                <input type="text" class="form-control" id="accion" name="accion"
                    value="<?php echo $this->permission->getFuncAccion()->getAccion()->getNombre(); ?>" readonly="readonly" />
            </div>
        </form>
        <?php else: ?>
            <p data-translate="El permiso no existe">.</p>
        <?php endif; ?>
     </main>
</body>
</html>
<?php
    }
}
?>
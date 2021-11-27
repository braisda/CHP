<?php
class PermissionEditView {

    private $permission;
    private $roles;
    private $funcActions;

    function __construct($permissionData, $roleData, $funcActionData) {
        $this->permission = $permissionData;
        $this->roles = $roleData;
        $this->funcActions = $funcActionData;
        $this->render();
    }

    function render() {
    ?>
<!DOCTYPE html>
<html id="home">
<head>
     <?php include_once '../views/common/head.php';?>
</head>
<body>
     <?php include_once '../views/common/headerMenu.php'; ?>
     <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h2 data-translate="Editar permiso '%<?php echo $this->permission->getFuncAccion()->getFuncionalidad()->getNombre(); $this->permission->getFuncAccion()->getAccion()->getNombre();?>%'"></h2>
            <a class="btn btn-primary" role="button" href="../controllers/permissionController.php" data-translate="Volver"></a>
        </div>
        <form  action='../controllers/permissionController.php?action=edit&id=<?php echo $this->permission->getId()?>' method='POST'>
            <div class="form-group">
                <label for="name" data-translate="Rol"></label>
                <select class="form-control" id="idRol" name="idRol">
                    <?php foreach ($this->roles as $role): ?>
                    <option value="<?php echo $role->getId()?>"
                        <?php if($role->getId() == $this->permission->getRol()->getId()){echo 'selected="selected"';}?>>
                        <?php echo $role->getNombre() ?>
                    </option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="description" data-translate="Permiso"></label>
                <select class="form-control" id="idFuncAccion" name="idFuncAccion">
                    <?php foreach($this->funcActions as $funcAction): ?>
                    <option value="<?php echo $funcAction->getId()?>"
                        <?php if($funcAction->getId() == $this->permission->getFuncAccion()->getId()){echo 'selected="selected"';}?>>
                        <?php echo $funcAction->getAccion()->getNombre()." - ".$funcAction->getFuncionalidad()->getNombre(); ?>
                    </option>
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
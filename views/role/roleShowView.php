<?php
class RoleShowView {
private $role;
    function __construct($roleData){
        $this->role = $roleData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <link rel="stylesheet" href="../css/styles.css" />
            <link rel="stylesheet" href="../css/forms.css" />
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2" data-translate="Rol '%<?php echo $this->role->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/roleController.php" data-translate="Volver"></a>
            </div>
            <?php if(!is_null($this->role)): ?>
            <form>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->role->getNombre() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description" data-translate="Descripción"></label>
                    <input type="text" class="form-control" id="description" name="description"
                           value="<?php echo $this->role->getDescripcion() ?>" readonly>
                </div>
            </form>
            <?php else: ?>
                <p data-translate="La acción no existe">.</p>
            <?php endif; ?>
        </main>
        <?php
    }
}
?>

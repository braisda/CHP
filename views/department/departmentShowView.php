<?php
class DepartmentShowView {
    private $department;

    function __construct($departmentData){
        $this->department = $departmentData;
        $this->render();
    }
    function render(){
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Departamento '%<?php echo $this->department->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/departmentController.php"><p data-translate="Volver"></p></a>
            </div>
            <?php if(!is_null($this->department)): ?>
            <form>
                <div class="form-group">
                    <label for="code" data-translate="Inicio"></label>
                    <input type="text" class="form-control" id="code" name="code"
                           value="<?php echo $this->department->getCodigo() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="profesor" data-translate="Profesor"></label>
                    <input type="text" class="form-control" id="profesor" name="profesor"
                           value="<?php echo $this->department->getIdprofesor()->getUsuario()->getLogin() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="name" data-translate="Fin"></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->department->getNombre() ?>" readonly>
                </div>
            </form>
            <?php else: ?>
                <p data-translate="El departamento no existe">.</p>
            <?php endif; ?>
        </main>
        <?php
    }
}
?>

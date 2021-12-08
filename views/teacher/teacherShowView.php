<?php
class TeacherShowView {

    private $teacher;

    function __construct($teacher) {
        $this->teacher = $teacher;
        $this->render();
    }

    function render() {
        ?>
        <head>
            <script src="../js/validations/teacherValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h2 data-translate="Profesor '%<?php echo $this->teacher->getUsuario()->getNombre() ?>%'"></h2>
                <a class="btn btn-primary" role="button" href="../controllers/teacherController.php" data-translate="Volver"></a>
            </div>
            <?php if(!is_null($this->teacher)): ?>
            <form id="teacherForm">
                <div class="form-group">
                    <label for="idusuario" data-translate="Usuario"></label>
                    <input type="text" class="form-control" id="idusuario" name="idusuario" readonly
                           value="<?php echo $this->teacher->getUsuario()->getNombre() . " " . $this->teacher->getUsuario()->getApellido()?>">
                </div>
                <div id="dedication-div" class="form-group">
                    <label for="dedicacion" data-translate="Dedicación"></label>
                    <input type="text" class="form-control" id="dedicacion" name="dedicacion"
                           value="<?php echo $this->teacher->getDedicacion();?>" readonly>
                </div>
                <div class="form-group">
                    <label for="idespacio" data-translate="Despacho"></label>
                    <?php if(!empty($this->teacher->getEspacio())): ?>
                    <input type="text" class="form-control" id="idespacio" name="idespacio" readonly
                           value="<?php echo $this->teacher->getEspacio()->getNombre()?>">
                    <?php else: ?>
                        <input type="text" class="form-control" id="idespacio" name="idespacio" readonly
                               data-translate="No asignado">
                    <?php endif; ?>
                </div>
            </form>
            <?php else: ?>
                <p data-translate="El profesor no existe">.</p>
            <?php endif; ?>
        </main>
<?php
    }
}
?>
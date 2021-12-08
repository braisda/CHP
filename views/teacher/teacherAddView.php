<?php
class TeacherAddView {

    private $spaces;
    private $users;

    function __construct($users, $spaces) {
        $this->users = $users;
        $this->spaces = $spaces;
        $this->render();
    }

    function render() {
        ?>
<!DOCTYPE html>
<html>
<head>
    <script src="../js/validations/teacherValidations.js"></script>
</head>
<body>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h2 data-translate="Insertar profesor"></h2>
            <a class="btn btn-primary" role="button" href="../controllers/teacherController.php" data-translate="Volver"></a>
        </div>
        <form id="teacherForm" action='../controllers/teacherController.php?action=add' method='POST' onsubmit="areTeacherFieldsCorrect()">
            <div class="form-group">
                <label for="idusuario" data-translate="Usuario"></label>
                <select class="form-control" id="idusuario" name="idusuario" ?>
                    <option value="" data-translate="Seleccione"></option>
                    <?php foreach ($this->users as $user): ?>
                        <option value="<?php echo $user->getId() ?>">
                            <?php echo $user->getNombre()." ". $user->getApellido() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="dedication-div" class="form-group">
                <label for="dedicacion" data-translate="Dedicación"></label>
                <input type="text" class="form-control" id="dedicacion" name="dedicacion"
                       data-translate="Dedicación" required maxlength="4"
                       oninput="checkDedicationTeacher(this)">
            </div>
            <div class="form-group">
                <label for="idespacio" data-translate="Despacho"></label>
                <select class="form-control" id="idespacio" name="idespacio" ?>
                    <option value="" data-translate="Seleccione"></option>
                    <?php foreach ($this->spaces as $space): ?>
                        <option value="<?php echo $space->getId() ?>">
                            <?php echo $space->getNombre(); ?></option>
                    <?php endforeach; ?>
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
<?php

class TeacherEditView {

    private $teacher;
    private $spaces;
    private $users;

    function __construct($teacher, $users, $spaces) {
        $this->teacher = $teacher;
        $this->users = $users;
        $this->spaces = $spaces;
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
                <h1 class="h2" data-translate="Editar profesor '%<?php echo $this->teacher->getUsuario()->getNombre()?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/teacherController.php" data-translate="Volver"></a>
            </div>
            <form  id="teacherForm" action='../controllers/teacherController.php?action=edit&id=<?php echo $this->teacher->getId()?>'
                   method='POST' onsubmit="areTeacherFieldsCorrect()">
                <div class="form-group">
                    <label for="idusuario" data-translate="Usuario"></label>
                    <select class="form-control" id="idusuario" name="idusuario" ?>
                        <?php foreach ($this->users as $user): ?>
                            <option value="<?php echo $user->getId() ?>"
                                <?php if ($user->getId() == $this->teacher->getUsuario()->getId()) {
                                    echo 'selected="selected"';
                                } ?>>
                                <?php echo $user->getNombre()." ". $user->getApellido(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="dedication-div" class="form-group">
                    <label for="dedicacion" data-translate="Dedicación"></label>
                    <input type="text" class="form-control" id="dedicacion" name="dedicacion"
                           data-translate="Dedicación" required maxlength="4"
                           oninput="checkDedicationTeacher(this)" value="<?php echo $this->teacher->getDedicacion();?>">
                </div>
                <div class="form-group">
                    <label for="idespacio" data-translate="Despacho"></label>
                    <select class="form-control" id="idespacio" name="idespacio">
                        <option data-translate="Seleccione" value=""></option>
                        <?php if (!in_array($this->teacher->getEspacio())): ?>
                            <option value="<?php echo $this->teacher->getEspacio()->getId() ?>" selected>
                                <?php echo $this->teacher->getEspacio()->getNombre() ?></option>
                        <?php endif; ?>
                    </select>
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Editar"></button>
            </form>
        </main>
<?php
    }
}
?>
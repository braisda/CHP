<?php
class SubjectTeacherEditView {

    private $subjectTeacher;
    private $teachers;
    private $subject;

    function __construct($subjectTeacher, $teachers, $subject){
        $this->subjectTeacher = $subjectTeacher;
        $this->subject = $subject;
        $this->teachers = $teachers;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <script src="../js/validations/subjectTeacherValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Editar asignación de profesor"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/subjectTeacherController.php?subject_id=<?php echo $this->subject ?>" data-translate="Volver"></a>
            </div>
            <form id="subjectTeacherForm" action='../controllers/subjectTeacherController.php?action=edit&id=<?php echo $this->subjectTeacher->getId() ?>&subject_id=<?php echo $this->subject ?>'
                  method='POST' onsubmit="return areSubjectTeacherFieldsCorrect()">
                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor"></label>
                    <select class="form-control" id="teacher_id" name="teacher_id" required>
                        <option value="" data-translate="Seleccione"></option>
                        <?php foreach ($this->teachers as $teacher): ?>
                            <option value="<?php echo $teacher->getId() ?>"
                                <?php if($teacher->getId() == $this->subjectTeacher->getProfesor()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $teacher->getUsuario()->getNombre()." ".$teacher->getUsuario()->getApellido() ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div id="hours-div" class="form-group">
                    <label for="hours" data-translate="Horas"></label>
                    <input type="number" class="form-control" id="hours" name="hours" data-translate="Horas"
                           maxlength="2" required oninput="checkHoursSubjectTeacher(this);"
                            value="<?php echo $this->subjectTeacher->getHoras()?>">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>

        <?php
    }
}
?>

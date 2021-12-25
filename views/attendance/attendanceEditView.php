<?php
class AttendanceEditView {

    private $attendance;
    private $subject;

    function __construct($attendance, $subject) {
        $this->attendance = $attendance;
        $this->subject = $subject;
        $this->render();
    }

    function render() {
        ?>

        <head>
            <script src="../js/validations/attendanceValidations.js"></script>
        </head>
       <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h2 data-translate="Editar asistencia de la materia '%<?php echo $this->subject->getIdmateria()->getCodigo() ?>%'"></h2>
                <a class="btn btn-primary" role="button" href="../controllers/attendanceController.php?subject=<?php echo $this->subject->getIdmateria()->getId()?>&schedule=<?php echo $this->attendance->getHorario()->getId() ?>">
                    <p data-translate="Volver"></p></a>
            </div>
            <form id="attendanceForm" action='../controllers/attendanceController.php?subject=<?php echo $this->subject->getIdmateria()->getId()?>&schedule=<?php echo $this->attendance->getHorario()->getId() ?>&action=edit&id=<?php echo $this->attendance->getId() ?>'
                method='POST' onsubmit="return areAttendanceFieldsCorrect()">
                <div id="num-students-div" class="form-group">
                    <label for="code" data-translate="Número de asistentes"></label>
                    <input type="number" class="form-control" id="numStudents" name="numStudents" data-translate="Número de asistentes"
                           required maxlength="3" oninput="checkNumStudents(this)" value="<?php echo $this->attendance->getNumAlumnos() ?>">
                </div>
                 <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
       </main>
<?php
    }
}
?>
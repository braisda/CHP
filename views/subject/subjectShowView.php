<?php
class SubjectShowView {

    private $subject;

    function __construct($subject) {
        $this->subject = $subject;
        $this->render();
    }

    function render() {
        ?>
        <head>
            <script src="../js/validations/subjectValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h2 data-translate="Materia '%<?php echo $this->subject->getCodigo() ?>%'"></h2>
                <a class="btn btn-primary" role="button" href="../controllers/subjectController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="subjectForm" method='POST'>
                <div id="code-div" class="form-group">
                    <label for="code" data-translate="Código"></label>
                    <input type="text" class="form-control" id="code" name="code"
                            value="<?php echo $this->subject->getCodigo() ?>" readonly>
                </div>
                <div id="content-div" class="form-group">
                    <label for="content" data-translate="Contenido"></label>
                    <input type="text" class="form-control" id="content" name="content"
                           value="<?php echo $this->subject->getContenido() ?>" readonly>
                </div>
                <div id="type-div" class="form-group">
                    <label for="type" data-translate="Tipo"></label>
                    <input type="text" class="form-control" id="type" name="type"
                           value="<?php echo $this->subject->getTipo() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="department_id" data-translate="Departamento"></label>
                    <input type="text" class="form-control" id="department_id" name="department_id"
                           value="<?php echo $this->subject->getDepartamento()->getNombre() ?>" readonly>
                </div>
                <div id="area-div" class="form-group">
                    <label for="area" data-translate="Área"></label>
                    <input type="text" class="form-control" id="area" name="area"
                           value="<?php echo $this->subject->getArea() ?>" readonly>
                </div>
                <div id="course-div" class="form-group">
                    <label for="course" data-translate="Curso"></label>
                    <input type="text" class="form-control" id="course" name="course"
                           value="<?php echo $this->subject->getCurso() ?>" readonly>
                </div>
                <div id="quarter-div" class="form-group">
                    <label for="quarter" data-translate="Cuatrimestre"></label>
                    <input type="text" class="form-control" id="quarter" name="quarter"
                           value="<?php echo $this->subject->getCuatrimestre() ?>" readonly>
                </div>
                <div id="credits-div" class="form-group">
                    <label for="credits" data-translate="Créditos"></label>
                    <input type="text" class="form-control" id="credits" name="credits"
                           value="<?php echo $this->subject->getCreditos() ?>" readonly>
                </div>
                <div id="new-registrarion-div" class="form-group">
                    <label for="new_registration" data-translate="Número de nueva matrícula"></label>
                    <input type="number" class="form-control" id="new_registration" name="new_registration"
                           value="<?php echo $this->subject->getNuevoRegistro() ?>" readonly>
                </div>
                <div id="repeaters-div" class="form-group">
                    <label for="repeaters" data-translate="Número de repetidores"></label>
                    <input type="number" class="form-control" id="repeaters" name="repeaters"
                           value="<?php echo $this->subject->getRepeticiones() ?>" readonly>
                </div>
                <div id="effective-students-div" class="form-group">
                    <label for="effective_students" data-translate="Número de alumnos efectivos"></label>
                    <input type="number" class="form-control" id="effective_students" name="effective_students"
                           value="<?php echo $this->subject->getEstudiantesEfectivos() ?>" readonly>
                </div>
                <div id="enrolled-hours-div" class="form-group">
                    <label for="enrolled_hours" data-translate="Número de horas matriculadas"></label>
                    <input type="text" class="form-control" id="enrolled_hours" name="enrolled_hours"
                           value="<?php echo $this->subject->getHorasInscritas() ?>" readonly>
                </div>
                <div id="taught-hours-div" class="form-group">
                    <label for="taught_hours" data-translate="Número de horas impartidas"></label>
                    <input type="text" class="form-control" id="taught_hours" name="taught_hours"
                           value="<?php echo $this->subject->getHorasEnseño() ?>" readonly>
                </div>
                <div id="hours-div" class="form-group">
                    <label for="hours" data-translate="Número de horas"></label>
                    <input type="text" class="form-control" id="hours" name="hours"
                           value="<?php echo $this->subject->getHoras() ?>" readonly>
                </div>
                <div id="students-div" class="form-group">
                    <label for="students" data-translate="Estudiantes"></label>
                    <input type="number" class="form-control" id="students" name="students"
                           value="<?php echo $this->subject->getAlumnos() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="degree_id" data-translate="Titulación"></label>
                    <input type="text" class="form-control" id="degree_id" name="degree_id"
                           value="<?php echo $this->subject->getGrado()->getNombre() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor responsable"></label>
                    <input type="text" class="form-control" id="teacher_id" name="teacher_id" readonly
                           value="<?php if ($this->subject->getProfesor()->getUsuario()->getNombre()) { echo $this->subject->getProfesor()->getUsuario()->getNombre()." ".
                               $this->subject->getProfesor()->getUsuario()->getApellido() } ?>">
                </div>
            </form>
        </main>
<?php
    }
}
?>
<?php

class SubjectEditView {

    private $subject;
    private $degrees;
    private $departments;
    private $teachers;

    function __construct($subject, $degrees, $departments, $teachers) {
        $this->subject = $subject;
        $this->degrees = $degrees;
        $this->departments = $departments;
        $this->teachers = $teachers;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <script src="../js/validations/subjectValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Editar materia '%<?php echo $this->subject->getCodigo() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/subjectController.php"><p
                        data-translate="Volver"></p></a>
            </div>
            <form id="subjectForm" action='../controllers/subjectController.php?action=edit&id=<?php echo $this->subject->getId() ?>'
                  method='POST' onsubmit="areSubjectFieldsCorrect()">
                <div id="code-div" class="form-group">
                    <label for="code" data-translate="Código"></label>
                    <input type="text" class="form-control" id="code" name="code" data-translate="Código"
                           required maxlength="10" oninput="checkCodeSubject(this)" value="<?php echo $this->subject->getCodigo() ?>">
                </div>
                <div id="content-div" class="form-group">
                    <label for="content" data-translate="Contenido"></label>
                    <input type="text" class="form-control" id="content" name="content" data-translate="Contenido"
                           required maxlength="100" oninput="checkContentSubject(this)" value="<?php echo $this->subject->getContenido() ?>">
                </div>
                <div id="type-div" class="form-group">
                    <label for="type" data-translate="Tipo"></label>
                    <input type="text" class="form-control" id="type" name="type" data-translate="Tipo"
                           required maxlength="2" oninput="checkTypeSubject(this)" value="<?php echo $this->subject->getTipo() ?>">
                </div>
                <div class="form-group">
                    <label for="department_id" data-translate="Departamento"></label>
                    <select class="form-control" id="department_id" name="department_id" ?>
                        <option value="" data-translate="Seleccione"></option>
                        <?php foreach ($this->departments as $department): ?>
                            <option value="<?php echo $department->getId() ?>"
                                <?php if($department->getId() == $this->subject->getDepartamento()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $department->getNombre();?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </div>
                <div id="area-div" class="form-group">
                    <label for="area" data-translate="Área"></label>
                    <input type="text" class="form-control" id="area" name="area" data-translate="Área"
                           required maxlength="5" oninput="checkAreaSubject(this)" value="<?php echo $this->subject->getArea() ?>">
                </div>
                <div id="course-div" class="form-group">
                    <label for="course" data-translate="Curso"></label>
                    <input type="text" class="form-control" id="course" name="course" data-translate="Curso"
                           required maxlength="10" oninput="checkCourseSubject(this)" value="<?php echo $this->subject->getCurso() ?>">
                </div>
                <div id="quarter-div" class="form-group">
                    <label for="quarter" data-translate="Cuatrimestre"></label>
                    <input type="text" class="form-control" id="quarter" name="quarter" data-translate="Cuatrimestre"
                           required maxlength="3" oninput="checkQuarterSubject(this)" value="<?php echo $this->subject->getCuatrimestre() ?>">
                </div>
                <div id="credits-div" class="form-group">
                    <label for="credits" data-translate="Créditos"></label>
                    <input type="text" class="form-control" id="credits" name="credits" data-translate="Créditos"
                           required maxlength="5" oninput="checkCreditsSubject(this)" value="<?php echo $this->subject->getCreditos() ?>">
                </div>
                <div id="new-registrarion-div" class="form-group">
                    <label for="new_registration" data-translate="Número de nueva matrícula"></label>
                    <input type="number" class="form-control" id="new_registration" name="new_registration"
                           data-translate="Número de nueva matrícula"
                           required maxlength="3" oninput="checkNewRegistrationSubject(this)" value="<?php echo $this->subject->getNuevoRegistro() ?>">
                </div>
                <div id="repeaters-div" class="form-group">
                    <label for="repeaters" data-translate="Número de repetidores"></label>
                    <input type="number" class="form-control" id="repeaters" name="repeaters"
                           data-translate="Número de repetidores"
                           required maxlength="3" oninput="checkRepeatersSubject(this)" value="<?php echo $this->subject->getRepeticiones() ?>">
                </div>
                <div id="effective-students-div" class="form-group">
                    <label for="effective_students" data-translate="Número de alumnos efectivos"></label>
                    <input type="number" class="form-control" id="effective_students" name="effective_students"
                           data-translate="Número de alumnos efectivos"
                           required maxlength="3" oninput="checkEffectiveStudentsSubject(this)" value="<?php echo $this->subject->getEstudiantesEfectivos() ?>">
                </div>
                <div id="enrolled-hours-div" class="form-group">
                    <label for="enrolled_hours" data-translate="Número de horas matriculadas"></label>
                    <input type="text" class="form-control" id="enrolled_hours" name="enrolled_hours"
                           data-translate="Número de horas matriculadas" required maxlength="8" oninput="checkEnrolledHoursSubject(this)" value="<?php echo $this->subject->getHorasInscritas() ?>">
                </div>
                <div id="taught-hours-div" class="form-group">
                    <label for="taught_hours" data-translate="Número de horas impartidas"></label>
                    <input type="text" class="form-control" id="taught_hours" name="taught_hours"
                           data-translate="Número de horas impartidas"
                           required maxlength="5" oninput="checkTaughtHoursSubject(this)" value="<?php echo $this->subject->getHorasEnseño() ?>">
                </div>
                <div id="hours-div" class="form-group">
                    <label for="hours" data-translate="Número de horas"></label>
                    <input type="text" class="form-control" id="hours" name="hours"
                           data-translate="Número de horas"
                           required maxlength="5" oninput="checkHoursSubject(this)" value="<?php echo $this->subject->getHoras() ?>">
                </div>
                <div id="students-div" class="form-group">
                    <label for="students" data-translate="Estudiantes"></label>
                    <input type="number" class="form-control" id="students" name="students"
                           data-translate="Estudiantes"
                           required maxlength="3" oninput="checkStudentsSubject(this)" value="<?php echo $this->subject->getAlumnos() ?>">
                </div>
                <div class="form-group">
                    <label for="degree_id" data-translate="Titulación"></label>
                    <select class="form-control" id="degree_id" name="degree_id" ?>
                        <?php foreach ($this->degrees as $degree): ?>
                            <option value="" data-translate="Seleccione"></option>
                            <option value="<?php echo $degree->getId() ?>"
                                <?php if($degree->getId() == $this->subject->getGrado()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $degree->getNombre(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="teacher_id" data-translate="Profesor responsable"></label>
                    <select class="form-control" id="teacher_id" name="teacher_id" ?>
                        <?php foreach ($this->teachers as $teacher): ?>
                            <option value="" data-translate="Seleccione"></option>
                            <option value="<?php echo $teacher->getId() ?>"
                                <?php if($teacher->getId() == $this->subject->getProfesor()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $teacher->getUsuario()->getNombre()." ". $teacher->getUsuario()->getApellido() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
<?php
    }
}
?>
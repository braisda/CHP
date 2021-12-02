<?php

class UniversityEditView
{
    private $academicCourses;
    private $university;
    private $users;

    function __construct($universityData, $academicCourses, $users)
    {
        $this->academicCourses = $academicCourses;
        $this->university = $universityData;
        $this->users = $users;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <script src="../js/validations/universityValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Editar universidad '%<?php echo $this->university->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/universityController.php"><p
                            data-translate="Volver"></p></a>
            </div>
            <form id="universityForm" action='../controllers/universityController.php?action=edit&id=<?php echo $this->university->getId() ?>'
                  method='POST' onsubmit="areUniversityFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Nombre"
                           value="<?php echo $this->university->getNombre() ?>" required maxlength="30"
                           oninput="checkNameUniversity(this)">
                </div>
                <div class="form-group">
                    <label for="academic_course_id" data-translate="Curso académico"></label>
                    <select class="form-control" id="academic_course_id" name="academic_course_id" ?>
                        <?php foreach ($this->academicCourses as $academicCourse): ?>
                            <option value="<?php echo $academicCourse->getId() ?>"
                                <?php if ($academicCourse->getId() == $this->university->getIdCursoAcademico()->getId()) {
                                    echo 'selected="selected"';
                                } ?>>
                                <?php echo $academicCourse->getNombre(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="user_id" data-translate="Responsable"></label>
                    <select class="form-control" id="user_id" name="user_id" ?>
                        <?php foreach ($this->users as $user): ?>
                            <option value="<?php echo $user->getId() ?>"
                                <?php if ($user->getId() == $this->university->getIdUsuario()->getId()) {
                                    echo 'selected="selected"';
                                } ?>>
                                <?php echo $user->getNombre()." ".$user->getApellido(); ?>
                            </option>
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

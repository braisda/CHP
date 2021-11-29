<?php
class AcademicCourseSearchView {

    function __construct(){
        $this->render();
    }
    function render(){
        ?>
        <head>
            <script src="../js/validations/academicCourseValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Búsqueda de cursos académicos"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/academicCourseController.php" ><p data-translate="Volver"></p></a>
            </div>
            <form id="academicCourseSearchForm" action='../controllers/academicCourseController.php?action=search' method='POST' onsubmit="return areAcademicCourseSearchFieldsCorrect()">
                <div  id="end-abbreviate-div" class="form-group">
                    <label for="academic_course_abbr" data-translate="Abreviatura de curso académico"></label>
                    <input type="text" class="form-control" id="academic_course_abbr" name="academic_course_abbr"
                           data-translate="Introducir abreviatura de curso académico">
                </div>
                <div id="start-year-div" class="form-group">
                    <label for="start_year" data-translate="Año de inicio"></label>
                    <input type="number" min="2000" max="9999" class="form-control" id="start_year" name="start_year"
                           data-translate="Introducir año de inicio" oninput="checkStartYearEmptyAcademicCourse(this)">
                </div>
                <div  id="end-year-div" class="form-group">
                    <label for="end_year" data-translate="Año de fin"></label>
                    <input type="number"  min="2000" max="9999" class="form-control" id="end_year" name="end_year"
                           data-translate="Introducir año de fin" oninput="checkEndYearEmptyAcademicCourse(this)">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
?>


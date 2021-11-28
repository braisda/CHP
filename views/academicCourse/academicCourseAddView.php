<?php
class AcademicCourseAddView {

function __construct(){
    $this->render();
}
function render(){
?>
<head>
    <script src="../utils/validations/academicCourseValidations.js"></script>
</head>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h1 class="h2" data-translate="Añadir curso académico"></h1>
            <a class="btn btn-primary" role="button" href="../Controllers/AcademicCourseController.php"><p data-translate="Volver"></p></a>
        </div>
        <form  id="academicCourseForm" name = "ADD" action='../controllers/academicCourseController.php?action=add' method='POST' onsubmit="return areAcademicCourseFieldsCorrect()">
            <div id="start-year-div" class="form-group">
                <label for="anoinicio" data-translate="Año de inicio"></label>
                <input type="number" min="2000" max="9999" class="form-control" id="anoinicio" name="anoinicio"
                       data-translate="Introducir año de inicio" oninput="checkStartYearEmptyAcademicCourse(this)" required>
            </div>
            <div id="end-year-div" class="form-group">
                <label for="anofin" data-translate="Año de fin"></label>
                <input type="number"  min="2000" max="9999" class="form-control" id="anofin" name="anofin"
                       data-translate="Introducir año de fin" oninput="checkEndYearEmptyAcademicCourse(this)" required>
            </div>
            <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
        </form>
    </main>
<?php
    }
}
?>

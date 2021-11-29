<?php
class AcademicCourseAddView {

    function __construct(){
        $this->render();
    }

    function render(){
            ?>
<!DOCTYPE html>
<html>
<head>
    <script src="../js/validations/academicCourseValidations.js"></script>
</head>
<body>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h2 data-translate="Añadir curso académico"></h2>
            <a class="btn btn-primary" role="button" href="../controllers/academicCourseController.php"><p data-translate="Volver"></p></a>
        </div>
        <form  id="academicCourseForm" action='../controllers/academicCourseController.php?action=add' method='POST' onsubmit="return areAcademicCourseFieldsCorrect()">
            <div id="start-year-div" class="form-group">
                <label for="anoinicio" data-translate="Año de inicio"></label>
                <input type="number" min="2000" max="9999" class="form-control" id="anoinicio" name="anoinicio"
                       data-translate="Año de inicio" required oninput="checkStartYearEmptyAcademicCourse(this);"/>
            </div>
            <div id="end-year-div" class="form-group">
                <label for="anofin" data-translate="Año de fin"></label>
                <input type="number"  min="2000" max="9999" class="form-control" id="anofin" name="anofin"
                       data-translate="Año de fin" required oninput="checkEndYearEmptyAcademicCourse(this);"/>
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

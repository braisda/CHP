<?php
class AcademicCourseEditView {

    private $academicCourse;

    function __construct($academicCourseData){
        $this->academicCourse = $academicCourseData;
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
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
            <h2 data-translate="Editar curso académico '%<?php echo $this->academicCourse->getNombre()?>%'"></h2>
            <a class="btn btn-primary" role="button" href="../controllers/academicCourseController.php"><p data-translate="Volver"></p></a>
        </div>
        <form id="academicCourseEditForm" action='../controllers/academicCourseController.php?action=edit' method='POST' onsubmit="return areAcademicCourseEditFieldsCorrect()">
                <div class="form-group">
                    <label for="IdAcademicCourse" data-translate="Identificador"></label>
                    <input type="hidden" name="id" value="<?php echo $this->academicCourse->getId() ?>" >
                    <input type="text" class="form-control" id="academicCourseAbbr" name="academicCourseAbbr"
                           value="<?php echo $this->academicCourse->getNombre() ?>" readonly>
                </div>
                <div id="start-year-div" class="form-group">
                    <label for="anoinicio" data-translate="Año de inicio"></label>
                    <input type="number" min="2000" max="9999" class="form-control" id="anoinicio" name="anoinicio"
                           value="<?php echo $this->academicCourse->getAnoinicio() ?>" required oninput="checkStartYearEmptyAcademicCourse(this)">
                </div>
                <div id="end-year-div" class="form-group">
                    <label for="anofin" data-translate="Año de fin"></label>
                    <input type="number" min="2000" max="9999" class="form-control" id="anofin" name="anofin"
                           value="<?php echo $this->academicCourse->getAnofin() ?>" oninput="checkEndYearEmptyAcademicCourse(this)" required>
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

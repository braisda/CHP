<?php
class AcademicCourseEditView {
    private $academicCourse;
    function __construct($academicCourseData){
        $this->academicCourse = $academicCourseData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <script src="../utils/validations/academicCourseValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2" data-translate="Editar curso académico '%<?php echo $this->academicCourse->getNombre()?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/academicCourseController.php"><p data-translate="Volver"></p></a>
            </div>
            <form id="academicCourseEditForm" name = "EDIT" action='../controllers/academicCourseController.php?action=edit' method='POST' onsubmit="return areAcademicCourseEditFieldsCorrect()">
                <div class="form-group">
                    <label for="IdAcademicCourse" data-translate="Identificador"></label>
                    <input type="hidden" name="id" value="<?php echo $this->academicCourse->getId() ?>" >
                    <input type="text" class="form-control" id="academicCourseAbbr" name="academicCourseAbbr"
                           value="<?php echo $this->academicCourse->getNombre() ?>" readonly>
                </div>
                <div id="start-year-div" class="form-group">
                    <label for="start_year" data-translate="Año de inicio"></label>
                    <input type="number" min="2000" max="9999" class="form-control" id="anoinicio" name="anoinicio"
                           value="<?php echo $this->academicCourse->getAnoinicio() ?>" oninput="checkStartYearEmptyAcademicCourse(this)" required >
                </div>
                <div id="end-year-div" class="form-group">
                    <label for="end_year" data-translate="Año de fin"></label>
                    <input type="number" min="2000" max="9999" class="form-control" id="anofin" name="anofin"
                           value="<?php echo $this->academicCourse->getAnofin() ?>" oninput="checkEndYearEmptyAcademicCourse(this)" required >
                </div>

                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
?>

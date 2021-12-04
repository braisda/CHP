<?php
class AcademicCourseShowView {
private $academicCourse;
    function __construct($academicCourseData){
        $this->academicCourse = $academicCourseData;
        $this->render();
    }
    function render(){
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h1 class="h2" data-translate="Curso académico '%<?php echo $this->academicCourse->getNombre()?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/academicCourseController.php"><p data-translate="Volver"></p></a>
            </div>
            <?php if(!is_null($this->academicCourse)): ?>
            <form>
                <div class="form-group">
                    <label for="IdAcademicCourse" data-translate="Identificador"></label>
                    <input type="text" class="form-control" id="academicCourseAbbr" name="academicCourseAbbr"
                           value="<?php echo $this->academicCourse->getNombre() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="start_year" data-translate="Año de inicio"></label>
                    <input type="text" class="form-control" id="start_year" name="start_year"
                           value="<?php echo $this->academicCourse->getAnoinicio() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="end_year" data-translate="Año de fin"></label>
                    <input type="text" class="form-control" id="end_year" name="end_year"
                           value="<?php echo $this->academicCourse->getAnofin() ?>" readonly>
                </div>
            </form>
            <?php else: ?>
                <p data-translate="El curso académico no existe">. </p>
            <?php endif; ?>
        </main>
        <?php
    }
}
?>
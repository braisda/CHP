<?php
class UniversityShowView {
    private $university;

    function __construct($universityData){
        $this->university = $universityData;
        $this->render();
    }
    function render(){
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Universidad '%<?php echo $this->university->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/UniversityController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../controllers/UniversityController.php?action=show' method='POST'>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre"
                           value="<?php echo $this->university->getNombre() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="academic_course_id" data-translate="Curso académico"></label>
                    <input type="text" class="form-control" id="name" name="name" data-translate="Introducir curso académico"
                           value="<?php echo $this->university->getIdCursoAcademico()->getNombre() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="user_id" data-translate="Responsable"></label>
                    <input type="text" class="form-control" id="user_id" name="user_id"
                           value="<?php echo $this->university->getIdUsuario()->getNombre() . " " . $this->university->getIdUsuario()->getApellido() ?>" readonly>
                </div>
            </form>
        </main>
        <?php
    }
}
?>

<?php
class TutorialShowView {
    private $tutorial;

    function __construct($tutorialData){
        $this->tutorial = $tutorialData;
        $this->render();
    }
    function render(){
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Tutoría '%<?php echo $this->tutorial->getIdtutoria() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/tutorialController.php"><p data-translate="Volver"></p></a>
            </div>
            <?php if(!is_null($this->tutorial)): ?>
            <form>
                <div class="form-group">
                    <label for="profesor" data-translate="Profesor"></label>
                    <input type="text" class="form-control" id="profesor" name="profesor"
                           value="<?php echo $this->tutorial->getIdprofesor()->getUsuario()->getLogin() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="start-date" data-translate="Inicio"></label>
                    <input type="text" class="form-control" id="start-date" name="start-date"
                           value="<?php echo $this->tutorial->getFechainicio() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="end-date" data-translate="Fin"></label>
                    <input type="text" class="form-control" id="end-date" name="end-date"
                           value="<?php echo $this->tutorial->getFechafin() ?>" readonly>
                </div>
            </form>
            <?php else: ?>
                <p data-translate="La tutoría no existe">.</p>
            <?php endif; ?>
        </main>
        <?php
    }
}
?>

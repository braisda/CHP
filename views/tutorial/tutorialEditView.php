<?php

class TutorialEditView
{
    private $tutorial;
    private $teachers;
    private $inicio;

    function __construct($tutorialData, $teachersData)
    {
        $this->tutorial = $tutorialData;
        $this->teachers = $teachersData;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <script src="../js/validations/tutorialValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Editar tutoría '%<?php echo $this->tutorial->getIdtutoria() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/tutorialController.php"><p
                            data-translate="Volver"></p></a>
            </div>
            <form id="tutorialForm" action='../controllers/tutorialController.php?action=edit&idtutoria=<?php echo $this->tutorial->getIdtutoria() ?>'
                  method='POST'>
                <div class="form-group col-12">
                    <label for="teacher_id" data-translate="Profesor"></label>
                    <select class="form-control" id="teacher_id" name="teacher_id" ?>
                        <?php foreach ($this->teachers as $t): ?>
                            <option value="<?php echo $t->getId() ?>">
                                <?php echo $t->getUsuario()->getLogin() ?>
                                <?php if ($t->getId() == $this->tutorial->getIdprofesor()->getUsuario()->getLogin()) {
                                    echo 'selected="selected"';
                                } ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>                                
                <div id="start-year-div" class="form-group col-12">
                    <label for="start_date" data-translate="Inicio"></label>
                    <input type="datetime-local" min="2000" max="9999" class="form-control" id="start_date" name="start_date"
                    value="<?php echo substr($this->tutorial->getFechainicio(), 0, -9)."T".substr($this->tutorial->getFechainicio(), -8, 9) ?>" required>
                </div>
                <div id="end-year-div" class="form-group col-12">
                    <label for="end_date" data-translate="Fin"></label>
                    <input type="datetime-local" min="2000" max="9999" class="form-control" id="end_date" name="end_date"
                    value="<?php echo substr($this->tutorial->getFechafin(), 0, -9)."T".substr($this->tutorial->getFechafin(), -8, 9) ?>" required>
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>

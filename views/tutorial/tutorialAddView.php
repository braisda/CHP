<?php

class TutorialAddView
{
    private $teachers;

    function __construct($teachers)
    {
        $this->teachers = $teachers;
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
                <h1 class="h2" data-translate="Añadir tutoría"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/tutorialController.php"><p
                            data-translate="Volver"></p></a>
            </div>
            <form id="tutorialForm" action='../controllers/tutorialController.php?action=add' method='POST'>
                <div class="form-group col-12">
                    <label for="teacher_id" data-translate="Profesor"></label>
                    <select class="form-control" id="teacher_id" name="teacher_id" ?>
                        <option value="" data-translate="Seleccione"></option>
                        <?php foreach ($this->teachers as $t): ?>
                            <option value="<?php echo $t->getId() ?>"><?php echo $t->getUsuario()->getNombre() ?> <?php echo $t->getUsuario()->getApellido() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>                                
                <div id="start-year-div" class="form-group col-12">
                    <label for="start_date" data-translate="Inicio"></label>
                    <input type="datetime-local" min="2000" max="9999" class="form-control" id="start_date" name="start_date">
                </div>
                <div id="end-year-div" class="form-group col-12">
                    <label for="end_date" data-translate="Fin"></label>
                    <input type="datetime-local" min="2000" max="9999" class="form-control" id="end_date" name="end_date">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>

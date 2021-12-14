<?php

class GroupAddView
{
    private $subjects;

    function __construct($subjects)
    {
        $this->subjects = $subjects;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <script src="../js/validations/groupValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Añadir grupo"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/groupController.php"><p
                            data-translate="Volver"></p></a>
            </div>
            <form id="groupForm" action='../controllers/groupController.php?action=add' method='POST'
            >
                <div class="form-group col-12">
                    <label for="subject" data-translate="Asignatura"></label>
                    <select class="form-control" id="subject" name="subject" ?>
                        <option value="" data-translate="Seleccione"></option>
                        <?php foreach ($this->subjects as $s): ?>
                            <option value="<?php echo $s->getId() ?>"><?php echo $s->getCodigo() ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>                                
                <div class="form-group col-12">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name"  maxlength="30" oninput="checkNameGroup(this)">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>

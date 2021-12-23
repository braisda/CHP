<?php

class DepartmentAddView
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
            <script src="../js/validations/departmentValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Añadir departamento"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/departmentController.php"><p
                            data-translate="Volver"></p></a>
            </div>
            <form id="departmentForm" action='../controllers/departmentController.php?action=add' method='POST'>
                <div id="code-div" class="form-group col-12">
                    <label for="start_date" data-translate="Código"></label>
                    <input type="text" max-length="30" class="form-control" id="code" name="code" required oninput="checkCodeDepartment(this)">
                </div> 
                <div class="form-group col-12">
                    <label for="teacher_id" data-translate="Profesor"></label>
                    <select class="form-control" id="teacher_id" name="teacher_id" ?>
                        <option value="" data-translate="Seleccione"></option>
                        <?php foreach ($this->teachers as $t): ?>
                            <option value="<?php echo $t->getId() ?>"><?php echo $t->getUsuario()->getNombre() ?> <?php echo $t->getUsuario()->getApellido() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>                                
                <div id="name-div" class="form-group col-12">
                    <label for="end_date" data-translate="Nombre"></label>
                    <input type="text" max-length="30" class="form-control" id="name" name="name" required oninput="checkNameDepartment(this)">
                </div>
                
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>

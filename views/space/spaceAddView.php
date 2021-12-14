<?php

class SpaceAddView
{
    private $buildings;

    function __construct($buildings)
    {
        $this->buildings = $buildings;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <script src="../js/validations/spaceValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Añadir espacio"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/spaceController.php"><p
                            data-translate="Volver"></p></a>
            </div>
            <form id="spaceForm" action='../controllers/spaceController.php?action=add' method='POST'
            >
                <div class="form-group col-12">
                    <label for="building" data-translate="Edificio"></label>
                    <select class="form-control" id="building" name="building" ?>
                        <option value="" data-translate="Seleccione"></option>
                        <?php foreach ($this->buildings as $b): ?>
                            <option value="<?php echo $b->getId() ?>"><?php echo $b->getNombre() ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>                                
                <div class="form-group col-12">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group col-12">
                    <label for="capacity" data-translate="Capacidad"></label>
                    <input type="number" class="form-control" id="capacity" name="capacity">
                </div>
                <div class="form-group col-12">
                    <label for="oficina" data-translate="Oficina"></label>
                    <br/>
                    <input type="checkbox" class="office-checkbox" id="office" name="office">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>

<?php

class SpaceEditView
{
    private $space;
    private $buildings;

    function __construct($spaceData, $buildingsData)
    {
        $this->space = $spaceData;
        $this->buildings = $buildingsData;
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
                <h1 class="h2" data-translate="Editar espacio '%<?php echo $this->space->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/spaceController.php">
                    <p data-translate="Volver"></p>
                </a>
            </div>
            <form id="spaceForm" action='../controllers/spaceController.php?action=edit&id=<?php echo $this->space->getId() ?>' method='POST'
            onsubmit="return areSpaceFieldsCorrect()">
            <div class="form-group col-12">
                <label for="building" data-translate="Edificio"></label>
                <select class="form-control" id="building" name="building" ?>

                    <?php foreach ($this->buildings as $b): ?>
                        <option value="<?php echo $b->getId() ?>"
                        <?php if ($b->getId() == $this->space->getIdedificio()->getId()) {
                                echo 'selected="selected"';
                        } ?>>
                        <?php echo $b->getNombre() ?>
                    <?php endforeach; ?>

                </select>
            </div>
            <div id="name-div" class="form-group col-12">
                <label for="name" data-translate="Nombre"></label>
                <input type="text" class="form-control" id="name" name="name"
                value="<?php echo $this->space->getNombre() ?>" required maxlength="30" oninput="checkNameSpace(this)">
            </div>
            <div id="capacity-div" class="form-group col-12">
                <label for="capacity" data-translate="Capacidad"></label>
                <input type="number" class="form-control" id="capacity" name="capacity" min="1" max="999"
                value="<?php echo $this->space->getCapacidad() ?>" required oninput="checkCapacitySpace(this)">
            </div>
            <div id="office-div" class="form-group col-12">
                <label for="office" data-translate="Oficina"></label>
                <br/>
                <input type="checkbox" class="office-checkbox" id="office" name="office"
                    <?php if($this->space->isOffice()) echo "checked"?> >
            </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
<?php
    }
}

?>
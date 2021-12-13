<?php

class BuildingAddView
{
    private $users;

    function __construct($users)
    {
        $this->users = $users;
        $this->render();
    }

    function render()
    {
        ?>
        <head>
            <script src="../js/validations/buildingValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Añadir edificio"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/buildingController.php"><p
                            data-translate="Volver"></p></a>
            </div>
            <form id="buildingForm" action='../controllers/buildingController.php?action=add' method='POST'
            onsubmit="return areBuildingFieldsCorrect()">
                <div class="form-group col-12">
                    <label for="user" data-translate="Responsable"></label>
                    <select class="form-control" id="user" name="user" ?>
                        <option value="" data-translate="Seleccione"></option>
                        <?php foreach ($this->users as $u): ?>
                            <option value="<?php echo $u->getLogin() ?>"><?php echo $u->getNombre() ?> <?php echo $u->getApellido() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>                                
                <div id="location-div" class="form-group col-12">
                    <label for="location" data-translate="Localización"></label>
                    <input type="text" class="form-control" id="location" name="location" maxlength="30" oninput="checkLocationBuilding(this)">
                </div>
                <div id="name-div" class="form-group col-12">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name" maxlength="30" oninput="checkNameBuilding(this)">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}

?>

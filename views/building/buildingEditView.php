<?php

class BuildingEditView
{
    private $building;
    private $users;

    function __construct($buildingData, $usersData)
    {
        $this->building = $buildingData;
        $this->users = $usersData;
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
                <h1 class="h2" data-translate="Editar edificio '%<?php echo $this->building->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/buildingController.php">
                    <p data-translate="Volver"></p>
                </a>
            </div>
            <form id="buildingForm" action='../controllers/buildingController.php?action=edit&id=<?php echo $this->building->getId() ?>' method='POST'
            onsubmit="return areBuildingFieldsCorrect()">
                <div class="form-group col-12">
                    <label for="user_id" data-translate="Responsable"></label>
                    <select class="form-control" id="user_id" name="user_id" ?>
                        
                        <?php foreach ($this->users as $user): ?>
                            <option value="<?php echo $user->getId() ?>"
                                <?php if ($user->getId() == $this->building->getIdUsuario()->getId()) {
                                    echo 'selected="selected"';
                                } ?>>
                                <?php echo $user->getNombre()." ".$user->getApellido(); ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>
                <div id="location-div" class="form-group col-12">
                    <label for="location" data-translate="Localización"></label>
                    <input type="text" class="form-control" id="location" name="location"
                        value="<?php echo $this->building->getLocalizacion() ?>" maxlength="30" required oninput="checkLocationBuilding(this)">
                </div>
                <div id="name-div" class="form-group col-12">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="<?php echo $this->building->getnombre() ?>" maxlength="30" required oninput="checkNameBuilding(this)">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
<?php
    }
}

?>
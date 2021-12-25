<?php
class CenterEditView {

    private $universities;
    private $center;
    private $users;
    private $buildings;

    function __construct($centerData, $universities, $users, $buildingData){
        $this->universities = $universities;
        $this->center = $centerData;
        $this->users=$users;
        $this->buildings=$buildingData;
        $this->render();
    }

    function render(){
        ?>
       <head>
            <script src="../js/validations/centerValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h2 data-translate="Editar centro '%<?php echo $this->center->getNombre()?>%'"></h2>
                <a class="btn btn-primary" role="button" href="../controllers/centerController.php" data-translate="Volver"></a>
            </div>
            <form  name = "centerForm" action='../controllers/centerController.php?action=edit&id=<?php echo $this->center->getId()?>' method='POST' onsubmit="return areCenterFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="nombre" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" data-translate="Nombre"
                           value="<?php echo $this->center->getNombre() ?>" required maxlength="30" oninput="checkNameCenter(this)">
                </div>
                <div class="form-group">
                    <label for="idUniversidad" data-translate="Universidad"></label>
                    <select class="form-control" id="idUniversidad" name="idUniversidad" required>
                        <?php foreach ($this->universities as $university): ?>
                            <option value="<?php echo $university->getId()?>"
                                <?php if($university->getId() == $this->center->getUniversidad()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $university->getNombre(); ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="idEdificio" data-translate="Edificio"></label>
                    <select class="form-control" id="idEdificio" name="idEdificio" required>
                        <?php foreach ($this->buildings as $building): ?>
                            <option value="<?php echo $building->getId()?>"
                                <?php if($building->getId() == $this->center->getEdificio()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $building->getNombre(); ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="idUsuario" data-translate="Responsable"></label>
                    <select class="form-control" id="idUsuario" name="idUsuario" required>
                        <?php foreach ($this->users as $user): ?>
                            <option value="<?php echo $user->getId()?>"
                                <?php if($user->getId() == $this->center->getUsuario()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $user->getNombre()." ".$user->getApellido(); ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Editar"></button>
            </form>
        </main>
<?php
    }
}
?>
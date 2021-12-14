<?php
class BuildingShowView {
    private $building;

    function __construct($buildingData){
        $this->building = $buildingData;
        $this->render();
    }
    function render(){
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Edificio '%<?php echo $this->building->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/buildingController.php"><p data-translate="Volver"></p></a>
            </div>
            <?php if(!is_null($this->building)): ?>
            <form>
                <div class="form-group">
                    <label for="usuario" data-translate="Responsable"></label>
                    <input type="text" class="form-control" id="usuario" name="usuario"
                           value="<?php echo $this->building->getIdusuario()->getNombre() ?> <?php echo $this->building->getIdusuario()->getApellido() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="location" data-translate="Localización"></label>
                    <input type="text" class="form-control" id="location" name="location"
                           value="<?php echo $this->building->getLocalizacion() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="end-date" name="name"
                           value="<?php echo $this->building->getNombre() ?>" readonly>
                </div>
            </form>
            <?php else: ?>
                <p data-translate="El edificio no existe">.</p>
            <?php endif; ?>
        </main>
        <?php
    }
}
?>

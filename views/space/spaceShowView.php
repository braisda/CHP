<?php
class SpaceShowView {
    private $space;

    function __construct($spaceData){
        $this->space = $spaceData;
        $this->render();
    }
    function render(){
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Espacio '%<?php echo $this->space->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/spaceController.php"><p data-translate="Volver"></p></a>
            </div>
            <?php if(!is_null($this->space)): ?>
            <form>
                <div class="form-group">
                    <label for="building" data-translate="Edificio"></label>
                    <input type="text" class="form-control" id="building" name="building"
                           value="<?php echo $this->space->getIdedificio()->getNombre() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->space->getNombre() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="capacity" data-translate="Capacidad"></label>
                    <input type="text" class="form-control" id="capacity" name="capacity"
                           value="<?php echo $this->space->getCapacidad() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="oficina" data-translate="Oficina"></label>
                    <br/>
                    <input type="checkbox" class="office-checkbox" id="office" name="office"
                        <?php if($this->space->isOffice()) echo "checked"?> onclick="return false;">
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

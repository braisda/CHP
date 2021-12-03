<?php
class CenterShowView {

    private $center;

    function __construct($centerData){
        $this->center = $centerData;
        $this->render();
    }
    function render(){
        ?>
<!DOCTYPE html>
<html>
    <body>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 data-translate="Centro '%<?php echo $this->center->getNombre() ?>%'"></h2>
                <a class="btn btn-primary" role="button" href="../controllers/centerController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../controllers/centerController.php?action=show' method='POST'>
                 <div class="form-group">
                     <label for="nombre" data-translate="Nombre"></label>
                     <input type="text" class="form-control" id="nombre" name="nombre" data-translate="Nombre"
                            value="<?php echo $this->center->getNombre() ?>" readonly>
                 </div>
                 <div class="form-group">
                     <label for="idUniversidad" data-translate="Universidad"></label>
                     <input type="text" class="form-control" id="idUniversidad" name="idUniversidad" data-translate="Universidad"
                            value="<?php echo $this->center->getUniversidad()->getNombre() ?>" readonly>
                 </div>
                 <div class="form-group">
                     <label for="idEdificio" data-translate="Edificio"></label>
                     <input type="text" class="form-control" id="idEdificio" name="idEdificio" data-translate="Edificio"
                            value="<?php echo $this->center->getEdificio()->getNombre() ?>" readonly>
                 </div>
                 <div class="form-group">
                     <label for="idUsuario" data-translate="Responsable"></label>
                     <input type="text" class="form-control" id="idUsuario" name="idUsuario" data-translate="Responsable"
                            value="<?php echo $this->center->getUsuario()->getNombre()." ".$this->center->getUsuario()->getApellido() ?>" readonly>
                 </div>
             </form>
        </main>
    </body>
</html>
<?php
    }
}
?>
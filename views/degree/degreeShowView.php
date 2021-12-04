<?php

class DegreeShowView {

    private $degree;

    function __construct($degreeData) {
        $this->degree = $degreeData;
        $this->render();
    }

    function render() {
        ?>
<!DOCTYPE html>
<html>
    <body>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 data-translate="Grado '%<?php echo $this->degree->getNombre() ?>%'"></h2>
                <a class="btn btn-primary" role="button" href="../controllers/degreeController.php"><p data-translate="Volver"></p></a>
            </div>
            <form action='../controllers/degreeController.php?action=show' method='POST'>
                <div class="form-group">
                    <label for="nombre" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" data-translate="Nombre"
                           value="<?php echo $this->degree->getNombre() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="idCentro" data-translate="Centro"></label>
                    <input type="text" class="form-control" id="idCentro" name="idCentro"
                           data-translate="Centro" value="<?php echo $this->degree->getCentro()->getNombre() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="idUsuario" data-translate="Responsable"></label>
                    <input type="text" class="form-control" id="idUsuario" name="idUsuario" data-translate="Responsable"
                           value="<?php echo $this->degree->getUsuario()->getNombre() . " " . $this->degree->getUsuario()->getApellido() ?>"
                           readonly>
                </div>
                <div class="form-group">
                    <label for="plazas" data-translate="Plazas"></label>
                    <input type="text" class="form-control" id="plazas" name="plazas" data-translate="Plazas"
                           value="<?php echo $this->degree->getCapacidad() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="creditos" data-translate="Créditos"></label>
                    <input type="text" class="form-control" id="creditos" name="creditos" data-translate="Créditos"
                           value="<?php echo $this->degree->getCreditos() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="descripcion" data-translate="Descripción"></label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion"
                           value="<?php echo $this->degree->getDescripcion() ?>" readonly>
                </div>
            </form>
        </main>
    </body>
</html>
<?php
    }
}
?>
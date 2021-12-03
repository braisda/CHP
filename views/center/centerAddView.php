<?php
class CenterAddView {

    private $universities;
    private $users;
    private $buildings;

    function __construct($universitiesData, $users, $buildingData){
        $this->universities = $universitiesData;
        $this->users=$users;
        $this->buildings=$buildingData;
        $this->render();
    }
    function render(){
        ?>
<!DOCTYPE html>
<html>
<head>
    <script src="../js/validations/centerValidations.js"></script>
</head>
<body>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
            <h2 data-translate="Añadir centro"></h2>
            <a class="btn btn-primary" role="button" href="../controllers/centerController.php" data-translate="Volver"></a>
        </div>
        <form id="centerForm" action='../controllers/centerController.php?action=add' method='POST'>
            <div id="name-div" class="form-group">
                <label for="name" data-translate="Nombre"></label>
                <input type="text" class="form-control" id="nombre" name="nombre" data-translate="Nombre"
                    required maxlength="30" oninput="checkNameCenter(this)">
            </div>
            <div class="form-group">
                <label for="idUniversidad" data-translate="Universidad"></label>
                <select class="form-control" id="idUniversidad" name="idUniversidad" required>
                    <option value="" data-translate="Seleccione"></option>
                    <?php foreach ($this->universities as $university): ?>
                        <option value="<?php echo $university->getId() ?>"><?php echo $university->getNombre() ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="idEdificio" data-translate="Edificio"></label>
                <select class="form-control" id="idEdificio" name="idEdificio" required>
                    <option value="" data-translate="Seleccione"></option>
                    <?php foreach ($this->buildings as $building): ?>
                        <option value="<?php echo $building->getId() ?>"><?php echo $building->getNombre() ?></option>
                    <?php endforeach;?>
                </select>                </div>
            <div class="form-group">
                <label for="idUsuario" data-translate="Responsable"></label>
                <select class="form-control" id="idUsuario" name="idUsuario" required>
                    <option value="" data-translate="Seleccione"></option>
                    <?php foreach ($this->users as $user): ?>
                        <option value="<?php echo $user->getId() ?>"><?php echo $user->getNombre()." ".$user->getApellido() ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
        </form>
    </main>
</body>
</html>
<?php
    }
}
?>
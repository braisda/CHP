<?php

class DegreeAddView {

    private $centers;
    private $users;
    private $description;
    private $credits;

    function __construct($centersData, $users)
    {
        $this->centers = $centersData;
        $this->users = $users;
        $this->render();
     }

    function render() {
        ?>
<!DOCTYPE html>
<html>
<head>
    <script src="../js/validations/degreeValidations.js"></script>
</head>
<body>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
            <h2 data-translate="Añadir titulación"></h2>
            <a class="btn btn-primary" role="button" href="../controllers/degreeController.php" data-translate="Volver"></a>
        </div>
        <form id="degreeForm" action='../controllers/degreeController.php?action=add' method='POST' onsubmit="return areDegreeFieldsCorrect()" >
            <div id="name-div" class="form-group">
                <label for="nombre" data-translate="Nombre"></label>
                <input type="text" class="form-control" id="nombre" name="nombre" data-translate="Nombre"
                       required maxlength="30" oninput="checkNameDegree(this)">
            </div>
            <div class="form-group">
                <label for="idCentro" data-translate="Centro"></label>
                <select class="form-control" id="idCentro" name="idCentro" required>
                    <option value="" data-translate="Seleccione"></option>
                    <?php foreach ($this->centers as $center): ?>
                        <option value="<?php echo $center->getId() ?>"><?php echo $center->getNombre() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="idUsuario" data-translate="Responsable"></label>
                <select class="form-control" id="idUsuario" name="idUsuario" required>
                    <option value="" data-translate="Seleccione"></option>
                    <?php foreach ($this->users as $user): ?>
                        <option value="<?php echo $user->getLogin() ?>"><?php echo $user->getNombre() . " " . $user->getApellido() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="places-div" class="form-group">
                <label for="plazas" data-translate="Plazas"></label>
                <input type="number" min="0" max="999" class="form-control" id="plazas" name="plazas"
                       data-translate="Plazas" required maxlength="3" oninput="checkCapacityDegree(this)">
            </div>
            <div id="credits-div" class="form-group">
                <label for="creditos" data-translate="Créditos"></label>
                <input type="number" min="0" max="999" class="form-control" id="creditos" name="creditos"
                       data-translate="Créditos" required maxlength="3" oninput="checkCreditsDegree(this)">
            </div>
            <div id="description-div" class="form-group">
                <label for="descripcion" data-translate="Descripción"></label>
                <input type="text" class="form-control" id="descripcion" name="descripcion"
                       data-translate="Descripción" maxlength="50" required oninput="checkDescriptionDegree(this);">
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
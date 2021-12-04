<?php

class DegreeEditView {

    private $centers;
    private $degree;
    private $users;

    function __construct($degreeData, $centers, $users) {
        $this->centers = $centers;
        $this->degree = $degreeData;
        $this->users = $users;
        $this->render();
    }

    function render() {
        ?>
        <head>
            <script src="../js/validations/degreeValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h2 data-translate="Editar titulación '%<?php echo $this->degree->getNombre()?>%'"></h2>
                <a class="btn btn-primary" role="button" href="../controllers/degreeController.php" data-translate="Volver"></a>
            </div>
            <form id="degreeForm" action='../controllers/degreeController.php?action=edit&id=<?php echo $this->degree->getId() ?>' method='POST' onsubmit="areDegreeFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="nombre" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" data-translate="Nombre"
                           value="<?php echo $this->degree->getNombre() ?>" required maxlength="30"
                           oninput="checkNameDegree(this)">
                </div>
                <div class="form-group">
                    <label for="idCentro" data-translate="Centro"></label>
                    <select class="form-control" id="idCentro" name="idCentro" required>
                        <?php foreach ($this->centers as $center): ?>
                            <option value="<?php echo $center->getId() ?>"
                                <?php if ($center->getId() == $this->degree->getCentro()->getId()) {
                                    echo 'selected="selected"';
                                } ?>>
                                <?php echo $center->getNombre(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="idUsuario" data-translate="Responsable"></label>
                    <select class="form-control" id="idUsuario" name="idUsuario" required>
                        <?php foreach ($this->users as $user): ?>
                            <option value="<?php echo $user->getId() ?>"
                                <?php if ($user->getId() == $this->degree->getUsuario()->getId()) {
                                    echo 'selected="selected"';
                                } ?>>
                                <?php echo $user->getNombre() . " " . $user->getApellido(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="capacity-div" class="form-group">
                    <label for="plazas" data-translate="Plazas"></label>
                    <input type="number" min="0" max="999" class="form-control" id="plazas" name="plazas"
                           data-translate="Plazas"
                           value="<?php echo $this->degree->getCapacidad() ?>" required maxlength="3"
                           oninput="checkCapacityDegree(this)">
                </div>
                <div id="credits-div" class="form-group">
                    <label for="creditos" data-translate="Créditos"></label>
                    <input type="number" min="0" max="999" class="form-control" id="creditos" name="creditos"
                           data-translate="Créditos"
                           value="<?php echo $this->degree->getCreditos() ?>" required maxlength="3"
                           oninput="checkCreditsDegree(this)">
                </div>
                <div id="description-div" class="form-group">
                    <label for="descripcion" data-translate="Descripción"></label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion"
                           data-translate="Descripción"
                           value="<?php echo $this->degree->getDescripcion() ?>" max-length="100" required
                           oninput="checkDescriptionDegree(this);">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Editar"></button>
            </form>
        </main>
<?php
    }
}
?>
<?php
class FuncActionEditView {

    private $funcAction;
    private $actions;
    private $functionalities;

    function __construct($funcActionData, $actionsData, $functionalitiesData) {
        $this->funcAction = $funcActionData;
        $this->actions = $actionsData;
        $this->functionalities = $functionalitiesData;
        $this->render();
    }

    function render() {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h2 data-translate="Editar acción-funcionalidad '%<?php echo $this->funcAction->getId() ?>%'"></h2>
                <a class="btn btn-primary" role="button" href="../controllers/funcActionController.php" data-translate="Volver"></a>
            </div>
            <form action='../controllers/funcActionController.php?action=edit&id=<?php echo $this->funcAction->getId() ?>' method='POST'>
                <div class="form-group">
                    <label for="action_id" data-translate="Acción"></label>
                    <select class="form-control" id="action_id" name="action_id">
                        <option value="" data-translate="Seleccione"></option>
                        <?php foreach ($this->actions as $action): ?>
                            <option value="<?php echo $action->getId()?>"
                                <?php if($action->getId() == $this->funcAction->getAccion()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $action->getNombre(); ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="functionality_id" data-translate="Funcionalidad"></label>
                    <select class="form-control" id="functionality_id" name="functionality_id">
                        <option value="" data-translate="Seleccione"></option>
                        <?php foreach($this->functionalities as $func): ?>
                            <option value="<?php echo $func->getId()?>"
                                <?php if($func->getId() == $this->funcAction->getFuncionalidad()->getId()){echo 'selected="selected"';}?>>
                                <?php echo $func->getNombre(); ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
        <?php
    }
}
?>
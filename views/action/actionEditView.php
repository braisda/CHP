<?php
class ActionEditView {
    private $action;
    function __construct($actionData){
        $this->action = $actionData;
        $this->render();
    }
    function render(){
        ?>
        <head>
            <script src="../js/validations/actionValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3
            border-bottom">
                <h2 data-translate="Editar acción '%<?php echo $this->action->getId()?>%'"></h2>
                <a class="btn btn-primary" role="button" href="../controllers/actionController.php" data-translate="Volver"></a>
            </div>
            <form  name = "actionForm" action='../controllers/actionController.php?action=edit&id=<?php echo $this->action->getId()?>'
                   method='POST' onsubmit="return areActionFieldsCorrect()">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->action->getNombre() ?>" maxlength="60" required oninput="checkNameAction(this);">
                </div>
                <div id="description-div" class="form-group">
                    <label for="description" data-translate="Descripción"></label>
                    <input type="text" class="form-control" id="description" name="description"
                           value="<?php echo $this->action->getDescripcion() ?>" maxlength="100" required oninput="checkDescriptionAction(this);">
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Editar"></button>
            </form>
        </main>
        <?php
    }
}
?>
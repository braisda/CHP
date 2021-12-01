<?php
class ActionAddView {

function __construct(){
    $this->render();
}
function render(){
?>
<head>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/forms.css" />
    <script src="../js/validations/actionValidations.js"></script>
</head>
    <main role="main" class="margin-main ml-sm-auto px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
            <h1 class="h2" data-translate="Añadir acción"></h1>
            <a class="btn btn-primary" role="button" href="../Controllers/ActionController.php" data-translate="Volver"></a>
        </div>
        <form id="actionForm" name = "ADD" action='../Controllers/ActionController.php?action=add' method='POST'
        onsubmit="return areActionFieldsCorrect()">
            <div id="name-div" class="form-group">
                <label for="name" data-translate="Nombre"></label>
                <input type="text" class="form-control" id="name" name="name" data-translate="Introducir nombre" 
				maxlength="60" required oninput="checkNameAction(this);">
            </div>
            <div id="description-div" class="form-group">
                <label for="description" data-translate="Descripción"></label>
                <input type="text" class="form-control" id="description" name="description" data-translate="Introducir descripción"  
				maxlength="100" required oninput="checkDescriptionAction(this);">
            </div>
            <button name="submit" type="submit" class="btn btn-primary" data-translate="Añadir"></button>
        </form>
    </main>

<?php
    }
}
?>

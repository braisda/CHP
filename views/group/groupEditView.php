<?php

class GroupEditView
{
    private $group;
    private $subjects;

    function __construct($groupData, $subjectsData)
    {
        $this->group = $groupData;
        $this->subjects = $subjectsData;
        $this->render();
    }

    function render()
    {
?>

        <head>
            <script src="../js/validations/groupValidations.js"></script>
        </head>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Editar espacio '%<?php echo $this->group->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/groupController.php">
                    <p data-translate="Volver"></p>
                </a>
            </div>
            <form id="groupForm" action='../controllers/groupController.php?action=edit&id=<?php echo $this->group->getId() ?>' method='POST'
            onsubmit="return areGroupFieldsCorrect()">
            <div class="form-group col-12">
                <label for="subject" data-translate="Asignatura"></label>
                <select class="form-control" id="subject" name="subject" ?>

                    <?php foreach ($this->subjects as $s): ?>
                        <option value="<?php echo $s->getId() ?>"
                        <?php if ($s->getId() == $this->group->getIdmateria()->getId()) {
                                echo 'selected="selected"';
                        } ?>>
                        <?php echo $s->getCodigo() ?>
                    <?php endforeach; ?>

                </select>
            </div>
            <div id="name-div" class="form-group col-12">
                <label for="name" data-translate="Nombre"></label>
                <input type="text" class="form-control" id="name" name="name"
                value="<?php echo $this->group->getNombre() ?>" required maxlength="30" oninput="checkNameGroup(this)">
            </div>
            </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
<?php
    }
}

?>
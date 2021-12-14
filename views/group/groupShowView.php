<?php
class GroupShowView {
    private $group;

    function __construct($groupData){
        $this->group = $groupData;
        $this->render();
    }
    function render(){
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h1 class="h2" data-translate="Grupo '%<?php echo $this->group->getId() ?>%'"></h1>
                <a class="btn btn-primary" role="button" href="../controllers/groupController.php"><p data-translate="Volver"></p></a>
            </div>
            <?php if(!is_null($this->group)): ?>
            <form>
                <div class="form-group">
                    <label for="subject" data-translate="Materia"></label>
                    <input type="text" class="form-control" id="subject" name="subject"
                           value="<?php echo $this->group->getIdmateria()->getCodigo() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="name" data-translate="Nombre"></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo $this->group->getNombre() ?>" readonly>
                </div>
            </form>
            <?php else: ?>
                <p data-translate="El grupo no existe">.</p>
            <?php endif; ?>
        </main>
        <?php
    }
}
?>

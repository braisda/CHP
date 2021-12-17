<?php
class PodShowAllView {
    function __construct() {
        $this->render();
    }

    function render() {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
                <h2 data-translate="Insertar POD"></h2>
            </div>

            <form id="actionForm" name="ADD" action='../controllers/podController.php?action=add' method='POST' enctype="multipart/form-data">
                <div id="name-div" class="form-group">
                    <label for="name" data-translate="POD"></label>
                    <input type="file" name="file" id="file" class="form-control pt-1" data-translate="Insertar POD"
                           accept=".pdf" required>
                </div>
                <button name="submit" type="submit" class="btn btn-primary" data-translate="Enviar"></button>
            </form>
        </main>
<?php
    }
}
?>
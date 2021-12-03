<?php
include_once '../Functions/HavePermission.php';

class DegreeShowAllView {

    private $degrees;
    private $itemsPerPage;
    private $currentPage;
    private $totalDegrees;
    private $totalPages;
    private $search;
    private $users;
    private $centers;

    function __construct($degreesData, $itemsPerPage = NULL, $currentPage = NULL, $totalDegrees = NULL, $search = NULL, $users = NULL, $centers = NULL)
    {
        $this->degrees = $degreesData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalDegrees = $totalDegrees;
        $this->totalPages = ceil($totalDegrees / $itemsPerPage);
        $this->search = $search;
        $this->users = $users;
        $this->centers = $centers;
        $this->render();
    }

    function render()
    {
    ?>
<!DOCTYPE html>
    <html>
    <head>
        <script src="../js/validations/degreeValidations.js"></script>
    </head>
    <body>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 data-translate="Listado de titulaciones"></h2>
                <!-- Search -->
                <a class="btn btn-primary button-specific-search" data-toggle="modal" data-target="#searchModal" role="button">
                    <span data-feather="search"></span>
                    <p class="btn-show-view" data-translate="Buscar"></p>
                </a>
                <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><p class="btn-show-view" data-translate="Búsqueda avanzada"></p></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="row" id="searchDegree" action='../controllers/degreeController.php?action=search' method='POST'>
                                    <div id="name-div" class="form-group col-12">
                                        <label for="nombre" data-translate="Nombre"></label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" data-translate="Nombre"
                                               required maxlength="30" oninput="checkNameDegree(this)">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="idCentro" data-translate="Centro"></label>
                                        <select class="form-control" id="idCentro" name="idCentro" required>
                                            <option value="" data-translate="Seleccione"></option>
                                            <?php foreach ($this->centers as $center): ?>
                                                <option value="<?php echo $center->getId() ?>"><?php echo $center->getNombre() ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="idUsuario" data-translate="Responsable"></label>
                                        <select class="form-control" id="idUsuario" name="idUsuario" required>
                                            <option value="" data-translate="Seleccione"></option>
                                            <?php foreach ($this->users as $user): ?>
                                                <option value="<?php echo $user->getLogin() ?>"><?php echo $user->getNombre() . " " . $user->getApellido() ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div id="places-div" class="form-group col-12">
                                        <label for="plazas" data-translate="Plazas"></label>
                                        <input type="number" min="0" max="999" class="form-control" id="plazas" name="plazas"
                                               data-translate="Plazas" required maxlength="3" oninput="checkCapacityDegree(this)">
                                    </div>
                                    <div id="credits-div" class="form-group col-12">
                                        <label for="creditos" data-translate="Créditos"></label>
                                        <input type="number" min="0" max="999" class="form-control" id="creditos" name="creditos"
                                               data-translate="Créditos" required maxlength="3" oninput="checkCreditsDegree(this)">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-translate="Volver"></button>
                                <button type="button" class="btn btn-primary" name="submit" type="submit" data-translate="Buscar" onclick="form_submit()"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($this->search)): ?>
                    <a class="btn btn-primary mr-1" role="button" href="../controllers/degreeController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (checkPermission("centro", "ADD")): ?>
                        <a class="btn btn-success" role="button" href="../controllers/degreeController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir titulación"></p>
                        </a>
                <?php endif; endif; ?>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Nombre"></label></th>
                        <th><label data-translate="Centro"></label></th>
                        <th><label data-translate="Plazas"></label></th>
                        <th><label data-translate="Créditos"></label></th>
                        <th><label data-translate="Responsable"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->degrees)): ?>
                    <tbody>
                    <?php foreach ($this->degrees as $degree): ?>
                        <tr>
                            <td><?php echo $degree->getNombre(); ?></td>
                            <td><?php echo $degree->getCentro()->getNombre(); ?></td>
                            <td><?php echo $degree->getCapacidad(); ?></td>
                            <td><?php echo $degree->getCreditos(); ?></td>
                            <td><?php echo $degree->getUsuario()->getNombre() . " " . $degree->getUsuario()->getApellido(); ?></td>
                            <td class="row">
                                <?php if (checkPermission("grado", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/degreeController.php?action=show&id=<?php echo $degree->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("grado", "EDIT")) { ?>
                                    <a href="../controllers/degreeController.php?action=edit&id=<?php echo $degree->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("grado", "DELETE")) { ?>
                                    <a href="../controllers/degreeController.php?action=delete&id=<?php echo $degree->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna titulación">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalDegrees, "degree") ?>

            </div>
        </div>

        </main>
        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
</body>
<script type="text/javascript">
    function form_submit() {
        document.getElementById("searchDegree").submit();
    }
</script>
</html>
<?php
    }
}
?>
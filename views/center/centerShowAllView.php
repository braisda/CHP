<?php
include_once '../utils/checkPermission.php';

class CenterShowAllView
{
    private $centers;
    private $itemsPerPage;
    private $currentPage;
    private $totalCenters;
    private $totalPages;
    private $search;
    private $universities;
    private $buildings;
    private $users;

    function __construct($centersData, $itemsPerPage = NULL, $currentPage = NULL, $totalCenters = NULL, $search = NULL, $universities = NULL, $buildings = NULL, $users = NULL)
    {
        $this->centers = $centersData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalCenters = $totalCenters;
        $this->totalPages = ceil($totalCenters / $itemsPerPage);
        $this->search = $search;
        $this->universities = $universities;
        $this->buildings = $buildings;
        $this->users = $users;
        $this->render();
    }

    function render()
    {
        ?>
<!DOCTYPE html>
    <html>
        <head>
            <script src="../js/validations/centerValidations.js"></script>
        </head>
        <body>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 data-translate="Listado de centros"></h2>
                <!-- Search -->
                <a class="btn btn-primary button-specific-search" data-toggle="modal" data-target="#searchModal" role="button">
                    <span class="text-white" data-feather="search"></span>
                    <p class="btn-show-view text-white" data-translate="Buscar"></p>
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
                                <form class="row" id="searchCenter" action='../controllers/centerController.php?action=search' method='POST'>
                                    <div id="name-div" class="form-group col-12">
                                        <label for="name" data-translate="Nombre"></label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" data-translate="Nombre"
                                            required maxlength="30" oninput="checkNameCenter(this)">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="idUniversidad" data-translate="Universidad"></label>
                                        <select class="form-control" id="idUniversidad" name="idUniversidad" required>
                                            <option value="" data-translate="Seleccione"></option>
                                            <?php foreach ($this->universities as $university): ?>
                                                <option value="<?php echo $university->getId() ?>"><?php echo $university->getNombre() ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="idEdificio" data-translate="Edificio"></label>
                                        <select class="form-control" id="idEdificio" name="idEdificio" required>
                                            <option value="" data-translate="Seleccione"></option>
                                            <?php foreach ($this->buildings as $building): ?>
                                                <option value="<?php echo $building->getId() ?>"><?php echo $building->getNombre() ?></option>
                                            <?php endforeach;?>
                                        </select>                </div>
                                    <div class="form-group col-12">
                                        <label for="idUsuario" data-translate="Responsable"></label>
                                        <select class="form-control" id="idUsuario" name="idUsuario" required>
                                            <option value="" data-translate="Seleccione"></option>
                                            <?php foreach ($this->users as $user): ?>
                                                <option value="<?php echo $user->getId() ?>"><?php echo $user->getNombre()." ".$user->getApellido() ?></option>
                                            <?php endforeach;?>
                                        </select>
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
                    <a class="btn btn-primary mr-1" role="button" href="../controllers/centerController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (checkPermission("centro", "ADD")): ?>
                        <a class="btn btn-success" role="button" href="../controllers/centerController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir centro"></p>
                        </a>
                    <?php endif; endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th><label data-translate="Nombre"></label></th>
                            <th><label data-translate="Universidad"></label></th>
                            <th><label data-translate="Edificio"></label></th>
                            <th><label data-translate="Responsable"></label></th>
                            <th class="actions-row"><label data-translate="Acciones"></label></th>
                        </tr>
                    </thead>
                    <?php if (!empty($this->centers)): ?>
                    <tbody>
                    <?php foreach ($this->centers as $center): ?>
                        <tr>
                            <td><?php echo $center->getNombre() ;?></td>
                            <td><?php echo $center->getUniversidad()->getNombre() ;?></td>
                            <td><?php echo $center->getEdificio()->getNombre() ;?></td>
                            <td><?php echo $center->getUsuario()->getNombre() . " " . $center->getUsuario()->getApellido();?></td>
                            <td class="row">
                                <?php if (checkPermission("centro", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/centerController.php?action=show&id=<?php echo $center->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("centro", "EDIT")) { ?>
                                    <a href="../controllers/centerController.php?action=edit&id=<?php echo $center->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("centro", "DELETE")) { ?>
                                    <a href="../controllers/centerController.php?action=delete&id=<?php echo $center->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                    <?php else: ?>
                        </table>
                        <p data-translate="No se ha obtenido ningún centro">. </p>
                    <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalCenters, "center"); ?>
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
        document.getElementById("searchCenter").submit();
    }
</script>
</html>
<?php
    }
}
?>
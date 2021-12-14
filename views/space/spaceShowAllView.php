<?php

class SpaceShowAllView
{
    private $spaces;
    private $buildings;
    private $itemsPerPage;
    private $currentPage;
    private $totalSpaces;
    private $searching;

    function __construct($spacesData, $buildingsData, $itemsPerPage = NULL, $currentPage = NULL, $totalSpaces = NULL, $searching = False)
    {
        $this->spaces = $spacesData;
        $this->buildings = $buildingsData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalSpaces = $totalSpaces;
        $this->searching = $searching;
        $this->render();
    }

    function render()
    {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de espacios"></h1>

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
                            <form class="row" id="searchSpace" action='../controllers/spaceController.php?action=search' method='POST'>
                                <div class="form-group col-12">
                                    <label for="building_id" data-translate="Edificio"></label>
                                    <select class="form-control" id="building_id" name="building_id" ?>
                                        <option value="" data-translate="Seleccione"></option>
                                        <?php foreach ($this->buildings as $b): ?>
                                            <option value="<?php echo $b->getId() ?>"><?php echo $b->getNombre() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="name-div" class="form-group col-12">
                                    <label for="name" data-translate="Nombre"></label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div id="capacity-div" class="form-group col-12">
                                    <label for="capacity" data-translate="Capacidad"></label>
                                    <input type="number" class="form-control" id="capacity" name="capacity">
                                </div>
                                <div id="office-div" class="form-group col-12">
                                    <label for="office" data-translate="Oficina"></label>
                                    <br/>
                                    <input type="checkbox" class="office-checkbox" id="office" name="office" >
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

                <?php if ($this->searching): ?>
                    <a class="btn btn-primary" role="button" href="../controllers/spaceController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (checkPermission("espacio", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../controllers/spaceController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir espacio"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Edificio"></label></th>
                        <th><label data-translate="Nombre"></label></th>
                        <th><label data-translate="Capacidad"></label></th>
                        <th><label data-translate="Oficina"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->spaces)): ?>
                    <tbody>
                    <?php foreach ($this->spaces as $space): ?>
                        <tr>
                            <td><?php echo $space->getIdedificio()->getNombre() ;?> </td>
                            <td><?php echo $space->getNombre() ?></td>
                            <td><?php echo $space->getCapacidad() ?></td>
                            <?php if ($space->isOffice()): ?>
                                <td data-translate="Sí"></td>
                            <?php else: ?>
                                <td data-translate="No"></td>
                            <?php endif; ?>
                            <td class="row">
                                <?php if (checkPermission("espacio", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/spaceController.php?action=show&id=<?php echo $space->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("espacio", "EDIT")) { ?>
                                    <a href="../controllers/spaceController.php?action=edit&id=<?php echo $space->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("espacio", "DELETE")) { ?>
                                    <a href="../controllers/spaceController.php?action=delete&id=<?php echo $space->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna espacio">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalSpaces,
                    "space") ?>

            </div>
        </main>

        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
        <script type="text/javascript">
            function form_submit() {
                document.getElementById("searchSpace").submit();
            }
        </script>
        <?php
    }
}

?>

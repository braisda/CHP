<?php
include_once '../utils/CheckPermission.php';

class FuncActionShowAllView {
    private $funcActions;
    private $itemsPerPage;
    private $currentPage;
    private $totalFuncActions;
    private $totalPages;
    private $search;
    private $actionsData;
    private $functionalitiesData;

    function __construct($funcActionsData, $itemsPerPage = NULL, $currentPage = NULL, $totalFuncActions = NULL, $search = NULL, $actionsData = NULL, $functionalitiesData = NULL) {
        $this->funcActions = $funcActionsData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalFuncActions = $totalFuncActions;
        $this->totalPages = ceil($totalFuncActions / $itemsPerPage);
        $this->search = $search;
        $this->actionsData = $actionsData;
        $this->functionalitiesData = $functionalitiesData;
        $this->render();
    }

    function render() {
        ?>
       <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 data-translate="Listado de acciones-funcionalidades"></h2>
                <!-- Search -->
                <a class="btn btn-primary button-specific-search" data-toggle="modal" data-target="#searchModal" role="button">
                    <span data-feather="search" class="text-white"></span>
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
                                <form class="row" id="searchFuncAction" action='../controllers/funcActionController.php?action=search' method='POST'>
                                    <div class="form-group col-12">
                                        <label for="action_id" data-translate="Acción"></label>
                                        <select class="form-control" id="action_id" name="action_id">
                                            <option value="" data-translate="Seleccione"></option>
                                            <?php foreach ($this->actionsData as $action): ?>
                                                <option value="<?php echo $action->getId()?>"><?php echo $action->getNombre() ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="functionality_id" data-translate="Funcionalidad"></label>
                                        <select class="form-control" id="functionality_id" name="functionality_id"?>
                                            <option value="" data-translate="Seleccione"></option>
                                            <?php foreach ($this->functionalitiesData as $func): ?>
                                                <option value="<?php echo $func->getId() ?>"><?php echo $func->getNombre() ?></option>
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
                     <a class="btn btn-primary mr-1" role="button" href="../controllers/funcActionController.php">
                         <p data-translate="Volver"></p>
                     </a>
                 <?php else:
                     if (checkPermission("Funcaccion", "ADD")): ?>
                         <a class="btn btn-success" role="button" href="../controllers/funcActionController.php?action=add">
                             <span data-feather="plus"></span>
                             <p data-translate="Añadir funcionalidad-acción"></p>
                         </a>
                 <?php endif; endif; ?>
             </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Acción"></label></th>
                        <th><label data-translate="Funcionalidad"></label></th>
                        <th><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->funcActions)): ?>
                    <tbody>
                    <?php foreach ($this->funcActions as $funcAction): ?>
                        <tr>
                            <td><?php echo $funcAction->getAccion()->getNombre(); ?></td>
                            <td><?php echo $funcAction->getFuncionalidad()->getNombre(); ?></td>
                            <td class="row">
                                <?php if (checkPermission("Funcaccion", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/funcActionController.php?action=show&id=<?php echo $funcAction->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("Funcaccion", "EDIT")) { ?>
                                    <a href="../controllers/funcActionController.php?action=edit&id=<?php echo $funcAction->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("Funcaccion", "DELETE")) { ?>
                                    <a href="../controllers/funcActionController.php?action=delete&id=<?php echo $funcAction->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna acción-funcionalidad">.</p>
                <?php endif; ?>

                <?php if (empty($this->search)) { new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalFuncActions, "FuncAction"); }?>
            </div>
        </main>

        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
<script type="text/javascript">
    function form_submit() {
        document.getElementById("searchFuncAction").submit();
    }
</script>
<?php
    }
}
?>
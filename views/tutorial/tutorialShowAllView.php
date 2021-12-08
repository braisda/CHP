<?php

class TutorialShowAllView
{
    private $tutorials;
    private $teachers;
    private $itemsPerPage;
    private $currentPage;
    private $totalTutorials;
    private $searching;

    function __construct($tutorialsData, $teachersData, $itemsPerPage = NULL, $currentPage = NULL, $totalTutorials = NULL, $toSearch = NULL, $searching = False)
    {
        $this->tutorials = $tutorialsData;
        $this->teachers = $teachersData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalTutorials = $totalTutorials;
        $this->searching = $searching;
        $this->render();
    }

    function render()
    {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h1 class="h2" data-translate="Listado de tutorías"></h1>

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
                            <form class="row" id="searchTutorial" action='../controllers/tutorialController.php?action=search' method='POST'>
                                <div class="form-group col-12">
                                    <label for="teacher_id" data-translate="Profesor"></label>
                                    <select class="form-control" id="teacher_id" name="teacher_id" ?>
                                        <option value="" data-translate="Seleccione"></option>
                                        <?php foreach ($this->teachers as $t): ?>
                                            <option value="<?php echo $t->getId() ?>"><?php echo $t->getUsuario()->getLogin() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>                                
                                <div id="start-year-div" class="form-group col-12">
                                    <label for="start_date" data-translate="Inicio"></label>
                                    <input type="datetime-local" min="2000" max="9999" class="form-control" id="start_date" name="start_date">
                                </div>
                                <div id="end-year-div" class="form-group col-12">
                                    <label for="end_date" data-translate="Fin"></label>
                                    <input type="datetime-local" min="2000" max="9999" class="form-control" id="end_date" name="end_date">
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
                    <a class="btn btn-primary" role="button" href="../controllers/tutorialController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (checkPermission("tutoria", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../controllers/tutorialController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir tutoría"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Profesor"></label></th>
                        <th><label data-translate="Inicio"></label></th>
                        <th><label data-translate="Fin"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->tutorials)): ?>
                    <tbody>
                    <?php foreach ($this->tutorials as $tutorial): ?>
                        <tr>
                            <td><?php echo $tutorial->getIdprofesor()->getUsuario()->getLogin() ;?></td>
                            <td><?php echo $tutorial->getFechainicio() ;?></td>
                            <td><?php echo $tutorial->getFechafin() ;?></td>
                            <td class="row">
                                <?php if (checkPermission("tutoria", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/tutorialController.php?action=show&idtutoria=<?php echo $tutorial->getIdtutoria() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("tutoria", "EDIT")) { ?>
                                    <a href="../controllers/tutorialController.php?action=edit&idtutoria=<?php echo $tutorial->getIdtutoria() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("tutoria", "DELETE")) { ?>
                                    <a href="../controllers/tutorialController.php?action=delete&idtutoria=<?php echo $tutorial->getIdtutoria() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna tutoria">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalTutorials,
                    "tutorial") ?>

            </div>
        </main>

        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
        <script type="text/javascript">
            function form_submit() {
                document.getElementById("searchTutorial").submit();
            }
        </script>
        <?php
    }
}

?>

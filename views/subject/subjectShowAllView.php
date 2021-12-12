<?php
include_once '../utils/checkPermission.php';

class SubjectShowAllView {

    private $subjects;
    private $itemsPerPage;
    private $currentPage;
    private $totalSubjects;
    private $totalPages;
    private $search;
    private $searching;
    private $departmentOwner;

    function __construct($subjects, $itemsPerPage = NULL, $currentPage = NULL, $totalSubjects = NULL, $search = NULL, $searching=false, $departmentOwner=false) {
        $this->subjects = $subjects;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalSubjects = $totalSubjects;
        $this->totalPages = ceil($totalSubjects / $itemsPerPage);
        $this->search = $search;
        $this->searching=$searching;
        $this->departmentOwner=$departmentOwner;
        $this->render();
    }

    function render() {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 data-translate="Listado de materias"></h2>

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
                            <form class="row" id="searchSubject" action='../controllers/subjectController.php?action=search' method='POST'>


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
                    <a class="btn btn-primary" role="button" href="../controllers/subjectController.php">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (checkPermission("materia", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../controllers/subjectController.php?action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir materia"></p>
                        </a>
                    <?php endif; endif; ?>

            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Código"></label></th>
                        <th><label data-translate="Acrónimo"></label></th>
                        <th><label data-translate="Contenido"></label></th>
                        <th><label data-translate="Tipo"></label></th>
                        <th><label data-translate="Curso"></label></th>
                        <th><label data-translate="Cuatrimestre"></label></th>
                        <th><label data-translate="Créditos"></label></th>
                        <th><label data-translate="Titulación"></label></th>
                        <th><label data-translate="Profesor"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->subjects)): ?>
                     <tbody>
                    <?php foreach ($this->subjects as $subject): ?>
                        <tr>
                            <td><?php echo $subject->getCodigo() ;?></td>
                            <td><?php echo $subject->getAcronimo(); ?></td>
                            <td><?php echo $subject->getContenido() ;?></td>
                            <td><?php echo $subject->getTipo() ;?></td>
                            <td><?php echo $subject->getCurso() ;?></td>
                            <td><?php echo $subject->getCuatrimestre() ;?></td>
                            <td><?php echo $subject->getCreditos() ;?></td>
                            <td><?php echo $subject->getGrado()->getNombre() ;?></td>
                            <?php if(!empty($subject->getProfesor()->getUsuario())): ?>
                                <td><?php echo $subject->getProfesor()->getUsuario()->getNombre() . " " .
                                        $subject->getProfesor()->getUsuario()->getApellido() ;?></td>
                            <?php else:?>
                                <td data-translate="No asignado"></td>
                            <?php endif; ?>
                            <?php
							    if (checkPermission("materia", "SHOWALL")):
						    ?>
                            <!--<td class="btn-schedule"><a href="../controllers/scheduleController.php?subject=<?php echo $subject->getId() ?>">
                                    <i class="fas fa-calendar-alt"></i></a></td>-->
                            <?php endif; ?>
                            <td class="row btn-subject-actions">
                                <?php if (checkPermission("materia", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/subjectController.php?action=show&id=<?php echo $subject->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("materia", "EDIT") && ($this->departmentOwner || (!empty($subject->getProfesor()->getUsuario())  && $subject->getProfesor()->getUsuario()->getLogin() == getUserInSession()))) { ?>
                                    <a href="../controllers/subjectController.php?action=edit&id=<?php echo $subject->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("materia", "DELETE") && ($this->departmentOwner || (!empty($subject->getProfesor()->getUsuario()) && $subject->getProfesor()->getUsuario()->getLogin() == getUserInSession()))) { ?>
                                    <a href="../controllers/subjectController.php?action=delete&id=<?php echo $subject->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                                <!--<a href="../controllers/subjectTeacherController.php?subject_id=<?php echo $subject->getId() ?>">
                                    <i class="fas fa-chalkboard-teacher"></i></a>-->

                            </td>
                        </tr>
                    <?php endforeach; ?>
                     </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ninguna materia">. </p>
                <?php endif; ?>


                     <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalSubjects, "subject") ?>

                 </div>
             </main>
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
        <script type="text/javascript">
            function form_submit() {
                document.getElementById("searchSubject").submit();
            }
        </script>
<?php
    }
}
?>

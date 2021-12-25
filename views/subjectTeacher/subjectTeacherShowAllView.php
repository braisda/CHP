<?php
include_once '../utils/checkPermission.php';

class SubjectTeacherShowAllView {

    private $subjectTeachers;
    private $itemsPerPage;
    private $currentPage;
    private $totalTeachers;
    private $totalPages;
    private $search;
    private $subject;
    private $permission;

    function __construct($subjectTeachers, $itemsPerPage = NULL, $currentPage = NULL, $totalTeachers = NULL, $search = NULL, $subject = NULL, $permission = false) {
        $this->subjectTeachers = $subjectTeachers;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalTeachers = $totalTeachers;
        $this->totalPages = ceil($totalTeachers / $itemsPerPage);
        $this->search = $search;
        $this->subject = $subject;
        $this->permission=$permission;
        $this->render();
    }

    function render() {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 data-translate="Profesores de %<?php echo $this->subject->getCodigo(); ?>%"></h2>

                <?php if (checkPermission("materiaprofesor", "ADD") && $this->permission): ?>
                    <a class="btn btn-success btn-subject" role="button"
                       href="../controllers/subjectTeacherController.php?action=add&subject_id=<?php echo $this->subject->getId(); ?>">
                        <span data-feather="plus"></span>
                        <p data-translate="Asignar profesor"></p>
                    </a>
                <?php endif; ?>
                <a class="btn btn-primary" role="button" href="../controllers/subjectController.php">
                    <p data-translate="Volver"></p>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Profesor"></label></th>
                        <th><label data-translate="Horas"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->subjectTeachers)): ?>
                    <tbody>
                        <tr>
                            <td><?php echo $this->subjectTeachers->getProfesor()->getUsuario()->getNombre() . " " . $this->subjectTeachers->getProfesor()->getUsuario()->getApellido(); ?></td>
                            <td><?php echo $this->subjectTeachers->getHoras() ?></td>
                            <td class="row">
                                <?php if (checkPermission("centro", "EDIT")) { ?>
                                    <a href="../controllers/subjectTeacherController.php?action=edit&id=<?php echo $this->subjectTeachers->getId() ?>&subject_id=<?php echo $this->subjectTeachers->getMateria()->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("centro", "DELETE")) { ?>
                                    <a href="../controllers/subjectTeacherController.php?action=delete&id=<?php echo $this->subjectTeachers->getId() ?>&subject_id=<?php echo $this->subjectTeachers->getMateria()->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún profesor">. </p>
                <?php endif; ?>

            </div>
        </main>
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
<?php
    }
}
?>
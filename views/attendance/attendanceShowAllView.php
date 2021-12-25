<?php
include_once '../utils/checkPermission.php';

class AttendanceShowAllView {

    private $attendanceData;
    private $subjectData;
    private $itemsPerPage;
    private $currentPage;
    private $totalAttendance;
    private $totalPages;
    private $search;
    private $scheduleData;

    function __construct($attendanceData, $subjectData = NULL, $itemsPerPage = NULL, $currentPage = NULL, $totalAttendance = NULL, $search = NULL, $scheduleData = NULL) {
        $this->attendanceData = $attendanceData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalAttendance = $totalAttendance;
        $this->totalPages = ceil($totalAttendance / $itemsPerPage);
        $this->search = $search;
        $this->subjectData=$subjectData;
        $this->scheduleData = $scheduleData;
        $this->render();
    }

    function render() {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 data-translate="Asistencia a %<?php echo $this->subjectData->getIdmateria()->getAcronimo(); ?>%"></h2>

                <a class="btn btn-primary" role="button" href="../controllers/scheduleController.php?subject=<?php echo $this->subjectData->getIdmateria()->getId()?>">
                    <p data-translate="Volver"></p>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th><label data-translate="Materia"></label></th>
                            <th><label data-translate="Número de asistentes"></label></th>
                            <th><label data-translate="Impartido"></label></th>
                            <th class="actions-row"><label data-translate="Acciones"></label></th>
                        </tr>
                    </thead>
                    <?php if (!empty($this->attendanceData)): ?>
                    <tbody>
                    <?php foreach ($this->attendanceData as $attendance): ?>
                        <tr>
                            <td><?php echo $attendance->getMateria()->getIdmateria()->getAcronimo() ?></td>
                            <td><?php echo $attendance->getNumAlumnos() ?></td>
                            <?php if ($attendance->getAsiste() == 0): ?>
                                <td><label data-translate="No"></td>
                            <?php else: ?>
                                <td><label data-translate="Sí"></td>
                            <?php endif; ?>
                            <td class="row">
                                <?php if ((time()-(60*60*24)) < strtotime($attendance->getHorario()->getDia())): ?>
                                    <a href="../controllers/attendanceController.php?subject=<?php echo $this->subjectData->getIdmateria()->getId()?>&schedule=<?php echo $this->scheduleData->getId() ?>&action=edit&id=<?php echo $attendance->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                    <?php else: ?>
                        </table>
                        <p data-translate="No se ha obtenido ningún registro">. </p>
                    <?php endif; ?>
                </table>
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
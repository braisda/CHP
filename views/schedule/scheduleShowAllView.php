<?php
include_once '../utils/CheckPermission.php';

class ScheduleShowAllView {

    private $schedules;
    private $itemsPerPage;
    private $currentPage;
    private $totalSchedules;
    private $totalPages;
    private $search;
    private $subject;
    private $subjectGroups;
    private $spaces;
    private $teachers;

    function __construct($scheduleData, $itemsPerPage = NULL, $currentPage = NULL, $totalSchedules = NULL, $search = NULL, $subject = NULL, $group = NULL, $space = NULL, $teacher = NULL) {
        $this->schedules = $scheduleData;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalSchedules = $totalSchedules;
        $this->totalPages = ceil($totalSchedules / $itemsPerPage);
        $this->search = $search;
        $this->subject = $subject;
        $this->subjectGroups = $group;
        $this->spaces = $space;
        $this->teachers = $teacher;
        $this->render();
    }

    function render()
    {
        ?>
        <main role="main" class="margin-main ml-sm-auto px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
                <h2 data-translate="Horarios de la materia %<?php echo $this->subject->getAcronimo() ?>%"></h2>

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
                            <form class="row" id="searchSchedule" action='../controllers/scheduleController.php?subject=<?php echo $this->subject->getId()?>&action=search' method='POST'>
                                <div class="form-group col-12">
                                    <label for="subject_group_id" data-translate="Grupo"></label>
                                    <select class="form-control" id="subject_group_id" name="subject_group_id">
                                        <option value="" data-translate="Seleccione"></option>
                                        <?php foreach ($this->subjectGroups as $group): ?>
                                            <option value="<?php echo $group->getId() ?>">
                                                <?php echo $group->getIdmateria()->getAcronimo()."_". $group->getNombre() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label for="space_id" data-translate="Aula"></label>
                                    <select class="form-control" id="space_id" name="space_id">
                                        <option value="" data-translate="Seleccione"></option>
                                        <?php foreach ($this->spaces as $space): ?>
                                            <option value="<?php echo $space->getId() ?>">
                                                <?php echo $space->getNombre() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label for="teacher_id" data-translate="Profesor"></label>
                                    <select class="form-control" id="teacher_id" name="teacher_id">
                                        <option value="" data-translate="Seleccione"></option>
                                        <?php foreach ($this->teachers as $teacher): ?>
                                            <option value="<?php echo $teacher->getId() ?>">
                                                <?php echo $teacher->getUsuario()->getNombre() . " " . $teacher->getUsuario()->getApellido() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="start-day-div" class="form-group col-12">
                                    <label for="start_day" data-translate="Día"></label>
                                    <input type="date" class="form-control" id="day" name="day" >
                                </div>
                                <div id="start-hour-div" class="form-group col-6">
                                    <label for="start_hour" data-translate="Hora de inicio"></label>
                                    <input type="time" class="form-control" id="start_hour" name="start_hour"
                                           oninput="checkStartHourTeacher(this)">
                                </div>
                                <div id="end-hour-div" class="form-group col-6">
                                    <label for="end_hour" data-translate="Hora de fin"></label>
                                    <input type="time" class="form-control" id="end_hour" name="end_hour"
                                           oninput="checkEndHourTeacher(this)">
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

                <?php if ($this->search): ?>
                    <a class="btn btn-primary" role="button" href="../controllers/scheduleController.php?subject=<?php echo $this->subject->getId()?>">
                        <p data-translate="Volver"></p>
                    </a>
                <?php else:
                    if (checkPermission("horario", "ADD")): ?>
                        <a class="btn btn-success" role="button"
                           href="../controllers/scheduleController.php?subject=<?php echo $this->subject->getId()?>&action=add">
                            <span data-feather="plus"></span>
                            <p data-translate="Añadir horario"></p>
                        </a>
                    <?php endif; endif; ?>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th><label data-translate="Grupo"></label></th>
                        <th><label data-translate="Día"></label></th>
                        <th><label data-translate="Hora de inicio"></label></th>
                        <th><label data-translate="Hora de fin"></label></th>
                        <th><label data-translate="Aula"></label></th>
                        <th><label data-translate="Profesor"></label></th>
                        <th class="actions-row"><label data-translate="Acciones"></label></th>
                    </tr>
                    </thead>
                    <?php if (!empty($this->schedules)): ?>
                    <tbody>
                    <?php foreach ($this->schedules as $schedule): ?>
                        <tr>
                            <td><?php echo $schedule->getGrupoMateria()->getIdmateria()->getAcronimo() . "_" .
                                $schedule->getGrupoMateria()->getNombre();?></td>
                            <td><?php echo date("d-m-Y", strtotime($schedule->getDia())) ;?></td>
                            <td><?php echo date("H:i", strtotime($schedule->getHoraInicio())) ;?></td>
                            <td><?php echo date("H:i", strtotime($schedule->getHoraFin())) ;?></td>
                            <td><?php echo $schedule->getEspacio()->getNombre() ;?></td>
                            <td><?php echo $schedule->getProfesor()->getUsuario()->getNombre() . " " .
                                    $schedule->getProfesor()->getUsuario()->getApellido() ;?></td>
                            <td class="row">
                                <?php if (checkPermission("horario", "SHOWCURRENT")) { ?>
                                    <a href="../controllers/scheduleController.php?subject=<?php echo $this->subject->getId() ?>&action=show&id=<?php echo $schedule->getId() ?>">
                                        <span data-feather="eye"></span></a>
                                <?php }
                                if (checkPermission("horario", "EDIT")) { ?>
                                    <a href="../controllers/scheduleController.php?subject=<?php echo $this->subject->getId() ?>&action=edit&id=<?php echo $schedule->getId() ?>">
                                        <span data-feather="edit"></span></a>
                                <?php }
                                if (checkPermission("horario", "DELETE")) { ?>
                                    <a href="../controllers/scheduleController.php?subject=<?php echo $this->subject->getId() ?>&action=delete&id=<?php echo $schedule->getId() ?>">
                                        <span data-feather="trash-2"></span></a>
                                <?php }?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    </table>
                    <p data-translate="No se ha obtenido ningún horario para esta materia">. </p>
                <?php endif; ?>

                <?php new PaginationView($this->itemsPerPage, $this->currentPage, $this->totalSchedules,
                    "Schedule", "../controllers/scheduleController.php?subject=" . $this->subject->getId() . "&")?>

                <a type="button" class="btn btn-warning" data-translate="Editar por rango" style="margin-top: .7rem"
                   href="../controllers/scheduleController.php?subject=<?php echo $this->subject->getId() ?>&action=editByRange"></a>

            </div>
        </main>
        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
        <script type="text/javascript">
            function form_submit() {
                document.getElementById("searchSchedule").submit();
            }
        </script>
<?php
    }
}
?>
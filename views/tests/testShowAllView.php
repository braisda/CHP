<?php
include_once '../utils/isAdmin.php';

class TestShowAllView
{

  function __construct()
  {
    $this->render();
  }

  function render()
  {
?>
    <main role="main" class="margin-main ml-sm-auto px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
        <h2 data-translate="Listado de pruebas"></h2>
      </div>

      <div class="accordion" id="accordionExample">
        <!-- Permisos -->
        <div class="card">
          <div class="card-header" id="headingOne">
            <h5 class="mb-0">
              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#permission" aria-controls="permission">
                <span data-translate="Permisos"></span>
              </button>
            </h5>
          </div>

          <div id="permission" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=permission&action=add">
                <p data-translate="Añadir permiso"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=permission&action=delete">
                <p data-translate="Eliminar permiso"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=permission&action=edit">
                <p data-translate="Editar permiso"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=permission&action=view">
                <p data-translate="Ver permiso"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Roles -->
        <div class="card">
          <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#role" aria-expanded="false" aria-controls="role">
                <span data-translate="Roles"></span>
              </button>
            </h5>
          </div>
          <div id="role" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=role&action=add">
                <p data-translate="Añadir rol"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=role&action=delete">
                <p data-translate="Eliminar rol"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=role&action=edit">
                <p data-translate="Editar rol"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=role&action=view">
                <p data-translate="Ver rol"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Acciones -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#action" aria-expanded="false" aria-controls="action">
                <span data-translate="Acciones"></span>
              </button>
            </h5>
          </div>
          <div id="action" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=action&action=add">
                <p data-translate="Añadir acción"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=action&action=delete">
                <p data-translate="Eliminar acción"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=action&action=edit">
                <p data-translate="Editar acción"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=action&action=view">
                <p data-translate="Ver acción"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Asignación de roles -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#userRole" aria-expanded="false" aria-controls="userRole">
                <span data-translate="Asignación de roles"></span>
              </button>
            </h5>
          </div>
          <div id="userRole" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=userRole&action=add">
                <p data-translate="Añadir asignación de roles"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=userRole&action=delete">
                <p data-translate="Eliminar asignación de roles"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=userRole&action=edit">
                <p data-translate="Editar asignación de roles"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=userRole&action=view">
                <p data-translate="Ver asignación de roles"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Funcionalidad-acción -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#funcAction" aria-expanded="false" aria-controls="funcAction">
                <span data-translate="Funcionalidad-acción"></span>
              </button>
            </h5>
          </div>
          <div id="funcAction" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=funcAction&action=add">
                <p data-translate="Añadir funcionalidad-acción"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=funcAction&action=delete">
                <p data-translate="Eliminar funcionalidad-acción"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=funcAction&action=edit">
                <p data-translate="Editar funcionalidad-acción"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=funcAction&action=view">
                <p data-translate="Ver funcionalidad-acción"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Usuario -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#user" aria-expanded="false" aria-controls="user">
                <span data-translate="Usuario"></span>
              </button>
            </h5>
          </div>
          <div id="user" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=user&action=add">
                <p data-translate="Añadir usuario"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=user&action=delete">
                <p data-translate="Eliminar usuario"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=user&action=edit">
                <p data-translate="Editar usuario"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=user&action=view">
                <p data-translate="Ver usuario"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Funcionalidad -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#functionality" aria-expanded="false" aria-controls="functionality">
                <span data-translate="Funcionalidad"></span>
              </button>
            </h5>
          </div>
          <div id="functionality" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=functionality&action=add">
                <p data-translate="Añadir funcionalidad"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=functionality&action=delete">
                <p data-translate="Eliminar funcionalidad"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=functionality&action=edit">
                <p data-translate="Editar funcionalidad"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=functionality&action=view">
                <p data-translate="Ver funcionalidad"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Curso academico -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#academicCourse" aria-expanded="false" aria-controls="academicCourse">
                <span data-translate="Curso académico"></span>
              </button>
            </h5>
          </div>
          <div id="academicCourse" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=academicCourse&action=add">
                <p data-translate="Añadir curso académico"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=academicCourse&action=delete">
                <p data-translate="Eliminar curso académico"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=academicCourse&action=edit">
                <p data-translate="Editar curso académico"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=academicCourse&action=view">
                <p data-translate="Ver curso académico"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Centro -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#center" aria-expanded="false" aria-controls="center">
                <span data-translate="Centro"></span>
              </button>
            </h5>
          </div>
          <div id="center" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=center&action=add">
                <p data-translate="Añadir centro"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=center&action=delete">
                <p data-translate="Eliminar centro"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=center&action=edit">
                <p data-translate="Editar centro"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=center&action=view">
                <p data-translate="Ver centro"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Universiad -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#university" aria-expanded="false" aria-controls="university">
                <span data-translate="Universidad"></span>
              </button>
            </h5>
          </div>
          <div id="university" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=university&action=add">
                <p data-translate="Añadir universidad"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=university&action=delete">
                <p data-translate="Eliminar universidad"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=university&action=edit">
                <p data-translate="Editar universidad"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=university&action=view">
                <p data-translate="Ver universidad"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Titulación -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#degree" aria-expanded="false" aria-controls="degree">
                <span data-translate="Titulación"></span>
              </button>
            </h5>
          </div>
          <div id="degree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=degree&action=add">
                <p data-translate="Añadir titulación"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=degree&action=delete">
                <p data-translate="Eliminar titulación"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=degree&action=edit">
                <p data-translate="Editar titulación"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=degree&action=view">
                <p data-translate="Ver titulación"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Profesor -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#teacher" aria-expanded="false" aria-controls="teacher">
                <span data-translate="Profesor"></span>
              </button>
            </h5>
          </div>
          <div id="teacher" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=teacher&action=add">
                <p data-translate="Añadir profesor"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=teacher&action=delete">
                <p data-translate="Eliminar profesor"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=teacher&action=edit">
                <p data-translate="Editar profesor"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=teacher&action=view">
                <p data-translate="Ver profesor"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Tutoria -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#tutorial" aria-expanded="false" aria-controls="tutorial">
                <span data-translate="Tutoría"></span>
              </button>
            </h5>
          </div>
          <div id="tutorial" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=tutorial&action=add">
                <p data-translate="Añadir tutoría"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=tutorial&action=delete">
                <p data-translate="Eliminar tutoría"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=tutorial&action=edit">
                <p data-translate="Editar tutoría"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=tutorial&action=view">
                <p data-translate="Ver tutoría"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Departamento -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#department" aria-expanded="false" aria-controls="department">
                <span data-translate="Departamento"></span>
              </button>
            </h5>
          </div>
          <div id="department" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=department&action=add">
                <p data-translate="Añadir departamento"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=department&action=delete">
                <p data-translate="Eliminar departamento"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=department&action=edit">
                <p data-translate="Editar departamento"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=department&action=view">
                <p data-translate="Ver departamento"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Materia -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#subject" aria-expanded="false" aria-controls="subject">
                <span data-translate="Materia"></span>
              </button>
            </h5>
          </div>
          <div id="subject" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=subject&action=add">
                <p data-translate="Añadir materia"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=subject&action=delete">
                <p data-translate="Eliminar materia"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=subject&action=edit">
                <p data-translate="Editar materia"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=subject&action=view">
                <p data-translate="Ver materia"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Edificio -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#building" aria-expanded="false" aria-controls="building">
                <span data-translate="Edificio"></span>
              </button>
            </h5>
          </div>
          <div id="building" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=building&action=add">
                <p data-translate="Añadir edificio"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=building&action=delete">
                <p data-translate="Eliminar edificio"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=building&action=edit">
                <p data-translate="Editar edificio"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=building&action=view">
                <p data-translate="Ver edificio"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Espacio -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#space" aria-expanded="false" aria-controls="space">
                <span data-translate="Espacio"></span>
              </button>
            </h5>
          </div>
          <div id="space" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=space&action=add">
                <p data-translate="Añadir espacio"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=space&action=delete">
                <p data-translate="Eliminar espacio"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=space&action=edit">
                <p data-translate="Editar espacio"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=space&action=view">
                <p data-translate="Ver espacio"></p>
              </a>
            </div>
          </div>
        </div>
        <!-- Grupo -->
        <div class="card">
          <div class="card-header" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#group" aria-expanded="false" aria-controls="group">
                <span data-translate="Grupo"></span>
              </button>
            </h5>
          </div>
          <div id="group" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <a class="btn btn-success mr-1" role="button" href="../tests/testController.php?controller=group&action=add">
                <p data-translate="Añadir grupo"></p>
              </a>

              <a class="btn btn-danger mr-1" role="button" href="../tests/testController.php?controller=group&action=delete">
                <p data-translate="Eliminar grupo"></p>
              </a>

              <a class="btn btn-warning mr-1" role="button" href="../tests/testController.php?controller=group&action=edit">
                <p data-translate="Editar grupo"></p>
              </a>

              <a class="btn btn-primary mr-1" role="button" href="../tests/testController.php?controller=group&action=view">
                <p data-translate="Ver grupo"></p>
              </a>
            </div>
          </div>
        </div>

      </div>
    </main>
    <script>
      $(document).ready(function() {

        $controller = getUrlParameter("controller");

        switch ($controller) {
          case "role":
            $("#role").collapse('show');
            break;
          case "action":
            $("#action").collapse('show');
            break;
          case "userRole":
            $("#userRole").collapse('show');
            break;
          case "funcAction":
            $("#funcAction").collapse('show');
            break;
          case "user":
            $("#user").collapse('show');
            break;
          case "functionality":
            $("#functionality").collapse('show');
            break;
          case "academicCourse":
            $("#academicCourse").collapse('show');
            break;
          case "center":
            $("#center").collapse('show');
            break;
          case "university":
            $("#university").collapse('show');
            break;
          case "degree":
            $("#degree").collapse('show');
            break;
          case "teacher":
            $("#teacher").collapse('show');
            break;
          case "tutorial":
            $("#tutorial").collapse('show');
            break;
          case "department":
            $("#department").collapse('show');
            break;
          case "subject":
            $("#subject").collapse('show');
            break;
          case "building":
            $("#building").collapse('show');
            break;
          case "space":
            $("#space").collapse('show');
            break;
          case "group":
            $("#group").collapse('show');
            break;
          default:
            $("#permission").collapse('show');
            break;
        }
      });

      var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
          sURLVariables = sPageURL.split('&'),
          sParameterName,
          i;

        for (i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split('=');

          if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
          }
        }
        return false;
      };
    </script>
<?php
  }
}
?>
<?php
include_once '../utils/isAdmin.php';

class TestShowAllView {

    function __construct() {
        $this->render();
    }

    function render() {
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
             </div>
         </main>
<script>
$(document).ready(function() {

    $controller = getUrlParameter("controller");

    switch($controller) {
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
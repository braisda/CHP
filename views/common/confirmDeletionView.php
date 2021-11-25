<head><link rel="stylesheet" href="../css/modal.css" /></head>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="exampleModalLabel">
          <p id="modal-title"><i class="bi bi-trash"></i></p>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="p-3 d-flex justify-content-center">
          <p id="modal-text"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <span data-translate="Cerrar"></span>
        </button>
        <a id="delete-button" role="button" class="btn btn-danger" href="#">
          <p data-translate="Eliminar"></p>
        </a>
      </div>
    </div>
  </div>
</div>
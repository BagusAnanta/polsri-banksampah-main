  <!-- Modal -->
  <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload Document</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="file" name="doc" id="doc" class="form-control" multiple>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Back</button>
            <button type="button" onclick="upload()" class="btn btn-primary">Upload</button>
          </div>
      </div>
    </div>
  </div>
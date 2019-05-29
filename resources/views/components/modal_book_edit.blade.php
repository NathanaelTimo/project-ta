<div class="modal fade" tabindex="-1" role="dialog" id="modal-book-edit">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="was-validated" @submit.prevent="update">
        <div class="modal-body">
          <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" v-model="title" required>
            <div class="invalid-feedback">Required</div>
          </div>
          <div class="form-group">
            <multiselect
              v-model="categories_id"
              :options="listCategories"
              placeholder="Select Category"
              label="name"
              track-by="id">
            </multiselect>
            <div class="invalid-feedback">Required</div>
          </div>
          <div class="form-group">
            <label>QTY</label>
            <input type="text" class="form-control" v-model="qty" required>
            <div class="invalid-feedback">Required</div>
          </div>
          <div class="form-group">
            <label>Price</label>
            <input type="text" class="form-control" v-model="price" required>
            <div class="invalid-feedback">Required</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
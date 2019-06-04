<div class="modal fade" tabindex="-1" role="dialog" id="modal-sale-create">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="was-validated" @submit.prevent="create(true)">
        <div class="modal-body">
          <div class="form-group">
            <label>Customer Name</label>
            <input type="text" class="form-control" v-model="customer_name" required>
            <div class="invalid-feedback">Required</div>
          </div>
          <div class="form-group">
            <label>Book - Category</label>
            <multiselect
              v-model="books"
              :options="listBooks"
              :custom-label="customLabel"
              placeholder="Select Book"
              label="title"
              track-by="id"
              @input="getDetail()">
            </multiselect>
            <div class="invalid-feedback">Required</div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>QTY</label>
                <input type="text" class="form-control" v-model="qty" readonly>
                <div class="invalid-feedback">Required</div>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <label>Price</label>
                <input type="text" class="form-control" v-model="price" readonly>
                <div class="invalid-feedback">Required</div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Amount</label>
                <input type="text" class="form-control" v-model="amount" required>
                <div class="invalid-feedback">Required</div>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <label>Cost</label>
                <input type="text" class="form-control" v-model="cost" readonly>
                <div class="invalid-feedback">Required</div>
              </div>
            </div>
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
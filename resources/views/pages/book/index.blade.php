@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">Book</div>

        <div class="card-body">
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">File</label>
            <div class="col-md-9">
              <input type="file" id="file" class="btn btn-default" ref="file" @change="handleFileUpload()">
              <button @click="submitFile()" class="btn btn-primary" :disabled="disabled">Import File</button>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-6">
              <a :href="url_download" class="btn btn-warning float-right">Download Template</a>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-12">
              <table class="table table-bordered" id="books-table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>QTY</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
  var tables = $('#books-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: 'book/get-data',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'title', name: 'title' },
      { data: 'categories.name', name: 'categories.name' },
      { data: 'qty', name: 'qty' },
    ]
  });
  tables.on('order.dt search.dt', function () {
    tables.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
      cell.innerHTML = i+1;
    });
  }).draw();
});

var app = new Vue({
  el: '#app',
  data: {
    file: '',
    disabled: true,
    url_download: 'book/download-template',
  },
  methods: {
    async submitFile() {
      let formData = new FormData();
      formData.append('file', this.file);
      const { data } = await axios.post('book/import', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      if(data.success) {
        alert('success');
        $('#books-table').DataTable().ajax.reload();
      }
      else {
        alert('error');
        console.log(data.console);
      }
    },
    handleFileUpload: function() {
      this.file = this.$refs.file.files[0];
      if(this.file) {
        this.disabled = false;
      }
    },
    update: function(id) {
      $("#modal-book-edit").modal('show');
    },
    async delete(id) {
      try {
        const response = await axios.delete('book/'+id);
        $('#books-table').DataTable().ajax.reload();
        Toast.fire({
          type: 'success',
          title: 'Deleted'
        });
        console.log(response);
      } catch (error) {
        console.error(error);
      }
    }
  }
})
</script>
@endpush
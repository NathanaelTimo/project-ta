@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-12">
              <table class="table table-bordered" id="categories-table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Name</th>
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
  var tables = $('#categories-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: 'category/get-data',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'name', name: 'name' },
    ]
  });
  tables.on('order.dt search.dt', function () {
    tables.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
      cell.innerHTML = i+1;
    });
  }).draw();
});

var app = new Vue({
  el: '#app',
  data: {
    message: 'Hello Vue!',
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
  }
})
</script>
@endpush
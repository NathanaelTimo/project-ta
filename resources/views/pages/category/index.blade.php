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
                    <th>Book(s) QTY</th>
                    <th>Edit</th>
                    <th>Delete</th>
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
    order: [[ 1, 'asc' ]],
    columns: [
      { data: 'id', name: 'id', searchable: false },
      { data: 'name', name: 'name' },
      { data: 'books_count', name: 'books_count', searchable: false },
      /* EDIT */ {
        mRender: function (data, type, row) {
          return '<a class="table-edit" data-id="' + row['id'] + '">EDIT</a>'
        }
      },
      /* DELETE */ {
        mRender: function (data, type, row) {
          return '<a class="table-delete" data-id="' + row['id'] + '">DELETE</a>'
        }
      },
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
  }
})
</script>
@endpush
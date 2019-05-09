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
                    <th>Action</th>
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

@component('components.modal_edit', ['title' => 'Edit Category'])
@endcomponent
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
      /* ACTION */ {
        render: function (data, type, row) {
          return "<button onclick='modalEdit("+row.id+")' class='btn btn-sm btn-primary'>Edit</button>&nbsp;<button onclick='return checkDelete("+row.id+")' class='btn btn-sm btn-danger'>Delete</button>";
        }, orderable: false, searchable: false
      },
    ]
  });
  tables.on('order.dt search.dt', function () {
    tables.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
      cell.innerHTML = i+1;
    });
  }).draw();
});

function modalEdit(id) {
  app.update(id);
}

function checkDelete(id) {
  Swal.fire({
    title: 'Are you sure?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if(result.value) {
      app.delete(id);
    }
  })
}

var app = new Vue({
  el: '#app',
  data: {
    file: '',
    disabled: true,
    url_download: 'book/download-template',
  },
  methods: {
    update: function(id) {
      $("#modal-category-edit").modal('show');
    },
    async delete(id) {
      try {
        const response = await axios.delete('category/'+id);
        $('#categories-table').DataTable().ajax.reload();
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
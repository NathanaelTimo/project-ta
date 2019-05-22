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

@component('components.modal_book_edit', ['title' => 'Edit Book'])
@endcomponent

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
      /* ACTION */ {
        render: function (data, type, row) {
          return "<button id='modal-edit' class='btn btn-sm btn-primary' data-id='"+row.id+"' data-title='"+row.title+"' data-categories-id='"+row.categories_id+"' data-qty='"+row.qty+"'>Edit</button>&nbsp;<button onclick='checkDelete("+row.id+")' class='btn btn-sm btn-danger'>Delete</button>";
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

$(document).on('click', '#modal-edit',function() {
  app.id = ($(this).data('id'));
  app.title = ($(this).data('title'));
  app.categories_id = ($(this).data('categories-id'));
  app.qty = ($(this).data('qty'));
  let obj = app.listCategories.find(o => o['id'] == app.categories_id);
  app.categories_id = obj;
  $("#modal-book-edit").modal('show');
});

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

Vue.component('multiselect', window.VueMultiselect.default);
var app = new Vue({
  el: '#app',
  data: {
    file: '',
    disabled: true,
    url_download: 'book/download-template',
    id: '',
    title: '',
    categories_id: '',
    qty: '',
    listCategories: [],
  },
  created() {
    this.getCategory();
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
        Toast.fire({
          type: 'success',
          title: 'Imported'
        });
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
    async getCategory() {
      try {
        const response = await axios.get('category/get-datatables');
        this.listCategories = response.data.data;
        console.log(response);
      } catch (error) {
        console.error(error);
      }
    },
    async update(id) {
      try {
        const response = await axios.patch('book/'+app.id, {
          title: this.title,
          categories: this.categories_id,
          qty: this.qty,
        });
        $('#modal-book-edit').modal('hide');
        $('#books-table').DataTable().ajax.reload();
        Toast.fire({
          type: 'success',
          title: 'Updated'
        });
        console.log(response);
      } catch(error) {
        console.error(error);
      }
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
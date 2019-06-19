@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Sale</div>
        <div class="card-body">
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">File</label>
            <div class="col-md-8">
              <input type="file" id="file" class="btn btn-default" ref="file" @change="handleFileUpload()">
              <button @click="submitFile()" class="btn btn-primary" :disabled="disabled">Import File</button>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-6">
              <a :href="url_download.xlsx" class="btn btn-warning float-right">Download Template XLSX</a>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-12">
              <table class="table table-bordered" id="sales-table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Invoice No.</th>
                    <th>Invoice Date</th>
                    <th>Customer Name</th>
                    <th>Description</th>
                    <th>Item</th>
                    <th>QTY</th>
                    <th>Total</th>
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
  var tables = $('#sales-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/sale/get-data',
    order: [[ 1, 'asc' ]],
    columns: [
      { data: null, name: null, searchable: false, orderable: false },
      { data: 'no_invoice', name: 'no_invoice' },
      { data: 'date_invoice', name: 'date_invoice',
        render: function(data) {
          return moment(data).format('DD MMM YYYY');
        }
      },
      { data: 'customer_name', name: 'customer_name' },
      { data: 'description', name: 'description' },
      { data: 'item.name', name: 'item.name' },
      { data: 'qty', name: 'qty' },
      { data: 'total', name: 'total',
        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp')
      },
    ]
  });
  tables.on('draw.dt', function () {
      var info = tables.page.info();
      tables.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
          cell.innerHTML = i + 1 + info.start;
      });
  });
});

var app = new Vue({
  el: '#app',
  data: {
    file: '',
    disabled: true,
    url_download: {
      xlsx: '/sale/download-template-xlsx',
    },
  },
  created() {
  },
  methods: {
    async submitFile() {
      let formData = new FormData();
      formData.append('file', this.file);
      const { data } = await axios.post('/sale/import', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      if(data.success) {
        Toast.fire({
          type: 'success',
          title: 'Imported'
        });
        $('#sales-table').DataTable().ajax.reload();
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
  },
})
</script>
@endpush
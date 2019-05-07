@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
          @endif

          You are logged in! @{{ message }}
          <br>
          <a :href="url_download" class="btn btn-warning pull-right">Download Template</a>
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">File</label>
            <div class="col-md-7">
              <input type="file" id="file" class="btn btn-default" ref="file" @change="handleFileUpload()">
              <button @click="submitFile()" class="btn btn-primary" :disabled="disabled">Import File</button>
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
        //this.$toastr('success',this.$t('common.data_saved_successfully'),this.$t('common.success'));
        //this.$eventHub.$emit('refresh-ajaxtable', 'data-alih-tugas');
      }
      else {
        //this.$toastr('error',data.message ? data.message : this.$t('error_fault'),this.$t('error'));
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
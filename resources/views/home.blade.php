@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
          <a href="{{ route('book.index') }}">Book</a><br>
          <a href="{{ route('category.index') }}">Category</a>
          <line-chart
            v-if="loaded"
            :chart-label="label"
            :chart-data="data"/>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
Vue.component('line-chart', {
  extends: VueChartJs.Bar,
  props: ['chartLabel', 'chartData'],
  data: function () {
    return {
      datacollection: {
        labels: [],
        datasets: [{
          label: 'Total',
          backgroundColor: 'rgba(75, 192, 192, 1)',
          data: []
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    }
  },
  mounted() {
    this.datacollection.labels = this.chartLabel;
    this.datacollection.datasets[0].data = this.chartData;
    this.renderChart(this.datacollection, this.options)
  },
});

var app = new Vue({
  el: '#app',
  data: {
    loaded: false,
    label: [],
    data: [],
  },
  created() {
    this.getCategory();
  },
  methods: {
    async getCategory() {
      this.loaded = false;
      try {
        const response = await axios.get('category/get-chart');
        this.label = response.data.label;
        this.data = response.data.data;
        this.loaded = true;
        console.log(response);
      } catch (error) {
        console.error(error);
      }
    },
  }
});
</script>
@endpush
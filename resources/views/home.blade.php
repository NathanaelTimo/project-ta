@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Dashboard</div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <select>
                <option></option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <bar-chart
                :chart-id="sale.id"
                :chart-title="sale.title"
                :chart-url="sale.url"
                :chart-bgcolor="sale.bgcolor">
              </bar-chart>
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
Vue.component('bar-chart', {
  extends: VueChartJs.Bar,
  props: ['chartTitle', 'chartUrl', 'chartBgcolor'],
  data: function () {
    return {
      datacollection: {
        labels: [],
        datasets: [{
          label: 'Grand QTY',
          backgroundColor: '',
          borderColor: 'rgb(0, 0, 0)',
          borderWidth: 2,
          data: []
        }]
      },
      options: {
        title: {
          display: true,
          text: ''
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        },
        responsive: true,
        maintainAspectRatio: false
      }
    }
  },
  created() {
    this.getChartData();
  },
  methods: {
    getChartData() {
      axios.get(this.chartUrl, {
          params: {}
        }).then((response) => {
          this.datacollection.labels = response.data.label;
          this.datacollection.datasets[0].data = response.data.data;
          console.log(response);
        }).catch((error) => {
          console.log(error);
        }).then(() => {
          this.options.title.text = this.chartTitle;
          this.datacollection.datasets[0].backgroundColor = this.chartBgcolor;
          this.renderChart(this.datacollection, this.options);
        });
    },
  }
});

var app = new Vue({
  el: '#app',
  data: {
    sale: {
      id: 'sale-chart',
      title: 'Sale Chart',
      url: 'sale/get-chart',
      bgcolor: '#007bff',
    },
  },
});
</script>
@endpush
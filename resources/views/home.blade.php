@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Dashboard</div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-3">
              <label>Month</label>
              <select class="custom-select" @change="getMonth()" v-model="month">
                <option value="all">All</option>
                <option v-for="(value, index) in listMonths" :value="index">@{{ value }}</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Top 3 Item</h5>
                  <p class="card-text" v-for="row in top.item">
                    @{{ row.name }} - @{{ row.qty }} qty
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Top 3 Customer</h5>
                  <p class="card-text" v-for="row in top.customer">
                    @{{ row.customer_name }} - @{{ row.qty }} qty
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <bar-chart
                v-if="loaded"
                :chart-id="sale.id"
                :chart-data="datacollection"
                :chart-options="options">
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
var barChart = Vue.component('bar-chart', {
  extends: VueChartJs.Bar,
  props: ['chartData', 'chartOptions'],
  mounted() {
    this.renderChart(this.chartData, this.chartOptions);
  },
});

var app = new Vue({
  el: '#app',
  data: {
    top: {
      item: 0,
      customer: '',
    },
    loaded: false,
    datacollection: {
      labels: [],
      datasets: [{
        label: 'Grand QTY',
        backgroundColor: '#007bff',
        borderColor: 'rgb(0, 0, 0)',
        borderWidth: 2,
        data: []
      }]
    },
    options: {
      title: {
        display: true,
        text: 'Sale Chart',
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
    },
    sale: {
      id: 'sale-chart',
      url: '/statistic/get-chart',
    },
    listMonths: moment.months(),
    month: 'all',
  },
  mounted() {
    this.getTopItem();
    this.getTopCustomer();
    this.getChartData();
  },
  methods: {
    async getTopItem() {
      try {
        const response = await axios.get('/statistic/get-top-item', {
          params: {
            month: this.month,
          }
        });
        this.top.item = response.data;
        console.log(response);
      } catch (error) {
        console.error(error);
      }
    },
    async getTopCustomer() {
      try {
        const response = await axios.get('/statistic/get-top-customer', {
          params: {
            month: this.month,
          }
        });
        this.top.customer = response.data;
        console.log(response);
      } catch (error) {
        console.error(error);
      }
    },
    async getChartData() {
      this.loaded = false;
      try {
        const response = await axios.get(this.sale.url, {
          params: {
            month: this.month,
          }
        });
        let label = response.data.label;
        let data = response.data.data;
        this.datacollection.labels = label;
        this.datacollection.datasets[0].data = data;
        this.loaded = true;
        console.log(response);
      } catch (error) {
        console.error(error);
      }
    },
    getMonth() {
      this.getTopItem();
      this.getTopCustomer();
      this.getChartData();
    }
  }
});
</script>
@endpush
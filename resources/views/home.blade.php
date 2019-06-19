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
    top: {
      item: 0,
      customer: '',
    },
    sale: {
      id: 'sale-chart',
      title: 'Sale Chart',
      url: '/statistic/get-chart',
      bgcolor: '#007bff',
    },
    listMonths: moment.months(),
    month: 'all',
  },
  created() {
    this.getTopItem();
    this.getTopCustomer();
  },
  methods: {
    async getTopItem() {
      try {
        const response = await axios.get('/statistic/get-top-item');
        this.top.item = response.data;
        console.log(response);
      } catch (error) {
        console.error(error);
      }
    },
    async getTopCustomer() {
      try {
        const response = await axios.get('/statistic/get-top-customer');
        this.top.customer = response.data;
        console.log(response);
      } catch (error) {
        console.error(error);
      }
    },
    getMonth() {
      if(this.month != 'all') {
        this.month = this.month+1;
      }
      console.log(this.month);
    }
  }
});
</script>
@endpush
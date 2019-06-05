@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
          <a href="{{ route('book.index') }}">Book</a><br>
          <a href="{{ route('category.index') }}">Category</a><br>
          <a href="{{ route('sale.index') }}">Sale</a>
          <bar-chart
            :chart-id="category.id"
            :chart-title="category.title"
            :chart-url="category.url"
            :chart-bgcolor="category.bgcolor">
          </bar-chart>
          <bar-chart
            :chart-id="book.id"
            :chart-title="book.title"
            :chart-url="book.url"
            :chart-bgcolor="book.bgcolor">            
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
          label: 'Total',
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
    category: {
      id: 'category-chart',
      title: 'Category Chart',
      url: 'category/get-chart',
      bgcolor: '#007bff',
    },
    book: {
      id: 'book-chart',
      title: 'Book Chart',
      url: 'book/get-chart',
      bgcolor: '#28a745',
    },
  },
});
</script>
@endpush
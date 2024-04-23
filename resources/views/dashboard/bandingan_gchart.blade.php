@extends('layout.dashboard')
@section('breadcrumb')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('/template/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Bulan', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['Utiliti', 'Amaun'],
            ['Elektrik',     3000000],
            ['Air',      1250000],
            ['Telefon',  1300000]
          ]);
  
          var options = {
            title: 'My Daily Activities',
            // pieSliceText: 'value-and-percentage',
            pieHole: 0.4,
          };
  
          var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
          chart.draw(data, options);
        }
      </script>
  

@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <form id="myForm" method="post" action="dashboard">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <div class="row">
                        <div class="col-md-2">
                            {{ Form::select('kategori', dropdownKategori(), session('kategori'), ['class'=>'form-control kategori', 'id'=>'kategori'])}}
                        </div>
                        <div class="col-md-1">
                            {{ Form::select('negeri', dropdownNegeri(), session('negeri'), ['class'=>'form-control negeri', 'id'=>'negeri'])}}
                           
                        </div>                        
                        <div class="col-md-1">
                            {{ Form::select('tahun', dropdownYear(), session('tahun'), ['class'=>'form-control tahun', 'id'=>'tahun'])}}
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-info btn-block" onclick="location.href='dashboard';">
                                <i class="fas fa-bars"></i> Semua
                            </button>
                        </div>
                        <div class="col-md-6" style="text-align: right"><h3 class="text-red">(RM)</h3></div>
                    </div>
                </div>
            </div> 
        </div>
        </form>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-8">
                <!-- BAR CHART -->
                <div class="card card-danger">
                    <div class="card-body">
                        <div id="curve_chart" style="height: 500px"></div>

                    </div>
                </div> 
            </div>
            <div class="col-md-4">
                <!-- DONUT CHART -->
                <div class="card card-danger">
                    <div class="card-body">
                        <div id="donutchart"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
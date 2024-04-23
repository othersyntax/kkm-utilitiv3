@extends('layouts.dashboard')
@section('breadcrumb')
@endsection
@section('custom-css')
@php
$kpiMin = 80000000;
$kpiMax = 300000000;
@endphp
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('/template/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://www.google.com/jsapi"></script>

<script type="text/javascript">
    google.charts.load('current', {
        callback: function(){
            var data = new google.visualization.arrayToDataTable(@json($negeri));

            // var view = new google.visualization.DataView(data);
            // view.setColumns([0, 1]);

            var options = {
                region: 'MY',
                displayMode: 'regions',
                resolution: 'provinces',
                // colorAxis: {minValue: {{ $kpiMin }}, maxValue: {{ $kpiMax }}, colors: ['#24b500', '#feb2ae', '#fd0202']},
                colorAxis: {colors: ['#24b500', '#feb2ae', '#fd0202']},
                height: 550,
            };

            var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

            google.visualization.events.addListener(chart, 'select', function () {
                var selection = chart.getSelection();
                if (selection.length > 0) {
                    window.open('dashboard?negeri=' + data.getValue(selection[0].row, 0).slice(-2), '_self');
                }
            });
            chart.draw(data, options);
        },
        'packages':['geochart'],
        'mapsApiKey': 'AIzaSyD4lz4VTknTzKB3PCAhYnV3a1F6vJYDYt0'
    });
</script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        
        var data = google.visualization.arrayToDataTable(@json($barchart));
        var options = {
            hAxis: {title: 'Bulan',  titleTextStyle: {color: '#333'}},
            vAxis: {
                minValue: 0,
                format: 'short'
            }
        };

        var chart = new google.visualization.AreaChart(document.getElementById('barchart_material'));
        chart.draw(data, options);
      }
</script>

@endsection
@section('content')

@php
if(request()->get('tahun')){
    $title = 'Bagi tahun '.request()->get('tahun');
}
else{
    $title = '';
}

if(request()->get('negeri')){
    $state_title = getNegeri(request()->get('negeri'));
}
else{
    $state_title = 'MALAYSIA';
}


    
@endphp

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
            <!-- Info boxes -->
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
                        <div class="col-md-6" style="text-align: right"><h3 class="text-red">(RM) {{ number_format($eletrik + $air + $telefon,2) }}</h3></div>
                    </div>
                </div>
            </div> 
        </div>
        </form>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Jumlah Bayaran Uitiliti Mengikut Negeri</h5>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <h4 class="text-center text-info">
                                {{ $state_title }}
                            </h4>
                            <div id="regions_div"></div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-5">
                            <p class="text-center"><strong>Bayaran Utiliti {{ $title }}</strong></p>
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th width="25%">Negeri</th>
                                        <th width="25%" class="text-right">Elektrik (RM)</th>
                                        <th width="25%" class="text-right">Air (RM)</th>
                                        <th width="25%" class="text-right">Telefon (RM)</th>
                                    </tr>   
                                </thead>
                                <tbody>
                                    @php
                                        $atotal=0;
                                        $etotal=0;
                                        $ttotal=0;
                                    @endphp                                    
                                    @foreach ($statedata as $key=>$currentRow)
                                        @if (request()->get('negeri') == $currentRow->neg_kod_negeri )
                                            <tr class="table-info">
                                                <td>{{ $currentRow->neg_nama_negeri }}</td>
                                                <td class="text-right">{{ number_format($currentRow->eletrik,2) }}</td>
                                                <td class="text-right">{{ number_format($currentRow->air,2) }}</td>                                        
                                                <td class="text-right">{{ number_format($currentRow->telefon,2) }}</td>                                        
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $currentRow->neg_nama_negeri }}</td>
                                                <td class="text-right">{{ number_format($currentRow->eletrik,2) }}</td>
                                                <td class="text-right">{{ number_format($currentRow->air,2) }}</td>                                       
                                                <td class="text-right">{{ number_format($currentRow->telefon,2) }}</td>                                       
                                            </tr>
                                        @endif
                                        @php
                                            $atotal +=  $currentRow->air;
                                            $etotal +=  $currentRow->eletrik;
                                            $ttotal +=  $currentRow->telefon;
                                        @endphp                                      
                                    @endforeach                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Jumlah</th>
                                        <th class="text-right">{{ number_format($etotal,2) }}</th>
                                        <th class="text-right">{{ number_format($atotal,2) }}</th>
                                        <th class="text-right">{{ number_format($ttotal,2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            
                        </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-2 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0.00%</span>
                                <h5 class="description-header">0.00</h5>
                                <span class="description-text">2018</span>
                            </div>
                        </div>
                        @php
                            $border = '';
                            $text = '';
                            $icon = '';
                        @endphp
                        @foreach ($tahunan as $key=>$currentRow)
                            @php
                                
                                $border = 'border-right';
                                if(isset($tahunan[$key - 1])){
                                    $nextRow = $tahunan[$key - 1];

                                    $peratus = (($currentRow->amaun - $nextRow->amaun) / $currentRow->amaun) *100;

                                    if($currentRow->amaun > $nextRow->amaun){
                                        $text = 'text-danger';
                                        $icon = 'fas fa-caret-up';                                        
                                    }
                                    else if($currentRow->amaun == $nextRow->amaun){
                                        $text = 'text-warning';
                                        $icon = 'fas fa-caret-left';
                                    }
                                    else{
                                        $text = 'text-success';
                                        $icon = 'fas fa-caret-down';
                                    }
                                }
                                else{
                                    $peratus = 0;
                                    $text = 'text-warning';
                                    $icon = 'fas fa-caret-left';
                                }
                            @endphp
                            <div class="col-sm-2 col-6">
                                <div class="description-block {{ $border }}">
                                    <span class="description-percentage {{ $text }}"><i class="{{ $icon}}"></i> {{ number_format($peratus,2)}}%</span>
                                    <h5 class="description-header">RM {{ number_format($currentRow->amaun,2) }}</h5>
                                    <span class="description-text">{{ $currentRow->tahun }}</span>
                                </div>
                            </div>
                        @endforeach                      
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h6>Senarai Fasiliti</h6>
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed">
                                <thead>
                                    <tr>
                                        <th width="5%">Bil</th>
                                        <th width="70%">Fasilitii</th>
                                        <th width="25%" class="text-right">Amaun (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($fasiliti as $fas)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ ucfirst($fas->fas_name) }}</td>
                                            <td class="text-right"><a href="#" id="{{ $fas->fasiliti_id }}" class="papar_fasiliti" title="Papar">
                                                {{ number_format($fas->amaun,2) }}</a>
                                            </td>
                                        </tr>
                                    @endforeach                  
                                </tbody>                        
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <h6>Bayaran Bulanan Utiliti {{ $title }}</h6>
                        <div id="barchart_material" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- /.container-fluid -->
</section>

<div class="modal fade" id="mod_hospital">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="nama_hospital"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="barchart_material1"></div>
            </div>   
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                {{-- <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button> --}}
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
<!-- /.content -->
@endsection
@section('js')
    <!-- Select2 -->
    <script src="{{ asset('/template/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        //Initialize Select2 Elements
        $('.kategori').select2({
            theme: 'bootstrap4'
        });

        // $('.negeri').select2({
        //     theme: 'bootstrap4'
        // });

        // $('.tahun').select2({
        //     theme: 'bootstrap4'
        // });

        $("#kategori").change(function(e){    
            document.getElementById("myForm").submit();
        });

        $("#negeri").change(function(e){    
            document.getElementById("myForm").submit();
        });

        $("#tahun").change(function(e){    
            document.getElementById("myForm").submit();
        });

        $('.papar_fasiliti').click(function(){  
            let fasiliti_id = $(this).attr("id");
            let tahun = "{{ session('tahun') }}";          

            $.ajax({  
                url:"/fasiliti",  
                method:"POST",  
                data:{
                    _token: "{{ csrf_token() }}",
                    fasiliti_id:fasiliti_id,
                    tahun:tahun
                },  
                dataType: "json",  
                success:function(terimadata){
                    var data_arr = [
                        ['Bulan', 'Elektrik', 'Air', 'Telefon'],                         
                    ];

                    $.each(terimadata, function(index, value){
                        data_arr.push([value.Bulan, parseFloat(value.Elektrik), parseFloat(value.Air) , parseFloat(value.Telefon)]);
                    });

                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart1);

                    function drawChart1() {
                        
                        var data1 = google.visualization.arrayToDataTable(data_arr);
                        var options1 = {
                            hAxis: {title: 'Bulan',  titleTextStyle: {color: '#333'}},
                            vAxis: {
                                minValue: 0,
                                format: 'short'
                            }
                        };
                        var chart1 = new google.visualization.AreaChart(document.getElementById('barchart_material1'));
                        chart1.draw(data1, options1);
                    }
                }, error: function(){
                    alert('error');
                } 
            });
            tahun_title ='';
            if(tahun !=''){
                var tahun_title = ' Bagi Tahun '+ tahun;
            }

            $('#nama_hospital').html("Bayaran Uitliti" + tahun_title);
            $('#mod_hospital').modal('show');            
        });

    </script>
    <script src="{{ asset('/template/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('/template/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('/template/plugins/chart.js/Chart.min.js') }}"></script>
@endsection
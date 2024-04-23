@extends('layouts.dashboard')
@section('custom-css')
 <!-- DataTables -->
 <link rel="stylesheet" href="{{ asset('/template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
 <link rel="stylesheet" href="{{ asset('/template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
 <link rel="stylesheet" href="{{ asset('/template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://www.google.com/jsapi"></script>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info text-right">
                    <button id="banding_btn" class="btn btn-primary">
                        Bandingkan <span class="badge badge-danger navbar-badge bilPilih">0</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fasiliti</th>
                                <th>Kategori</th>
                                <th>Negeri</th>
                                <th>Pilihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $bil=1;
                            @endphp
                            @foreach ($fasiliti as $fas)
                                <tr>
                                    <td class="text-center">{{ $bil++ }}</td>
                                    <td>{{ $fas->fas_name }}</td>
                                    <td>{{ $fas->faskat_desc }}</td>
                                    <td>{{ $fas->neg_nama_negeri }}</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input name="bilPilih" value="{{ $fas->fasiliti_id}}" class="form-check-input selectId" type="checkbox">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</section>
<div class="modal fade" id="banding_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Perbandingan</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="curve_chart"></div>
                    </div>
                </div>
            </div>                
        </div>
    </div>
</div>
@endsection
@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('/template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/template/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('/template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('/template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        $("input[name='bilPilih']").on('click',function(e) {
            var dahPilih = $("input[name='bilPilih']:checked");
            $('.bilPilih').html(dahPilih.length);
        });


        $('#banding_btn').on('click', function(e){
            e.preventDefault();

            const fasSelectID = [];
            $('.selectId').each(function(){
                if($(this).is(":checked")){
                    fasSelectID.push($(this).val());
                }
            });
            $('#banding_modal').modal('show');
            // console.log(fasSelectID);
            // ajax()
            $.ajax({ 
                url:"/getDataBandingan",  
                method:"POST",  
                data:{
                    _token: "{{ csrf_token() }}",
                    fasSelectID:fasSelectID
                },  
                dataType: "json",  
                success:function(terimadata){
                    var data_arr = [
                        ['Fasiliti', 'Jan', 'Feb', 'Mac' , 'Apr', 'Mei', 'Jun', 'Jul', 'Ogo', 'Sep', 'Okt', 'Nov', 'Dis'],                         
                    ];

                    $.each(terimadata, function(index, value){
                        data_arr.push([value.fas_name, parseFloat(value.Jan), parseFloat(value.Feb), parseFloat(value.Mac), parseFloat(value.Apr), parseFloat(value.Mei), parseFloat(value.Jun), parseFloat(value.Jul), parseFloat(value.Ogo), parseFloat(value.Sep), parseFloat(value.Okt), parseFloat(value.Nov), parseFloat(value.Dis)]);
                    });

                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable(data_arr);
                        var options = {
                            title: 'Perbandingan Penggunaan Utiliti Mengikut Fasiliti',
                            curveType: 'function',
                            width:1000,
                            height:500,
                            legend: { position: 'bottom' }
                        };
                        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                        chart.draw(data, options);
                        $('#banding_modal').modal('show');
                    }                    
                }               
            });
        });
    });
  </script>

@endsection
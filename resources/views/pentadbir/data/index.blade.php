@extends('layouts.main')
@section('custom-css')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('/template/plugins/toastr/toastr.min.css') }}">                         
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">        
        <div class="card">
            <div class="card-body">
                <div class="card card-purple card-outline">
                    <div class="card-body">
                        <form action="/pentadbir/data/simpan" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="failExcel">Pilih Fail</label>
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input" name="failExcel">
                                      <label class="custom-file-label" for="failExcel">Nama Fail</label>
                                    </div>
                                </div>
                            </div>                            
                            <div class="col-md-6">
                                @error('failExcel')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="margin" style="float:right;">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary">Muatnaik Fail</button>
                                    </div>                                            
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-12 mt-2">
                    <div class="card card-purple card-outline">
                        <div class="card-body">
                            <div class="row mt-2">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">#ID</th>
                                        <th width="10%" class="text-center">Kod Sesi</th>
                                        <th width="20%" class="text-center">ID Fasiliti</th>
                                        <th width="15%" class="text-right">Tarikh</th>
                                        <th width="15%" class="text-center">Kod Jenis</th>
                                        <th width="20%" class="text-right">Amaun (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data)>0)
                                        @foreach ($data as $d)
                                            <tr>
                                                <td class="text-center">{{ $d->utiliti_id }}</td>
                                                <td class="text-center">{{ $d->uti_session }}</td>
                                                <td class="text-center">{{ $d->uti_fasiliti_id }}</td>
                                                <td class="text-right">{{ $d->uti_date }}</td>
                                                <td class="text-center">{{ $d->uti_type }}</td>
                                                <td class="text-right">{{ $d->uti_amaun }}</td>
                                            </tr>
                                        @endforeach                                        
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center"><small><i>Tiada Rekod, sila muatnaik data</i></small></td>
                                        </tr>
                                    @endif
                                    
                                </tbody>
                            </table>
                            </div>
                            <div class="row mt-2">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<!-- bs-custom-file-input -->
<script src="/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('/template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('/template/plugins/toastr/toastr.min.js') }}"></script>

<script>
    $(function () {
      bsCustomFileInput.init();
    });
</script>
@endsection
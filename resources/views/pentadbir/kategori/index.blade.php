@extends('layouts.main')
@section('custom-css')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('/template/plugins/toastr/toastr.min.css') }}">                         
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div id="success_message"></div>
        <div class="card">
            <div class="card-body">
                <div class="card card-purple card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jenis Carian</label>
                                    {{ Form::select('carian_type', [''=>'--Sila pilih--', 'Kod'=>'Kod Kategori', 'Nama'=>'Nama'], session('carian_type'), ['class'=>'form-control', 'id'=>'carian_type']) }}
                                </div>                                    
                            </div>
                            <div class="col-md-8">                                
                                <div class="form-group">
                                    <label>Carian</label>
                                    {{ Form::text('carian_text', session('carian_text'),['class'=>'form-control', 'id'=>'carian_text']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="margin" style="float:right;">
                                    <div class="btn-group">
                                        <a href="{{ route('kategori.senarai') }}" class="btn bg-default">Set Semula</a>
                                    </div>
                                    <div class="btn-group">
                                        <input type="button" class="btn btn-primary" id="carian" value="Carian">
                                    </div>                                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12"> 
                    <div class="text-right">  
                        <button type="button" name="add" id="add" class="btn btn-primary">Tambah</button>  
                    </div>
                </div>
                <div class="col-sm-12 mt-2">
                    <div class="card card-purple card-outline">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">#ID</th>
                                        <th width="20%">Kod Kategori</th>
                                        <th width="40%">Kategori</th>
                                        <th width="15%">Status</th>
                                        <th width="20%">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="AddKategoriModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Kategori</h4>                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="save_msgList"></ul>
                <div class="form-group">
                    <label for="faskat_kod">Kod Kategori</label>
                    <input id="faskat_kod" type="text" class="form-control faskat_kod" name="faskat_kod">
                </div>
                <div class="form-group">
                    <label for="faskat_desc">Kategori</label>
                    <input id="faskat_desc" type="text" class="form-control faskat_desc" name="faskat_desc">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary add_kategori">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade"  id="EditKategoriModal" tabindex="-1" aria-labelledby="EditKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kemaskini Kategori</h4>                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_faskat_id">
                <ul id="update_msgList"></ul>
                <div class="form-group">
                    <label for="faskat_kod">Kod Kategori</label>
                    <input id="edit_faskat_kod" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="faskat_desc">Kategori</label>
                    <input id="edit_faskat_desc" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    {{ Form::select('edit_faskat_status', [''=>'--Sila pilih--', '1'=>'Aktif', '2'=>'Tidak Aktif'], null, ['class'=>'form-control', 'id'=>'edit_faskat_status']) }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary update_kategori">Kemaskini</button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Padam Maklumat Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Adakah anda pasti?</h4>
                <input type="hidden" id="deleteing_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary delete_kat">Ya, Pasti</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')

<!-- SweetAlert2 -->
<script src="{{ asset('/template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('/template/plugins/toastr/toastr.min.js') }}"></script>

<script>
$(document).ready(function () {

    $('#add').click(function(e){ 
        e.preventDefault();
        $('#AddKategoriModal').modal('show');  
    });

    $('#carian').click(function(e){
        e.preventDefault();
        $carian_type = $('#carian_type').val();
        $carian_text = $('#carian_text').val();
        fetchKategori($carian_type, $carian_text);
    });

    fetchKategori();

    function aliasStatus(id){
        if(id==1)
            return "Aktif";
        else
            return "Tidak Aktif";
    }

    function fetchKategori(carian_type='', carian_text='') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "post",
            url: "/pentadbir/kategori/ajax-all",
            data:{
                    carian_type:carian_type,
                    carian_text:carian_text
                },
            dataType: "json",
            success: function (response) {
                // console.log(response);
                $('tbody').html("");
                $.each(response.cats, function (key, item) {
                    $('tbody').append('<tr>\
                        <td>' + item.faskat_id + '</td>\
                        <td>' + item.faskat_kod + '</td>\
                        <td>' + item.faskat_desc + '</td>\
                        <td>' + aliasStatus(item.faskat_status) + '</td>\
                        <td><button type="button" value="' + item.faskat_id + '" class="btn btn-primary editbtn btn-sm" title="Kemaskini"><i class="fas fa-edit"></i></button>\
                        <button type="button" value="' + item.faskat_id + '" class="btn btn-danger delbtn btn-sm" title="Padam"><i class="fas fa-trash"></i></button></td>\
                    \</tr>');
                });
            }
        });
    }

    $(document).on('click', '.add_kategori', function (e) {
        e.preventDefault();

        $(this).text('Menyimpan..');

        var data = {
            'faskat_kod': $('.faskat_kod').val(),
            'faskat_desc': $('.faskat_desc').val(),
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/pentadbir/kategori/simpan",
            data: data,
            dataType: "json",
            success: function (response) {
                if (response.status == 400) {
                    $('#save_msgList').html("");
                    $('#save_msgList').addClass('alert alert-danger');
                    $.each(response.errors, function (key, err_value) {
                        $('#save_msgList').append('<li>' + err_value + '</li>');
                    });
                    $('.add_kategori').text('Simpan');
                } else {
                    $('#save_msgList').html("");
                    toastr.success(response.message);
                    $('#AddKategoriModal').find('input').val('');
                    $('.add_kategori').text('Simpan');
                    $('#AddKategoriModal').modal('hide');
                    fetchKategori();
                }
            }
        });

    });

    $(document).on('click', '.editbtn', function (e) {
        e.preventDefault();
        var faskat_id = $(this).val();
        $('#EditKategoriModal').modal('show');
        $.ajax({
            type: "GET",
            url: "/pentadbir/kategori/ubah/" + faskat_id,
            success: function (response) {
                if (response.status == 404){
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('#EditKategoriModal').modal('hide');
                } else {
                    $('#edit_faskat_kod').val(response.cats.faskat_kod);
                    $('#edit_faskat_desc').val(response.cats.faskat_desc);
                    $('#edit_faskat_status').val(response.cats.faskat_status).change();
                    $('#edit_faskat_id').val(faskat_id);
                }
            }
        });
        $('.btn-close').find('input').val('');

    });

    $(document).on('click', '.update_kategori', function (e) {
        e.preventDefault();

        $(this).text('Kemaskini..');
        // alert(id);

        var edit_data = {
            'faskat_id': $('#edit_faskat_id').val(),
            'faskat_kod': $('#edit_faskat_kod').val(),
            'faskat_desc': $('#edit_faskat_desc').val(),
            'faskat_status': $('#edit_faskat_status').val(),
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/pentadbir/kategori/kemaskini",
            data: edit_data,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 400) {
                    $('#update_msgList').html("");
                    $('#update_msgList').addClass('alert alert-danger');
                    $.each(response.errors, function (key, err_value) {
                        $('#update_msgList').append('<li>' + err_value +
                            '</li>');
                    });
                    $('.update_kategori').text('Kemaskini');
                } else {
                    $('#update_msgList').html("");
                    toastr.success(response.message);
                    $('#EditKategoriModal').find('input').val('');
                    $('.update_kategori').text('Kemaskini');
                    $('#EditKategoriModal').modal('hide');
                    fetchKategori();
                }
            }
        });

    });

    $(document).on('click', '.delbtn', function () {
        var faskat_id = $(this).val();
        $('#DeleteModal').modal('show');
        $('#deleteing_id').val(faskat_id);
    });

    $(document).on('click', '.delete_kat', function (e) {
        e.preventDefault();

        $(this).text('Memadam...');
        var id = $('#deleteing_id').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "DELETE",
            url: "/pentadbir/kategori/padam/" + id,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 404) {
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('.delete_kat').text('Ya, Padam');
                } else {                    
                    toastr.error(response.message);
                    $('.delete_kat').text('Ya, Padam');
                    $('#DeleteModal').modal('hide');
                    fetchKategori();
                }
            }
        });
    });

});

</script>
@endsection
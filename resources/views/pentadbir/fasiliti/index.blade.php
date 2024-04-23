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
                                    {{ Form::select('carian_type', [''=>'--Sila pilih--', 'Kod'=>'Kod PTJ', 'Nama'=>'Nama', 'Kategori'=>'Kategori'], session('carian_type'), ['class'=>'form-control', 'id'=>'carian_type']) }}
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
                                        <a href="{{ route('fasiliti.senarai') }}" class="btn bg-default">Set Semula</a>
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
                                        <th width="5%">#Kod PTJ</th>
                                        <th width="35%">Nama</th>
                                        <th width="25%">Kategori</th>
                                        <th width="20%">Negeri</th>
                                        <th width="15%">#</th>
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
<div class="modal fade" id="AddFasilitiModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Fasiliti</h4>                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="save_msgList"></ul>
                <div class="form-group">
                    <label for="fas_ptj_code">Kod PTJ</label>
                    <input id="fas_ptj_code" type="text" class="form-control fas_ptj_code" name="fas_ptj_code">
                </div>
                <div class="form-group">
                    <label for="fas_name">Nama</label>
                    <input id="fas_name" type="text" class="form-control fas_name" name="fas_name">
                </div>
                <div class="form-group">
                    <label>Kategori Fasiliti</label>
                    {{ Form::select('fas_kat_kod', dropdownKategori(), session('fas_kat_kod'), ['class'=>'form-control fas_kat_kod', 'id'=>'fas_kat_kod']) }}
                </div>
                <div class="form-group">
                    <label>Negeri</label>
                    {{ Form::select('fas_negeri_id', dropdownNegeri(), session('fas_negeri_id'), ['class'=>'form-control fas_negeri_id', 'id'=>'fas_negeri_id']) }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary add_fasiliti">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade"  id="EditFasilitiModal" tabindex="-1" aria-labelledby="EditFasilitiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kemaskini Pengguna</h4>                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_fasiliti_id">
                <ul id="update_msgList"></ul>
                <div class="form-group">
                    <label for="fas_ptj_code">Kod PTJ</label>
                    <input id="edit_fas_ptj_code" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="fas_name">Nama</label>
                    <input id="edit_fas_name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Kategori Fasiliti</label>
                    {{ Form::select('edit_fas_kat_kod', dropdownKategori(), session('fas_kat_kod'), ['class'=>'form-control', 'id'=>'edit_fas_kat_kod']) }}
                </div>
                <div class="form-group">
                    <label>Negeri</label>
                    {{ Form::select('edit_fas_negeri_id', dropdownNegeri(), session('fas_negeri_id'), ['class'=>'form-control', 'id'=>'edit_fas_negeri_id']) }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary update_fasiliti">Kemaskini</button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Padam Maklumat Fasiliti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Adakah anda pasti?</h4>
                <input type="hidden" id="deleteing_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary delete_fas">Ya, Pasti</button>
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
        $('#AddFasilitiModal').modal('show');  
    });

    $('#carian').click(function(e){
        e.preventDefault();
        $carian_type = $('#carian_type').val();
        $carian_text = $('#carian_text').val();
        fetchFasiliti($carian_type, $carian_text);
    });

    fetchFasiliti();

    function fetchFasiliti(carian_type='', carian_text='') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "post",
            url: "/kkm-utilitiv3/public/pentadbir/fasiliti/ajax-all",
            data:{
                    carian_type:carian_type,
                    carian_text:carian_text
                },
            dataType: "json",
            success: function (response) {
                // console.log(response);
                $('tbody').html("");
                $.each(response.fasiliti, function (key, item) {
                    $('tbody').append('<tr>\
                        <td>' + item.fas_ptj_code + '</td>\
                        <td>' + item.fas_name + '</td>\
                        <td>' + item.faskat_desc + '</td>\
                        <td>' + item.neg_nama_negeri + '</td>\
                        <td><button type="button" value="' + item.fasiliti_id + '" class="btn btn-primary editbtn btn-sm" title="Kemaskini"><i class="fas fa-edit"></i></button>\
                        <button type="button" value="' + item.fasiliti_id + '" class="btn btn-danger delbtn btn-sm" title="Padam"><i class="fas fa-trash"></i></button></td>\
                    \</tr>');
                });
            }
        });
    }

    $(document).on('click', '.add_fasiliti', function (e) {
        e.preventDefault();

        $(this).text('Menyimpan..');

        var data = {
            'fas_ptj_code': $('.fas_ptj_code').val(),
            'fas_name': $('.fas_name').val(),
            'fas_kat_kod': $('.fas_kat_kod').val(),
            'fas_negeri_id': $('.fas_negeri_id').val(),
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/kkm-utilitiv3/public/pentadbir/fasiliti/simpan",
            data: data,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 400) {
                    $('#save_msgList').html("");
                    $('#save_msgList').addClass('alert alert-danger');
                    $.each(response.errors, function (key, err_value) {
                        $('#save_msgList').append('<li>' + err_value + '</li>');
                    });
                    $('.add_fasiliti').text('Simpan');
                } else {
                    $('#save_msgList').html("");
                    toastr.success(response.message);
                    $('#AddFasilitiModal').find('input').val('');
                    $('.add_fasiliti').text('Simpan');
                    $('#AddFasilitiModal').modal('hide');
                    fetchFasiliti();
                }
            }
        });

    });

    $(document).on('click', '.editbtn', function (e) {
        e.preventDefault();
        var fasiliti_id = $(this).val();
        // alert(stud_id);
        $('#EditFasilitiModal').modal('show');
        $.ajax({
            type: "GET",
            url: "/kkm-utilitiv3/public/pentadbir/fasiliti/ubah/" + fasiliti_id,
            success: function (response) {
                if (response.status == 404){
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('#EditFasilitiModal').modal('hide');
                } else {
                    $('#edit_fas_ptj_code').val(response.fasiliti.fas_ptj_code);
                    $('#edit_fas_name').val(response.fasiliti.fas_name);
                    $('#edit_fas_kat_kod').val(response.fasiliti.fas_kat_kod).change();
                    $('#edit_fas_negeri_id').val(response.fasiliti.fas_negeri_id).change();
                    $('#edit_fasiliti_id').val(fasiliti_id);
                }
            }
        });
        $('.btn-close').find('input').val('');

    });

    $(document).on('click', '.update_fasiliti', function (e) {
        e.preventDefault();

        $(this).text('Kemaskini..');
        // alert(id);

        var edit_data = {
            'fasiliti_id': $('#edit_fasiliti_id').val(),
            'fas_ptj_code': $('#edit_fas_ptj_code').val(),
            'fas_name': $('#edit_fas_name').val(),
            'fas_kat_kod': $('#edit_fas_kat_kod').val(),
            'fas_negeri_id': $('#edit_fas_negeri_id').val(),
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/kkm-utilitiv3/public/pentadbir/fasiliti/kemaskini",
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
                    $('.update_fasiliti').text('Kemaskini');
                } else {
                    $('#update_msgList').html("");
                    toastr.success(response.message);
                    $('#EditFasilitiModal').find('input').val('');
                    $('.update_fasiliti').text('Kemaskini');
                    $('#EditFasilitiModal').modal('hide');
                    fetchFasiliti();
                }
            }
        });

    });

    $(document).on('click', '.delbtn', function () {
        var fasiliti_id = $(this).val();
        $('#DeleteModal').modal('show');
        $('#deleteing_id').val(fasiliti_id);
    });

    $(document).on('click', '.delete_fas', function (e) {
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
            url: "/kkm-utilitiv3/public/pentadbir/fasiliti/padam/" + id,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 404) {
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('.delete_fas').text('Ya, Padam');
                } else {                    
                    toastr.error(response.message);
                    $('.delete_fas').text('Ya, Padam');
                    $('#DeleteModal').modal('hide');
                    fetchFasiliti();
                }
            }
        });
    });

});

</script>
@endsection
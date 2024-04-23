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
                                    {{ Form::select('carian_type', [''=>'--Sila pilih--', 'Emel'=>'Emel', 'Nama'=>'Nama'], session('carian_type'), ['class'=>'form-control', 'id'=>'carian_type']) }}
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
                                        <a href="{{ route('pengguna.senarai') }}" class="btn bg-default">Set Semula</a>
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
                                        <th width="30%">Nama</th>
                                        <th width="25%">Emel</th>
                                        <th width="15%">Peranan</th>
                                        <th width="10%">Status</th>
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
<div class="modal fade" id="AddUserModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pengguna</h4>                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="save_msgList"></ul>
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input id="name" type="text" class="form-control name" name="name">
                </div>
                <div class="form-group">
                    <label for="email">Emel</label>
                    <input id="email" type="email" class="form-control email" name="email">
                </div>
                <div class="form-group">
                    <label for="role">Jenis Pengguna</label>
                    <select name="role" id="role" class="form-control role" name="role">
                        <option value="Pengguna">Pengguna</option>
                        <option value="Pentadbir">Pentadbir</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Katalaluan</label>
                    <input id="password" type="password" class="form-control password" name="password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary add_user">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade"  id="EditUserModal" tabindex="-1" aria-labelledby="EditUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kemaskini Pengguna</h4>                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="update_msgList"></ul>
                <input type="hidden" id="edit_user_id" />
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input id="edit_name" type="text" class="form-control name" name="name">
                </div>
                <div class="form-group">
                    <label for="email">Emel</label>
                    <input id="edit_email" type="email" class="form-control email" name="email">
                </div>
                <div class="form-group">
                    <label for="edit_role">Peranan Pengguna</label>
                    {{ Form::select('edit_role', ['Pengguna'=>'Pengguna', 'Pentadbir'=>'Pentadbir'], null, ['class'=>'form-control', 'id'=>'edit_role']) }}
                </div>
                <div class="form-group">
                    <label for="edit_role">Status</label>
                    {{ Form::select('edit_status', ['1'=>'Aktif', '2'=>'Tidak Aktif'], null, ['class'=>'form-control', 'id'=>'edit_status']) }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary update_user">Kemaskini</button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="SetPassModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Set Katalaluan Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Adakah anda pasti?</h4>
                <input type="hidden" id="setpass_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger setpassBtnSubmit">Ya, Pasti</button>
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
        $('#AddUserModal').modal('show');  
    });

    $('#carian').click(function(e){
        e.preventDefault();
        $carian_type = $('#carian_type').val();
        $carian_text = $('#carian_text').val();
        fetchuser($carian_type, $carian_text);
    });

    fetchuser();

    function aliasStatus(id){
        if(id==1)
            return "Aktif";
        else
            return "Tidak Aktif";
    }

    function fetchuser(carian_type='', carian_text='') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "post",
            url: "/pentadbir/pengguna/ajax-all",
            data:{
                    carian_type:carian_type,
                    carian_text:carian_text
                },
            dataType: "json",
            success: function (response) {
                // console.log(response);
                $('tbody').html("");
                $.each(response.users, function (key, item) {
                    $('tbody').append('<tr>\
                        <td>' + item.id + '</td>\
                        <td>' + item.name + '</td>\
                        <td>' + item.email + '</td>\
                        <td>' + item.role + '</td>\
                        <td>' + aliasStatus(item.status) + '</td>\
                        <td><button type="button" value="' + item.id + '" class="btn btn-primary editbtn btn-sm" title="Kemaskini"><i class="fas fa-edit"></i></button> \
                        <button type="button" value="' + item.id + '" class="btn btn-danger setpassBtn btn-sm" title="Set Katalaluan"><i class="fas fa-key"></i></button></td>\
                    \</tr>');
                });
            }
        });
    }

    $(document).on('click', '.add_user', function (e) {
        e.preventDefault();

        $(this).text('Menyimpan..');

        var data = {
            'name': $('.name').val(),
            'email': $('.email').val(),
            'role': $('.role').val(),
            'password': $('.password').val(),
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/pentadbir/pengguna/simpan",
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
                    $('.add_user').text('Simpan');
                } else {
                    $('#save_msgList').html("");
                    toastr.success(response.message);
                    $('#AddUserModal').find('input').val('');
                    $('.add_user').text('Simpan');
                    $('#AddUserModal').modal('hide');
                    fetchuser();
                }
            }
        });

    });

    $(document).on('click', '.editbtn', function (e) {
        e.preventDefault();
        var user_id = $(this).val();
        // alert(stud_id);
        $('#EditUserModal').modal('show');
        $.ajax({
            type: "GET",
            url: "/pentadbir/pengguna/ubah/" + user_id,
            success: function (response) {
                if (response.status == 404) {
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('#EditUserModal').modal('hide');
                } else {
                    // console.log(response.cartype.type);
                    $('#edit_name').val(response.user.name);
                    $('#edit_email').val(response.user.email);
                    $('#edit_role').val(response.user.role).change();
                    $('#edit_status').val(response.user.status).change();
                    $('#edit_user_id').val(user_id);
                }
            }
        });
        $('.btn-close').find('input').val('');

    });

    $(document).on('click', '.update_user', function (e) {
        e.preventDefault();

        $(this).text('Kemaskini..');
        // alert(id);

        var edit_data = {
            'user_id': $('#edit_user_id').val(),
            'name': $('#edit_name').val(),
            'email': $('#edit_email').val(),
            'role': $('#edit_role').val(),
            'status': $('#edit_status').val(),
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/pentadbir/pengguna/kemaskini",
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
                    $('.update_user').text('Kemaskini');
                } else {
                    $('#update_msgList').html("");
                    toastr.success(response.message);
                    $('#EditUserModal').find('input').val('');
                    $('.update_user').text('Kemaskini');
                    $('#EditUserModal').modal('hide');
                    fetchuser();
                }
            }
        });

    });

    $(document).on('click', '.setpassBtn', function () {
        var user_id = $(this).val();
        $('#SetPassModal').modal('show');
        $('#setpass_id').val(user_id);
    });

    $(document).on('click', '.setpassBtnSubmit', function (e) {
        e.preventDefault();

        $(this).text('Set Katalaluan...');
        var id = $('#setpass_id').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "/pentadbir/pengguna/setpass/" + id,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 404) {
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('.setpassBtnSubmit').text('Ya, Halang');
                } else {                    
                    toastr.error(response.message);
                    $('.setpassBtnSubmit').text('Ya, Halang');
                    $('#SetPassModal').modal('hide');
                    fetchuser();
                }
            }
        });
    });

});



</script>
@endsection
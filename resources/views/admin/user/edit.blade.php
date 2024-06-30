@extends('admin.layouts.app')

@section('content')
    <div class="conatiner-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="flex-wrap d-flex justify-content-between align-items-center">
                            <div>
                                <div class="header-title">
                                    <h2 class="card-title">User</h2>
                                    <p>Edit data</p>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="needs-validation" id="form-data" name="form-data" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="form-label" for="name">Level </label>
                                <select class="form-select" id="role_id" name="role_id" required >
                                    @foreach ($role as $row)
                                        <option value="{{$row['id']}}">{{$row['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">Election </label>
                                <select class="form-select" id="election_id" name="election_id" required >
                                    @foreach ($election as $row)
                                        <option value="{{$row['id']}}">{{$row['category']}} - {{$row['area']}} - {{$row['subarea']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Email </label>
                                <input class="form-control" type="text" id="email" name="email" value="" placeholder="Enter Email" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">Name </label>
                                <input class="form-control" type="text" id="name" name="name" value="" placeholder="Enter Name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">Password </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="is_password" name="is_password">
                                    <label class="form-check-label" for="is_password">
                                        Change Password
                                    </label>
                                </div>
                                <input class="form-control" type="password" id="password" name="password" value="" placeholder="Enter Password" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="picture">Picture</label>
                                <input class="form-control" type="file" id="file" name="file">
                                <input class="form-control" type="hidden" id="picture" name="picture" value="noimage.jpg" placeholder="image">
                                <br>
                                <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview" width="300px" style="border-radius: 2%;">
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <label class="form-label" for="gender">Jenis Kelamin </label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="bod">Tanggal Lahir </label>
                                <input class="form-control" type="date" id="bod" name="bod" value="" placeholder="Enter Tanggal Lahir" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="phone">Phone </label>
                                <input class="form-control" type="text" id="phone" name="phone" value="" placeholder="Enter Phone" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <label class="form-label" for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="status" name="status">
                                    <label class="form-check-label" for="status">Active Status</label>
                                </div>
                            </div>
                            <br><br>
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ URL::previous() }}" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $('#password').prop( "disabled", true);
        $('#is_password').change(function(){
            if ($('#is_password').is(":checked")) {
                $('#password').prop( "disabled", false);
            } else {
                $('#password').prop( "disabled", true);
            }

        });

        // get data
        $.ajaxSetup({
            headers:{
                'Authorization': "Bearer {{$session_token}}"
            }
        });
        $.ajax({
            url: '/api/user/{{$id}}',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['status'] == true) {
                    $("#detail-data-success").show();
                    $("#detail-data-failed").hide();

                    $('#role_id').val(result['data']['role_id']);
                    $('#election_id').val(result['data']['election_id']);
                    $('#email').val(result['data']['email']);
                    $('#name').val(result['data']['name']);
                    $("#picture").val(result['data']['picture']);
                    $("#image-preview").attr("src", "{{ url('/') }}/uploads/" + result['data']['picture']);
                    $("#gender").val(result['data']['gender']);
                    $("#bod").val(result['data']['bod']);
                    $("#phone").val(result['data']['phone']);
                    $("#address").val(result['data']['address']);
                    $('#notes').val(result['data']['notes']);
                    $('#is_active').prop("checked", result['data']['is_active']);

                } else {
                    $("#detail-data-success").hide();
                    $("#detail-data-failed").show();

                    $('#message').html(result['message']);
                }
            },
            fail: function () {
                $("#detail-data-success").hide();
                $("#detail-data-failed").show();

                $('#message').html(result['message']);
            }
        });

        // handle upload image
        $('#file').change(function(){
            // preview
            $('#image-preview').attr('display', 'block');
            var oFReader = new FileReader();
            oFReader.readAsDataURL( $("#file")[0].files[0]);
            oFReader.onload = function(oFREvent) {
                $('#image-preview').attr('src', oFREvent.target.result);
            };

            // upload
            formdata = new FormData();
            if($(this).prop('files').length > 0) {
                file =$(this).prop('files')[0];
                formdata.append("file", file);
            }
            $.ajaxSetup({
                headers:{
                    'Authorization': "Bearer {{$session_token}}"
                }
            });
            $.ajax({
                url: '/api/upload',
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (result) {
                    if(result['status'] == true) {
                        $('#picture').val(result['data']['fileName']);
                    }
                }
            });
        });

        // handle post
        $('#form-data').submit(false);
        $("#form-data").submit( function () {

            if($(this).valid()) {
                var form = $("#form-data").serializeArray();
                var formdata = {};
                $.map(form, function(n, i){
                    formdata[n['name']] = n['value'];
                });
                if ('status' in formdata) {
                    if (formdata['status'] == 'on') {
                        formdata['status'] = '1';
                    } else {
                        formdata['status'] = '0';
                    }
                } else {
                    formdata['status'] = '0';
                }

                $.ajaxSetup({
                    headers:{
                        'Authorization': "Bearer {{$session_token}}"
                    }
                });
                $.ajax({
                    url: '/api/user/{{$id}}',
                    type: "PUT",
                    data: JSON.stringify(formdata),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    processData: false,
                    success: function (result) {
                        if(result['status'] == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: result['message'],
                                confirmButtonColor: '#3A57E8',
                            }).then((result) => {
                                window.location.replace("{{ url('/admin/user') }}");
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: result['message'],
                                confirmButtonColor: '#3A57E8',
                            });
                        }
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "You must complete the entire form.",
                    confirmButtonColor: '#3A57E8',
                });
            }
            return false;
        });

    </script>
@endsection

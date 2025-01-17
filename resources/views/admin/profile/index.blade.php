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
                                    <h2 class="card-title">Profile</h2>
                                    <p>Update data</p>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <form method="POST" class="needs-validation" id="form-data" name="form-data" novalidate>
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="form-label" for="name">Level </label>
                                    <select class="form-select" id="role_id" name="role_id" required disabled >
                                        @foreach ($role as $row)
                                            <option value="{{$row['id']}}">{{$row['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="name">Election </label>
                                    <select class="form-select" id="election_id" name="election_id" required disabled >
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
                                <br><br>
                                <button type="submit" class="btn btn-success">Submit</button>
                                <a href="{{ URL::previous() }}" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>
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
            url: "/api/user/{{$session_data['user_id']}}",
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['status'] == true) {
                    $("#detail-data-success").show();
                    $("#detail-data-failed").hide();

                    $('#election_id').val(result['data']['election_id']);
                    $('#role_id').val(result['data']['role_id']);
                    $('#email').val(result['data']['email']);
                    $('#name').val(result['data']['name']);
                    $("#picture").val(result['data']['picture']);
                    $("#image-preview").attr("src", "{{ url('/') }}/uploads/" + result['data']['picture']);

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
                if ('is_active' in formdata) {
                    if (formdata['is_active'] == 'on') {
                        formdata['is_active'] = true;
                    } else {
                        formdata['is_active'] = false;
                    }
                } else {
                    formdata['is_active'] = false;
                }

                $.ajaxSetup({
                    headers:{
                        'Authorization': "Bearer {{$session_token}}"
                    }
                });
                $.ajax({
                    url: "/api/user/{{$session_data['user_id']}}",
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

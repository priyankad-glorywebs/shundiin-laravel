@extends('layouts.master')
@if (isset($data) && $data->id)
@section('title') {{ 'Edit Users' }} @endsection
@else
@section('title') {{ 'Add Users' }} @endsection
@endif
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if (isset($data) && $data->id)
                        <h1 class="m-0">Edit Users</h1>
                        @else
                        <h1 class="m-0">Add Users</h1>
                        @endif
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">User</li>
                            <li class="breadcrumb-item active">User Add</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if (isset($data) && $data->id)
                    <form id="adminUserForm" action="{{ route('user.update', $data) }}" method="POST"
                        enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                    @else
                        <form id="adminUserForm" method="post" action="{{ route('user.store') }}"
                            enctype="multipart/form-data">
                @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="id" name="id" value="{{ isset($data) ? $data->id : '' }}">

                <!-- FIRST INFORMATION  - START -->
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-parimary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    @if (isset($data) && $data->id)
                                        Edit
                                    @else
                                        Add
                                    @endif User
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>First Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                                id="first_name" placeholder="Enter First Name" name="first_name"
                                                value="{{ isset($data->first_name) ? $data->first_name : old('first_name') }}"
                                                autocomplete="off">
                                            @if ($errors->has('first_name'))
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-times-circle-o"></i> {{ $errors->first('first_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Last Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                                id="last_name" placeholder="Enter Last Name" name="last_name"
                                                value="{{ isset($data->last_name) ? $data->last_name : old('last_name') }}"
                                                autocomplete="off">
                                            @if ($errors->has('last_name'))
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-times-circle-o"></i> {{ $errors->first('last_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-6">
                                <div class="form-group">
                                   <label >Email <span class="text-danger">*</span></label>
                                   <input type="text" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" placeholder="Enter email" name="email"  value="{{isset($data->email) ? $data->email : old('email')}}" autocomplete="off">
                                   @if ($errors->has('email'))
                                   <div class="invalid-feedback">
                                      <i class="fa fa-times-circle-o"></i> {{ $errors->first('email') }}
                                   </div>
                                   @endif
                                </div>
                             </div> --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                </div>
                                                <input type="email"
                                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                    id="email" placeholder="Enter email as username" name="email"
                                                    value="{{ isset($data->email) ? $data->email : old('email') }}"
                                                    autocomplete="off">
                                                @if ($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        <i class="fa fa-times-circle-o"></i> {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Password
                                                @if (isset($data) && $data->id)
                                                @else
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <input type="password"
                                                class="form-control  {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                id="password" placeholder="Enter Password" name="password"
                                                autocomplete="off">
                                            @if ($errors->has('password'))
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-times-circle-o"></i> {{ $errors->first('password') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Confirm Password
                                                @if (isset($data) && $data->id)
                                                @else
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <input type="password"
                                                class="form-control  {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}"
                                                id="confirm_password" placeholder="Enter confirm password"
                                                name="confirm_password" autocomplete="off">
                                            @if ($errors->has('confirm_password'))
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-times-circle-o"></i>
                                                    {{ $errors->first('confirm_password') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> User Type <span class="text-danger">*</span></label>
                                            <select
                                                class="form-control {{ $errors->has('user_type') ? 'is-invalid' : '' }}"
                                                name="user_type" id="user_type">
                                                <option value="">---Select User Type---</option>
                                                @if (isset($userTypeList) && isset($userTypeList))
                                                    @foreach ($userTypeList as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ (isset($data->user_type) && $data->user_type === $key) || old('user_type') == $key ? 'selected' : '' }}>
                                                            {{ $value }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('user_type'))
                                                <div class="invalid-feedback">
                                                    <i class="fa fa-times-circle-o"></i> {{ $errors->first('user_type') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="image">Profile Picture</label>
                                            <div class="custom-file">
                                                @if (isset($data) && $data->profile_picture != '')
                                                <!-- START EDIT PAGE -->
                                                <div class="form-image text-center previewing">
                                                    @if ($data->profile_picture != null)
                                                        <a href="javascript:void(0)" class="image-clear"><i
                                                                class="fa fa-times-circle fa-2x"></i>
                                                        </a>
                                                    @endif
                            
                                                    @if ($data->profile_picture != null)
                                                        <input type="hidden" name="thumbnail" class="input-path"
                                                            value="{{ $data->profile_picture }}">
                                                    @else
                                                        <input type="hidden" name="thumbnail" class="input-path" value="">
                                                    @endif
                                                    <div class="dropify-preview image-hidden"
                                                        @if ($data->profile_picture != null) @if ($data->profile_picture) style="display: block" @endif
                                                        @endif
                                                        >
                                                        <span class="dropify-render">
                                                            @if ($data->profile_picture != null)
                                                                <img src="{{ $data->profile_picture != '' ? asset($data->profile_picture) : asset('/admin-panel/img/avatar5.png') }}" alt="profile">
                                                            @endif
                                                        </span>
                                                        <div class="dropify-infos">
                                                            <div class="dropify-infos-inner">
                                                                <p class="dropify-filename"><span class="dropify-filename-inner"></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="icon-choose"><i class="fas fa-cloud-upload-alt fa-5x"></i>
                                                        <p>Click here to select file</p>
                                                    </div>
                                                </div>
                                                <!-- END EDIT PAGE -->
                                            @else
                                                <div class="form-image text-center previewing">
                                                    <a href="javascript:void(0)" class="image-clear" style="display: none"><i
                                                            class="fa fa-times-circle fa-2x"></i>
                                                    </a>
                                                    <input type="hidden" name="thumbnail" class="input-path" value="">
                                                    <div class="dropify-preview image-hidden">
                                                        <span class="dropify-render">
                                                        </span>
                                                        <div class="dropify-infos">
                                                            <div class="dropify-infos-inner">
                                                                <p class="dropify-filename"><span class="dropify-filename-inner"></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="icon-choose"><i class="fas fa-cloud-upload-alt fa-5x"></i>
                                                        <p>Click here to select file</p>
                                                    </div>
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="company-logo">

                                            
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

                <!-- /.row -->
                <!-- FIRST INFORMATION  - END -->
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>&nbsp;
                        <a href="{{ route('user.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
                </form>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            //      /$('#menu_permission').select2({placeholder: " Select Menus"});
            $("#adminUserForm").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    password: {
                        required: isPasswordPresent,
                    },
                    user_type: {
                        required: true,
                    },
                    confirm_password: {
                        required: isPasswordPresent,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: 'Full name field is required',
                    },
                    email: {
                        required: 'Email field is required',
                    },
                    user_type: {
                        required: 'User Type field is required',
                    },
                    password: {
                        required: 'The password field is required.',
                        minlength: 'The password must be at least 5 characters.'
                    },
                    confirm_password: {
                        required: 'The confirm password field is required.',
                        minlength: 'The confirm password must be at least 5 characters.',
                        equalTo: 'Your password and confirmation password do not match.',
                    }
                },
            });
        });

        function isPasswordPresent() {
            return $('#password').val().length > 0;
        }

        function theImgDelete() {
            $('#delimg').hide();
            $('#imgdel').val('1');
        }
    </script>
    <!-- /.content-wrapper -->
@endsection
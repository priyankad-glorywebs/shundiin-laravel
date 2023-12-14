@extends('layouts.master')
@php 
$pageListing = get_pages_listing();
@endphp
@section('title') {{'Mail Setting'}} @endsection
@section('content')
<div id="admin-overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>
<style>
    #admin-overlay {
        position: fixed;
        top: 0;
        z-index: 99999;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0,0,0,.5);
    }
    #admin-overlay .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #admin-overlay .cv-spinner .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #186bc3 solid;
        border-radius: 50%;
        animation: sp-anime .8s infinite linear;
    }
    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Settings</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Mail Settings</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
    <section class="content">
        <div class="container">
            <form class="form" id="updatesave" method="post" action="#" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <div id="success-msg" class="alert alert-success" style="display:none;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
                                </div>
                                <h3 class="card-title">
                                    <i class="fas fa-edit"></i>
                                    Mail settings
                                </h3>
                                <div class="btn-group float-sm-right">
                                    <button type="submit" class="btn btn-success px-4"><i class="fa fa-edit"></i> Save Setting</button>
                                    <button type="button" class="btn btn-warning cancel-button px-3"><i class="fa fa-refresh"></i> Reset
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                {{-- <div class="row"> --}}
                                    <div class="form-group row">
                                        <label for="mail_username">Mail Username:</label>
                                        {{-- <div class="col-sm-9 col-md-9"> --}}
                                            @if(isset($data['mail_username']))
                                                <input type="text" class="form-control form-control-solid"
                                                       name="mail_username" placeholder="Enter Mail Username"
                                                       value="{{$data['mail_username']}}"/>
                                                @else
                                                <input type="text" class="form-control form-control-solid"
                                                       name="mail_username" placeholder="Enter Mail Username"
                                                       value=""/>
                                            @endif
                                            <span class="text-danger error-text mail_username_error"></span>     
                                        {{-- </div> --}}
                                    </div>
                                    <div class="form-group row">
                                        <label for="mail_password"> Mail Password:</label>
                                        {{-- <div class="col-sm-9 col-md-9"> --}}
                                            @if(isset($data['mail_password']))
                                                <input type="password" class="form-control form-control-solid"
                                                       name="mail_password" placeholder="Enter Mail Password"
                                                       value="{{$data['mail_password']}}"/>
                                                @else
                                                <input type="password" class="form-control form-control-solid"
                                                       name="mail_password" placeholder="Enter Mail Password"
                                                       value=""/>
                                            @endif
                                            <span class="text-danger error-text mail_password_error"></span>     
                                        {{-- </div> --}}
                                    </div>
                                    <div class="form-group row">
                                        <label for="from_address"> From Email Address:</label>
                                        {{-- <div class="col-sm-9 col-md-9"> --}}
                                            @if(isset($data['from_address']))
                                                <input type="text" class="form-control form-control-solid"
                                                       name="from_address" placeholder="Enter From Email"
                                                       value="{{$data['from_address']}}"/>
                                                @else
                                                <input type="text" class="form-control form-control-solid"
                                                       name="from_address" placeholder="Enter From Email"
                                                       value=""/>
                                            @endif
                                            <span class="text-danger error-text from_address_error"></span>     
                                        {{-- </div> --}}
                                    </div>
                                    <div class="form-group row">
                                        <label for="from_name"> From Name:</label>
                                        {{-- <div class="col-sm-9 col-md-9"> --}}
                                            @if(isset($data['from_name']))
                                                <input type="text" class="form-control form-control-solid"
                                                       name="from_name" placeholder="Enter From Name"
                                                       value="{{$data['from_name']}}"/>
                                                @else
                                                <input type="text" class="form-control form-control-solid"
                                                       name="from_name" placeholder="Enter From Name"
                                                       value=""/>
                                            @endif
                                            <span class="text-danger error-text from_name_error"></span>     
                                        {{-- </div> --}}
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-12">User Mail Subject:</label>
                                        <br>
                                        {{-- <div class="col-sm-9 col-md-9"> --}}
                                            @if(isset($data['umail_subject']))
                                                <input type="text" placeholder="Enter User Mail Subject" name="umail_subject" class="form-control" value="{{$data['umail_subject']}}">
                                            @else
                                            <input type="text" placeholder="Enter User Mail Subject" name="umail_subject" class="form-control">
                                            @endif
                                            <span class="text-danger error-text umail_subject_error"></span>     
                                        {{-- </div> --}}
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-12">User Mail Template:</label>
                                        <br>
                                        {{-- <div class="col-sm-9 col-md-9"> --}}
                                            @if(isset($data['umail_template']))
                                                <textarea name="umail_template" class="tinymce-editor form-control">{{$data['umail_template']}}</textarea>
                                            @else
                                                <textarea name="umail_template" class="tinymce-editor form-control"></textarea>
                                            @endif
                                            <span class="text-danger error-text umail_template_error"></span>     
                                        {{-- </div> --}}
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-12">Admin Mail Subject:</label>
                                        <br>
                                        {{-- <div class="col-sm-9 col-md-9"> --}}
                                            @if(isset($data['amail_subject']))
                                                <input type="text" placeholder="Enter Admin Mail Subject" name="amail_subject" class="form-control" value="{{$data['amail_subject']}}">
                                            @else
                                                <input type="text" placeholder="Enter Admin Mail Subject" name="amail_subject" class="form-control">
                                            @endif
                                            <span class="text-danger error-text amail_subject_error"></span>     
                                        {{-- </div> --}}
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-12">Admin Mail Template:</label>
                                        <br>
                                        {{-- <div class="col-sm-9 col-md-9"> --}}
                                            @if(isset($data['amail_template']))
                                                <textarea name="amail_template" class="tinymce-editor form-control">{{$data['amail_template']}}</textarea>
                                            @else
                                                <textarea name="amail_template" class="tinymce-editor form-control"></textarea>
                                            @endif
                                            <span class="text-danger error-text amail_template_error"></span>     
                                        {{-- </div> --}}
                                    </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <style>
        #updatesave .nav-tabs.flex-column .nav-link.active {
            background: #007bff;
            color: #fff;
            text-transform: capitalize;
        }
        #updatesave .nav-tabs.flex-column .nav-link{
            text-transform: capitalize;
        }
        .tox.tox-tinymce {
            width: 100%;
        }
    </style>
    <script src="{{ asset('plugins/tinymce/tinymce.min.js?v=v3.2.10') }}" id="core-tinymce"></script>
    <script>

        function toggle_global_loading(status, timeout = 300) {
            if (status) {
                $("#admin-overlay").fadeIn(300);
            } else {
                setTimeout(function () {
                    $("#admin-overlay").fadeOut(300);
                }, timeout);
        }
        }
        $(function () {

            function initTinyEditor() {
                tinymce.init({
                    selector: 'textarea.tinymce-editor',
                    height: 300,
                    menubar: true,
                    plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount', 'image'
                    ],
                    toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                    content_css: '//www.tiny.cloud/css/codepen.min.css'
                });
            }

            initTinyEditor();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* UPDATE ADMIN PERSONAL INFO */
            $('#updatesave').on('submit', function (e) {
                e.preventDefault();
                toggle_global_loading(true);
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('mail-settings-update')  }}",
                    // dataType: 'json',
                    data: formData
                }).done(function (data) {
                    if (data.status == 0) {
                        $.each(data.error, function (prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    }
                    if (data.status == 1) {
                        toggle_global_loading(false);
                        $("#success").show();
                        $('#success-msg').text(data.msg).show();
                        setTimeout(function () {
                            $("#success-msg").hide();
                        }, 5000);
                    }
                    return false;
                }).fail(function (data) {
                    $("#error-msg").text(data.msg).show();
                    setTimeout(function () {
                        $("#error-msg").hide();
                    }, 5000);
                    return false;
                });
            });
        });
    </script>
</div>
@endsection
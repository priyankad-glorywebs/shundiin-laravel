@extends('layouts.master')
@php 
$pageListing = get_pages_listing();
@endphp
@section('title') {{'General Setting'}} @endsection
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
                        <li class="breadcrumb-item active">General Settings</li>
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
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <div id="success-msg" class="alert alert-success" style="display:none;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
                                </div>
                                <h3 class="card-title">
                                    <i class="fas fa-edit"></i>
                                    General settings
                                </h3>
                                <div class="btn-group float-sm-right">
                                    <button type="submit" class="btn btn-success px-4"><i class="fa fa-edit"></i> Save Setting</button>
                                    <button type="button" class="btn btn-warning cancel-button px-3"><i class="fa fa-refresh"></i> Reset
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5 col-sm-3">
                                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link active" id="vert-tabs-general-tab" data-toggle="pill" href="#vert-tabs-general" role="tab" aria-controls="vert-tabs-home" aria-selected="true">General setting</a>
                                            <a class="nav-link" id="vert-tabs-social-tab" data-toggle="pill" href="#vert-tabs-social" role="tab" aria-controls="vert-tabs-social" aria-selected="false">Reading setting</a>
                                            <a class="nav-link" id="vert-tabs-admin-tab" data-toggle="pill" href="#vert-tabs-admin" role="tab" aria-controls="vert-tabs-admin" aria-selected="false">Admin setting</a>
                                        </div>
                                    </div>
                                    <div class="col-7 col-sm-9">
                                        <div class="tab-content" id="vert-tabs-tabContent">
                                            <div class="tab-pane text-left fade active show" id="vert-tabs-general" role="tabpanel" aria-labelledby="vert-tabs-general-tab">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-group row">
                                                            <div class="col-sm-6 col-md-6">
                                                                <label class="col-form-label">Favicon</label>
                                                                <div class="form-image text-center previewing">
                                                                    <a href="javascript:void(0)" class="image-clear" style="display: none"><i
                                                                            class="fa fa-times-circle fa-2x"></i>
                                                                    </a>
                                                                    @if(!empty(isset($data['gs_ficon'])))
                                                                        <a href="javascript:void(0)" class="image-clear">
                                                                            <i class="fa fa-times-circle fa-2x"></i>
                                                                        </a>
                                                                        <input type="hidden" name="gs_ficon" class="input-path" value="{{$data['gs_ficon']}}"/>      
                                                                    @else
                                                                        <input type="hidden" name="gs_ficon" class="input-path" value=""/>      
                                                                    @endif
                                                                    <div class="dropify-preview image-hidden" @if ($data) @if($data['gs_ficon']) style="display: block" @endif @endif>
                                                                        <span class="dropify-render">
                                                                            @if (isset($data['gs_ficon']))
                                                                                @if ($data['gs_ficon'])
                                                                                    <img src="{{ asset($data['gs_ficon']) }}" alt="fevicon_icon"/>
                                                                                @endif
                                                                            @endif
                                                                        </span>
                                                                        <div class="dropify-infos">
                                                                            <div class="dropify-infos-inner">
                                                                                <p class="dropify-filename"><span class="dropify-filename-inner"></span></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="icon-choose">
                                                                        <i class="fas fa-cloud-upload-alt fa-5x"></i>
                                                                        <p>Click here to select file</p>
                                                                    </div>
                                                                    <span class="text-danger error-text old_favicon_error"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <label class="col-form-label">Logo</label>
                                                                <div class="form-image text-center previewing">                                                                    
                                                                    <a href="javascript:void(0)" class="image-clear" style="display: none"><i
                                                                            class="fa fa-times-circle fa-2x"></i>
                                                                    </a>
                                                                    @if(!empty($data))
                                                                        <a href="javascript:void(0)" class="image-clear">
                                                                            <i class="fa fa-times-circle fa-2x"></i>
                                                                        </a>
                                                                        <input type="hidden" name="gs_sitelogo" class="input-path" value="{{$data['gs_sitelogo']}}"/>      
                                                                    @else
                                                                        <input type="hidden" name="gs_sitelogo" class="input-path" value=""/>      
                                                                    @endif
                                                                    <div class="dropify-preview image-hidden" @if ($data) @if($data['gs_sitelogo']) style="display: block" @endif @endif>
                                                                        <span class="dropify-render">
                                                                            @if (isset($data['gs_ficon']))
                                                                                @if ($data['gs_ficon'])
                                                                                    <img src="{{ asset($data['gs_sitelogo']) }}" alt="Site-logo"/>
                                                                                @endif
                                                                            @endif
                                                                        </span>
                                                                        <div class="dropify-infos">
                                                                            <div class="dropify-infos-inner">
                                                                                <p class="dropify-filename"><span class="dropify-filename-inner"></span></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="icon-choose">
                                                                        <i class="fas fa-cloud-upload-alt fa-5x"></i>
                                                                        <p>Click here to select file</p>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger error-text old_logo_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-md-3">Phone Number:</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                @if(isset($data['gs_phone']))
                                                                    <input type="phone" class="form-control form-control-solid"
                                                                           name="gs_phone" placeholder="Enter Phone Number"
                                                                           value="{{$data['gs_phone']}}"/>
                                                                    @else
                                                                    <input type="phone" class="form-control form-control-solid"
                                                                           name="gs_phone" placeholder="Enter Phone Number"
                                                                           value=""/>
                                                                @endif
                                                                <span class="text-danger error-text phone_number_error"></span>     
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-md-3">Email:</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                 @if(isset($data['gs_email']))
                                                                <input type="email" class="form-control form-control-solid"
                                                                       name="gs_email" placeholder="Enter Email Id"
                                                                       value="{{$data['gs_email']}}"/>
                                                                @else
                                                                <input type="email" class="form-control form-control-solid"
                                                                       name="gs_email" placeholder="Enter Email Id"
                                                                       value=""/>
                                                                 @endif
                                                                <span class="text-danger error-text email_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-md-3">Iframe Booking Link:</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                @if(isset($data['gs_ifbklink']))
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_ifbklink" placeholder="Enter Iframe Link"
                                                                       value="{{$data['gs_ifbklink']}}"/>
                                                                 @else
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_ifbklink" placeholder="Enter Iframe Link"
                                                                       value=""/>
                                                                @endif
                                                                <span class="text-danger error-text iframe_link_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-md-3">Facebook Link:</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                @if(isset($data['gs_fblink']))
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_fblink" placeholder="Enter Facebook Link"
                                                                       value="{{$data['gs_fblink']}}"/>
                                                                 @else
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_fblink" placeholder="Enter Facebook Link"
                                                                       value=""/>
                                                                @endif
                                                                <span class="text-danger error-text facebook_link_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-md-3">Instagram Link:</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                 @if(isset($data['gs_instalink']))
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_instalink" placeholder="Enter Pinterest Link"
                                                                       value="{{$data['gs_instalink']}}"/>
                                                                 @else
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_instalink" placeholder="Enter Pinterest Link"
                                                                       value=""/>
                                                                @endif
                                                                <span class="text-danger error-text instagram_link_error"></span>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="form-group row">
                                                            <label class="col-sm-3 col-md-3">Twitter Link:</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                @if(isset($data['gs_tlink']))
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_tlink" placeholder="Enter Twitter Link"
                                                                       value="{{$data['gs_tlink']}}"/>
                                                                @else
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_tlink" placeholder="Enter Twitter Link"
                                                                       value=""/>
                                                                @endif
                                                                <span class="text-danger error-text twitter_link_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-md-3">Youtube Link:</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                @if(isset($data['gs_ylink']))
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_ylink" placeholder="Enter Youtube Link"
                                                                       value="{{$data['gs_ylink']}}"/>
                                                                @else
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_ylink" placeholder="Enter Youtube Link"
                                                                       value=""/>
                                                                @endif
                                                                <span class="text-danger error-text youtube_link_error"></span>
                                                            </div>
                                                        </div> --}}
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-md-3">Address Text:</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                @if(isset($data['gs_addressinfo']))
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_addressinfo" placeholder="Enter Address Text"
                                                                       value="{{$data['gs_addressinfo']}}"/>
                                                                @else
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_addressinfo" placeholder="Enter Address Text"
                                                                       value=""/>
                                                                @endif
                                                                <span class="text-danger error-text address_text_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-md-3">Google Map Link:</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                @if(isset($data['gs_gmaplink']))
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_gmaplink" placeholder="Enter Google Map Link"
                                                                       value="{{$data['gs_gmaplink']}}"/>
                                                                @else
                                                                <input type="text" class="form-control form-control-solid"
                                                                       name="gs_gmaplink" placeholder="Enter Google Map Link"
                                                                       value=""/>
                                                                @endif
                                                                <span class="text-danger error-text google_map_link_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-md-3">Footer Copyright Text:</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                @if(isset($data['gs_copyinfo']))
                                                                <textarea name="gs_copyinfo" class="form-control form-control-solid" placeholder="Enter Footer Copyright Text">{{$data['gs_copyinfo']}}</textarea>
                                                                @else
                                                                <textarea name="gs_copyinfo" class="form-control form-control-solid" placeholder="Enter Footer Copyright Text"></textarea>
                                                                 @endif
                                                                <span class="text-danger error-text footer_copyright_text_error"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-social" role="tabpanel" aria-labelledby="vert-tabs-social-tab">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label">Select Your Homepage</label>
                                                            <div class="col-md-6">
                                                                <div class="mb-2">
                                                                    <select name="gs_site_url" class="form-control select-show_on_front load-pages" data-placeholder="" >
                                                                        <option value=""> --- Select Page ---</option>
                                                                        @if(!empty($pageListing))
                                                                            @foreach($pageListing as $pageListingVal)
                                                                                <option value="{{$pageListingVal['slug']}}"
                                                                                         @if(isset($data['gs_site_url']))
                                                                                            @if($data['gs_site_url'] == $pageListingVal['slug'])
                                                                                            {{'selected'}}
                                                                                            @endif
                                                                                         @endif
                                                                                        >
                                                                                    {{$pageListingVal['title']}}
                                                                                </option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane text-left fade" id="vert-tabs-admin" role="tabpanel" aria-labelledby="vert-tabs-general-tab">
                                                <div class="form-group row">    
                                                    <div class="col-sm-6 col-md-6">
                                                        <label class="col-form-label">Sidebar Icon</label>
                                                        <div class="form-image text-center previewing">
                                                            <a href="javascript:void(0)" class="image-clear" style="display: none"><i
                                                                    class="fa fa-times-circle fa-2x"></i>
                                                            </a>
                                                            @if(!empty($data) && isset($data['gs_sidebaricon']))
                                                                <a href="javascript:void(0)" class="image-clear">
                                                                    <i class="fa fa-times-circle fa-2x"></i>
                                                                </a>
                                                                <input type="hidden" name="gs_sidebaricon" class="input-path" value="{{$data['gs_sidebaricon']}}"/>      
                                                            @else
                                                                <input type="hidden" name="gs_sidebaricon" class="input-path" value=""/>      
                                                            @endif
                                                            <div class="dropify-preview image-hidden" @if ($data) @if(isset($data['gs_sidebaricon'])) style="display: block" @endif @endif>
                                                                <span class="dropify-render">
                                                                    @if (isset($data['gs_sidebaricon']))
                                                                        @if ($data['gs_sidebaricon'])
                                                                            <img src="{{ asset($data['gs_sidebaricon']) }}" alt="sidebar-icon"/>
                                                                        @endif
                                                                    @endif
                                                                </span>
                                                                <div class="dropify-infos">
                                                                    <div class="dropify-infos-inner">
                                                                        <p class="dropify-filename"><span class="dropify-filename-inner"></span></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="icon-choose">
                                                                <i class="fas fa-cloud-upload-alt fa-5x"></i>
                                                                <p>Click here to select file</p>
                                                            </div>
                                                            <span class="text-danger error-text old_favicon_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <label class="col-form-label">Admin Logo</label>
                                                        <div class="form-image text-center previewing">
                                                            <a href="javascript:void(0)" class="image-clear" style="display: none"><i
                                                                    class="fa fa-times-circle fa-2x"></i>
                                                            </a>
                                                            @if(!empty($data) && isset($data['gs_adminlogo']))
                                                                <a href="javascript:void(0)" class="image-clear">
                                                                    <i class="fa fa-times-circle fa-2x"></i>
                                                                </a>
                                                                <input type="hidden" name="gs_adminlogo" class="input-path" value="{{$data['gs_adminlogo']}}"/>      
                                                            @else
                                                                <input type="hidden" name="gs_adminlogo" class="input-path" value=""/>      
                                                            @endif
                                                            <div class="dropify-preview image-hidden" @if ($data) @if(isset($data['gs_adminlogo'])) style="display: block" @endif @endif>
                                                                <span class="dropify-render">
                                                                    @if (isset($data['gs_adminlogo']))
                                                                        @if ($data['gs_adminlogo'])
                                                                            <img src="{{ asset($data['gs_adminlogo']) }}" alt="admin-logo"/>
                                                                        @endif
                                                                    @endif
                                                                </span>
                                                                <div class="dropify-infos">
                                                                    <div class="dropify-infos-inner">
                                                                        <p class="dropify-filename"><span class="dropify-filename-inner"></span></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="icon-choose">
                                                                <i class="fas fa-cloud-upload-alt fa-5x"></i>
                                                                <p>Click here to select file</p>
                                                            </div>
                                                            <span class="text-danger error-text old_favicon_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="col-form-label">Site SEO prifix name</label>
                                                        @if(isset($data['gs_sitetitle']))
                                                            <input class="form-control form-control-solid" value="{{$data['gs_sitetitle']}}" type="text" name="gs_sitetitle" placeholder="Enter Admin Side Title" />
                                                        @else
                                                            <input class="form-control form-control-solid" type="text" name="gs_sitetitle" placeholder="Enter Admin Side Title" />
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    </style>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {
            /* UPDATE ADMIN PERSONAL INFO */
            $('#updatesave').on('submit', function (e) {
                e.preventDefault();
                toggle_global_loading(true);
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('settings-update')  }}",
                    dataType: 'json',
                    data: {
                        'formData': formData,
                        "_token": "{{ csrf_token() }}",
                    }
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
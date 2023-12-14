@extends('layouts.master')
@section('title') {{$pageDetails['title']}} @endsection
@section('content')
    @include('layouts.admin.functions')
    @include('layouts.admin.flash-message')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $pageDetails['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                            <li class="breadcrumb-item active">{{ $pageDetails['main_title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <!-- START EDITOR -->
                    @component('components.edit-taxonomy', ['entities' => $pageDetails])
                    @endcomponent
                    <!-- END EDITOR -->
                </div>
                <!-- /.card-body -->
            </div>
    </div>
@endsection

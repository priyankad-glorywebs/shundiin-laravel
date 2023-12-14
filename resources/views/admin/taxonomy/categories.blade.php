@extends('layouts.master')
@section('title') {{$postList['title']}} @endsection
@section('content')
    @include('layouts.admin.functions')
    @include('layouts.admin.flash-message')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{$postList['title']}}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{$postList['title']}}</li>
                            <li class="breadcrumb-item active">{{$postList['name']}} list</li>
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
                     @component('components.taxolist', ['entities' => $postList])
                     @endcomponent
                     <!-- END EDITOR -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection

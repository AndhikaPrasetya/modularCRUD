@extends('layouts.layout')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$title}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                    <li class="breadcrumb-item">{{$breadcrumb}}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
  </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="d-flex justify-content-between align-items-center px-3 mt-4">

                            <div>
                                <h3 class="card-title align-items-center">Data Permission</h3>
                            </div>
                            <div>
                                <a href="{{ route('permission.create') }}" class="btn btn-primary">Create</a>

                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="table_permission">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Guard Name</th>
                                        <th class="w-25 text-center">Action</th>
                                    </tr>
                                </thead>
                              
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection


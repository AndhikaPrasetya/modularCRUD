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
                        @can('create-sewaMenyewa')
                        <div class="p-3">
                            <a href="{{ route('sewaMenyewa.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create Dokumen</a>
                        </div>
                        @endcan
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="table_sewaMenyewa">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Dokumen</th>
                                        <th>Lokasi</th>
                                        <th>Jenis Dokumen</th>
                                        <th>Tanggal Dokumen</th>
                                        <th>Sign By</th>
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


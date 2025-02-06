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
                            <div class="p-3">
                                <a href="{{ route('aktaPerusahaan.create') }}" class="btn btn-primary">Create</a>

                            </div>
                        
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="table_aktaPerusahaan">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Akta</th>
                                        <th>Nama Akta</th>
                                        <th>Perusahaan</th>
                                        <th>Tgl Terbit</th>
                                        <th>Status</th>
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


@extends('layouts.layout')
@section('content')

@include('layouts.breadcrumb')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- @can('create document') --}}
                        <div class="p-3">
                            <a href="{{ route('document.create') }}" class="btn btn-primary">Create</a>
                        </div>
                        {{-- @endcan --}}
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="table_document">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>File Name</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th style="max-width: 15%;">Uploaded By</th>
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


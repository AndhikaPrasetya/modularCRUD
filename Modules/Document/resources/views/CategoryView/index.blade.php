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
                            <a href="{{ route('category.create') }}" class="btn btn-primary">Create</a>
                        </div>
                        {{-- @endcan --}}
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="table_category">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name Category</th>
                                        <th>Deskripsi</th>
                                      
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


@extends('layouts.layout')
@section('content')

@include('layouts.breadcrumb')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('create-role')
                        <div class="p-3">
                            <a href="{{ route('jenisDokumen.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create Jenis Dokumen</a>
                        </div>
                        @endcan
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="table_jenisDokumen">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Dokumen</th>
                                        <th class="w-25 text-center">Action</th>
                                    </tr>
                                </thead>
                              
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


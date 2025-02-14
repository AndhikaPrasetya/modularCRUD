@extends('layouts.layout')
@section('content')

@include('layouts.breadcrumb')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="table_log">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Log Name</th>
                                        <th>Description</th>
                                        <th>Created At</th>
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


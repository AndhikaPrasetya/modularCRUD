@extends('layouts.layout')
@section('content')
    <div class="p-3">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Roles</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

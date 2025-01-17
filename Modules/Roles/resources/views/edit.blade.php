@extends('layouts.layout')
@section('content')
<div class="p-3">

    <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Edit Data</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{route('roles.update', $data->id)}}" method="POST">
            @csrf
            @method('PUT')
          <div class="card-body">
            <div class="form-group">
              <label for="name">name</label>
              <input type="text" class="form-control" name="name" id="name" value="{{$data->name}}">
            </div>
          </div>
          <!-- /.card-body -->
    
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button
            type="button"onclick="window.location.href='{{ route('roles.index') }}'"
            class="btn btn-warning"><span>Back</span></button>
          </div>
        </form>
    </div>
</div>
    
@endsection
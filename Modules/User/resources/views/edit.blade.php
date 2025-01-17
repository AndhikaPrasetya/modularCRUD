@extends('layouts.layout')
@section('content')
<div class="p-3">

    <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Edit Data</h3>
        </div>
        <form action="{{route('users.update', $data->id)}}" method="POST">
            @csrf
            @method('PUT')
          <div class="card-body">
            <div class="form-group">
              <label for="name">name</label>
              <input type="text" class="form-control" name="name" id="name" value="{{$data->name}}">
              @if ($errors->has('name'))
              <span class="text-danger">{{ $errors->first('name') }}</span>
          @endif
            </div>
            <div class="form-group">
              <label for="email">email</label>
              <input type="text" class="form-control" name="email" id="email" value="{{$data->email}}">
              @if ($errors->has('email'))
              <span class="text-danger">{{ $errors->first('email') }}</span>
          @endif
            </div>
            <div class="form-group">
              <label for="password">new password</label>
              <input type="text" class="form-control" name="password" id="password">
              @if ($errors->has('password'))
              <span class="text-danger">{{ $errors->first('password') }}</span>
          @endif
            </div>
          </div>

    
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
    </div>
</div>
    
@endsection
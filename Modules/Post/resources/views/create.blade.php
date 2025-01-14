@extends('layouts.layout')
@section('content')
<div class="p-3">

    <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Quick Example</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{route('post.store')}}" method="POST">
            @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" name="title" id="title">
            </div>
            <div class="form-group">
              <label for="content">Content</label>
              <input type="text" class="form-control" name="content" id="content">
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
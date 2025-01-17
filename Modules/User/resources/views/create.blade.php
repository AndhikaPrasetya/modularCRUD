@extends('layouts.layout')
@section('content')
<div class="p-3">

    <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Quick Example</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="createFormUser">
            @csrf
          <div class="card-body">
            <input type="hidden">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
              <label for="email">email</label>
              <input type="text" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
              <label for="password">password</label>
              <input type="text" class="form-control" name="password" id="password" required>
            </div>
          </div>
          <!-- /.card-body -->
    
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button
            type="button"onclick="window.location.href='{{ route('users.index') }}'"
            class="btn btn-warning"><span>Back</span></button>
          </div>
        </form>
    </div>
</div>
    
@endsection
@section('script')
    <script>
      $('#createFormUser').on('submit', function(e){
        e.preventDefault();
        $.ajax({
          url:'/users/store',
          type:'POST',
          data:$(this).serialize(),
          success:function(data){
            console.log(data);
            window.location.href = '/users/edit/'+data.data; 
          },
          error:function(err){
            console.log(err);
          }
        });
      });
    </script>
@endsection
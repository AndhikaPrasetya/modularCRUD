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
                  <li class="breadcrumb-item"><a href="#">{{$breadcrumb}}</a></li>

              </ol>
          </div>
      </div>
  </div><!-- /.container-fluid -->
</section>
<section class="content">

  <div class="card card-primary">
      <!-- /.card-header -->
      <!-- form start -->
      <form id="createFormRole">
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
              <button
              type="button"onclick="window.location.href='{{ route('roles.index') }}'"
              class="btn btn-warning"><span>Back</span></button>
          </div>
      </form>
  </div>
</section>

    </div>
@endsection
@section('script')
    <script>
       $(document).ready(() => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true 
        });

        const showToast = (icon, message) => {
            Toast.fire({
                icon: icon,
                title: message
            });
        };

        const handleCreateForm = (formId) =>{
          const form = $(`#${formId}`);
          $.ajax({
            url:'/roles/store',
            type:'POST',
            data:form.serialize(),
            success:function(response){
              if (response.success) {
                  showToast('success',response.message)
                //move page after 3000
                 setTimeout(() => {
                       window.location.href = '/roles/edit/' + response.role_id;
                 }, 3000);
              } else {
                  showToast('error',response.message)
              }
            },
            error:function(xhr){
                // console.log(xhr.responseJSON.error);
                if (xhr.status === 422) {
                showToast('error', xhr.responseJSON.name);
            } else {
                showToast('error', xhr.responseJSON.message);
            }
            }
          });
        }
        $('#createFormRole').on('submit', function(e){
          e.preventDefault();
          handleCreateForm('createFormRole');
        });


       })

     
    </script>
@endsection


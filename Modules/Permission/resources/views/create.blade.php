@extends('layouts.layout')
@section('content')
@include('layouts.breadcrumb')
<section class="content">

  <div class="card card-primary">
      <form id="createFormPermission">
          @csrf
          
          <div class="card-body">
              <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name">
                  <span class="text-danger" id="name-error"></span>
              </div>
          </div>
          <!-- /.card-body -->
  
          <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button
              type="button"onclick="window.location.href='{{ route('permission.index') }}'"
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
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "1000",
          
        };

        const showToast = (icon, message) => {
            if (icon === 'error') {
                toastr.error(message);
            } else if (icon === 'success') {
                toastr.success(message); 
            } else if (icon === 'info') {
                toastr.info(message); 
            } else {
                toastr.warning(message); 
            }
        };
        const handleCreateForm = (formId) =>{
          const form = $(`#${formId}`);
          $.ajax({
            url:'/permission/store',
            type:'POST',
            data:form.serialize(),
            success:function(response){
              if (response.success) {
                  showToast('success',response.message)
                 setTimeout(() => {
                       window.location.href = '/permission/edit/' + response.permission_id;
                 }, 1000);
              } else {
                  showToast('error',response.message)
              }
            },
            error:function(xhr){
                console.log(xhr.responseJSON.error);
                if (xhr.status === 422) {
                showToast('error', xhr.responseJSON.name);
            } else {
                showToast('error', xhr.responseJSON.message);
                console.log(xhr.responseJSON.message)
            }
            }
          });
        }
        $('#createFormPermission').on('submit', function(e){
          e.preventDefault();
          handleCreateForm('createFormPermission');
        });


       })

     
    </script>
@endsection


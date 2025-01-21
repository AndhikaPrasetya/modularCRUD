@extends('layouts.layout')
@section('content')
@include('layouts.breadcrumb')
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
              </div>
              <div class="permission-section">
                <label>Permission</label>
                  <div class="d-flex">
                      @foreach ($permissions as $key => $permission)
                          <div class="form-group">
                              <div class="form-check">
                                  <div class="custom-control custom-checkbox">
                                      <input class="custom-control-input" type="checkbox"
                                          id="customCheckbox{{ $key }}" name="permission[]"
                                          value="{{ $permission->name }}">
                                      <label for="customCheckbox{{ $key }}"
                                          class="custom-control-label">{{ $permission->name }}</label>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                  </div>
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
        toastr.options = {
            "positionClass": "toast-top-right", // Posisi toast
            "timeOut": "1000",
          
        };

        const showToast = (icon, message) => {
            if (icon === 'error') {
                toastr.error(message); // Toast untuk error
            } else if (icon === 'success') {
                toastr.success(message); // Toast untuk sukses
            } else if (icon === 'info') {
                toastr.info(message); // Toast untuk info
            } else {
                toastr.warning(message); // Toast untuk warning
            }
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
                //move page after 1000
                 setTimeout(() => {
                       window.location.href = '/roles/edit/' + response.role_id;
                 }, 1000);
              } else {
                  showToast('error',response.message)
              }
            },
            error:function(xhr){
                // console.log(xhr.responseJSON.error);
                if (xhr.status === 422) {
                showToast('error', xhr.responseJSON.errors);
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


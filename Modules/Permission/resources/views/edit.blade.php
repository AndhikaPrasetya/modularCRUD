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
          <!-- Form Start -->
          <form id="updateFormPermission" data-id="{{ $data->id }}">
              @csrf
              @method('PUT')
              <div class="card-body">
                  <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" name="name" id="name" value="{{ $data->name }}" required>
                  </div>
              </div>
  
              <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="button" onclick="window.location.href='{{ route('permission.index') }}'" class="btn btn-warning">
                      <span>Back</span>
                  </button>
              </div>
          </form>
      </div>
  </section>
@endsection

@section('script')
<script>
    $(document).ready(() => {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right", // Posisi toast
            "timeOut": "2000",
          
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

        const handleFormSubmit = (formId) => {
          //get id form
            const form = $(`#${formId}`);
          //get id user
            const id = form.data('id');

            $.ajax({
                url: `/permission/update/${id}`,
                type: 'PUT',
                data: form.serialize(),
                success: (response) => {
                    if (response.success) {
                      showToast('success', response.message);
                    } else {
                        showToast('error', response.message);
                    }
                },
                error:function(xhr){
                // console.log(xhr.responseJSON.error);
                if (xhr.status === 422) {
                showToast('error', xhr.responseJSON.error);
            } else {
                showToast('error', 'Permission Already Exist');
            }
            }
            });
        };

        $('#updateFormPermission').on('submit', function (e) {
            e.preventDefault();
            handleFormSubmit('updateFormPermission');
        });
    });
</script>
@endsection

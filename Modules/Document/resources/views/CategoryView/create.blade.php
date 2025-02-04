@extends('layouts.layout')
@section('content')
@include('layouts.breadcrumb')
<section class="content">

  <div class="card card-primary">
      <form id="createCategory">
          @csrf
          <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="name">Category Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" required></textarea>
                    </div>
                </div>
            </div>
            
          </div>
          <div class="card-footer">
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button
                type="button"onclick="window.location.href='{{ route('category.index') }}'"
                class="btn btn-warning"><span>Back</span></button>
            </div>
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

        const handleCreateCategory = (formId) =>{
          const form = $(`#${formId}`);
          $.ajax({
            url:'/category/store',
            type:'POST',
            data:form.serialize(),
            success:function(response){
              if (response.success) {
                  showToast('success',response.message)
                 setTimeout(() => {
                       window.location.href = '/category/edit/' + response.category_id;
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
        $('#createCategory').on('submit', function(e){
          e.preventDefault();
          handleCreateCategory('createCategory');
        });


       })

     
    </script>
@endsection


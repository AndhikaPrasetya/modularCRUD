@extends('layouts.layout')
@section('content')
{{-- @include('layouts.breadcrumb') --}}
<section class="content">

  <div class="card card-primary">
      <form id="updateFormDoc">
          @csrf
          <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="form-group">
                            <label for="file_name">File name</label>
                            <input type="text" class="form-control" name="file_name" id="file_name" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control">
                              <option>option 1</option>
                              <option>option 2</option>
                              <option>option 3</option>
                              <option>option 4</option>
                              <option>option 5</option>
                            </select>
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Valid date</label>
                            <input type="date" name="valid_from" class="form-control" id="valid_from">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Expire date</label>
                            <input type="date" name="valid_until" class="form-control" id="valid_until">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <!-- select -->
                        <div class="form-group">
                          <label>Category</label>
                          <select class="form-control">
                            <option>option 1</option>
                            <option>option 2</option>
                            <option>option 3</option>
                            <option>option 4</option>
                            <option>option 5</option>
                          </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <label for="">Upload Document</label>
                        <input type="file" name="file_path" class="filePond" multiple/>
                    </div>
                    <div class="col-12">
                        <label for="">Notes</label>
                        <textarea name="notes" class="form-control" id="notes" rows="3"></textarea>
                    </div>
                </div>
            </div>
            
          </div>
          <div class="card-footer">
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button
                type="button"onclick="window.location.href='{{ route('document.index') }}'"
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
           $('.filePond').filepond();
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

        const handleFormSubmit = (formId) =>{
          const form = $(`#${formId}`);
          $.ajax({
            url:'/document/store',
            type:'POST',
            data:form.serialize(),
            success:function(response){
              if (response.success) {
                  showToast('success',response.message)
                //move page after 1000
                 setTimeout(() => {
                       window.location.href = '/document/edit/' + response.role_id;
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
        $('#updateFormDoc').on('submit', function(e){
          e.preventDefault();
          handleFormSubmit('updateFormDoc');
        });


       })

     
    </script>
@endsection


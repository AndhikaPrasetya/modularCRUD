@extends('layouts.layout')
@section('content')
@include('layouts.breadcrumb')
<section class="content">

  <div class="card card-primary">
      <form id="createFormDoc" enctype="multipart/form-data">
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
                            <select class="form-control" name="status">
                                <option value="" disabled selected>Pilih Status</option>
                               @foreach ($documentStatus as $item)
                               <option value="{{$item}}">{{$item}}</option>
                               @endforeach
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
                          @if ($category->isNotEmpty())
                          <select class="form-control" name="category_id">
                            <option value="" disabled selected>Pilih Kategori</option>
                          @foreach ($category as $item)
                              <option value="{{$item->id}}">{{$item->name}}</option>
                          @endforeach
                          </select>
                          @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <label for="file_path">Attachment</label>
                        <div class="file-loading">
                            <input type="file" id="input-document" name="file_path[]" multiple>
                        </div>

                    </div>
                    <div class="col-12">
                        <label for="description">Notes</label>
                        <textarea name="description" class="form-control" id="notes" rows="3"></textarea>
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
    // Konfigurasi Toast
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "2000",
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

    // File upload initialization
    $("#input-document").fileinput({
            uploadUrl: "{{ route('document.store') }}",
            showUpload: false,
            showRemove: true,
            uploadAsync: false, // Disable async upload to use form 
            showUploadedThumbs: false,
            validateInitialCount: true,
            maxFileCount: 5,
            overwriteInitial: false,
            showZoom: false,
            allowedFileExtensions: ["jpg", "jpeg", "png", "svg", "pdf", "doc", "docx", "txt", "rtf", "xls", "xlsx",
                "csv", "ppt", "pptx"
            ],
            fileActionSettings: {
                showRotate: false,
                showDrag: false,
                showZoom: true,
                showUpload: false,
                showRemove: true,
            }
        });

    // Form submission
    $('#createFormDoc').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
       
        const fileInput = $('#input-document')[0];
        const files = fileInput.files;
        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
            formData.append(`file_path[${i}]`, files[i]);
        }
        
        console.log([...formData.entries()]);
        
        }
        $.ajax({
            url:'/document/store',
            type:'POST',
            data:formData,
            processData: false,
            contentType: false,
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                console.log(response);
              if (response.success) {
                  showToast('success',response.message)
                //move page after 1000
                 setTimeout(() => {
                       window.location.href = '/document/edit/' + response.document_id;
                 }, 1000);
              } else {
                  showToast('error', response.error)
              }
            },
            error: (xhr) => {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    for (const [field, messages] of Object.entries(errors)) {
                        messages.forEach(message => {
                            showToast('error', message);
                        });
                    }
                } else {
                    showToast('error', xhr.responseJSON);
                }
            }
        });
    });
});    </script>
@endsection

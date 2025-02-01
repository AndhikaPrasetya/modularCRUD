@extends('layouts.layout')
@section('content')
@include('layouts.breadcrumb')
<section class="content">
    <div class="card card-primary">
        <form id="createFormDoc" class="dropzone" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="file_name">File Name</label>
                                <input type="text" class="form-control" name="file_name" id="file_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="" disabled selected>Pilih Status</option>
                                    @foreach ($documentStatus as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Valid From</label>
                                <input type="date" name="valid_from" class="form-control" id="valid_from">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Valid Until</label>
                                <input type="date" name="valid_until" class="form-control" id="valid_until">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category_id">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Dropzone File Upload -->
                    <div class="form-group">
                        <label>Upload Files</label>
                        <div id="dropzoneArea" class="dropzone"></div>
                    </div>

                    <div class="form-group">
                        <label for="description">Notes</label>
                        <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="button" onclick="window.location.href='{{ route('document.index') }}'"
                        class="btn btn-warning">Back</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('script')
<script>
Dropzone.autoDiscover = false;

let fileList = [];

let myDropzone = new Dropzone("#dropzoneArea", {
    url: "{{ route('document.store') }}",
    paramName: "file_path",
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 10,
    maxFiles: 10,
    maxFilesize: 2, // 2MB
    acceptedFiles: ".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.csv,.ppt,.pptx",
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    init: function() {
        let myDropzone = this;

        $('#createFormDoc').on('submit', function(e) {
            e.preventDefault();
            
            if (myDropzone.getQueuedFiles().length > 0) {
                myDropzone.processQueue();
            } else {
                submitForm();
            }
        });

        this.on("sendingmultiple", function(data, xhr, formData) {
            let formValues = $('#createFormDoc').serializeArray();
            $.each(formValues, function(index, field) {
                formData.append(field.name, field.value);
            });
        });

        this.on("successmultiple", function(files, response) {
            showToast('success', 'Files uploaded successfully!');
            setTimeout(() => {
                       window.location.href = '/document/edit/' + response.document_id;
                 }, 1000);
        });

        this.on("error", function(file, message) {
            showToast('error', message);
        });
    }
});

function submitForm() {
    let formData = new FormData($('#createFormDoc')[0]);
    $.ajax({
        url: "{{ route('document.store') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            showToast('success', 'Document uploaded successfully!');
            setTimeout(() => {
                       window.location.href = '/document/edit/' + response.document_id;
                 }, 1000);
        },
        error: function(xhr) {
            showToast('error', 'Something went wrong.');
        }
    });
}

// Toast Notification
function showToast(type, message) {
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "2000",
    };

    if (type === 'error') {
        toastr.error(message);
    } else if (type === 'success') {
        toastr.success(message);
    } else {
        toastr.info(message);
    }
}
</script>
@endsection

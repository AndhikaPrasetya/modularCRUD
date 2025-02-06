@extends('layouts.layout')
@section('content')
@include('layouts.breadcrumb')
<section class="content">
    <div class="card card-primary">
        <form id="editFormDoc" class="dropzone" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="documentId" value="{{ $document->id }}">
    <input type="hidden" id="existingAttachment" value='@json($existingAttachment)'>
    <input type="hidden" name="deleted_files" id="deleted_files">
    
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="file_name">File Name</label>
                        <input type="text" class="form-control" name="file_name" id="file_name" value="{{ old('file_name', $document->file_name) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="" disabled>Pilih Status</option>
                           <option value="active" {{ old('status', $document->status) == 'active' ? 'selected' : '' }}>Active</option>
                        
                           <option value="expired" {{ old('status', $document->status) == 'expired' ? 'selected' : '' }}>expired</option>
                        
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="valid_from">Valid From</label>
                        <input type="date" name="valid_from" class="form-control" id="valid_from" value="{{ \Carbon\Carbon::parse($document->valid_from)->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="valid_until">Valid Until</label>
                        <input type="date" name="valid_until" class="form-control" id="valid_until" value="{{ \Carbon\Carbon::parse($document->valid_until)->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category_id">
                            <option value="" disabled>Pilih Kategori</option>
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}" {{ old('category_id', $document->category_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="form-group">
                <label>Upload Files</label>
                <div id="dropzone" class="dropzone">
                    <div class="dz-message" data-dz-message>
                        <span>Drop files here or click to upload</span>
                    </div>
                </div>
            </div>
            
            
    
            <div class="form-group">
                <label for="description">Notes</label>
                <textarea name="description" class="form-control" id="description" rows="3">{{ old('description', $document->description) }}</textarea>
            </div>
        </div>
    </div>
    

            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mr-2">Save Changes</button>
                    <button type="button" onclick="window.location.href='{{ route('document.index') }}'" class="btn btn-warning">Back</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('script')
<script>
$(document).ready(function() {
    // Configure toastr
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

    // Initialize Dropzone
    Dropzone.autoDiscover = false;
    let deletedFiles = [];
    let myDropzone = new Dropzone("#dropzone", {
        
        url: "/document/update/" + $('#documentId').val(),
        method: "POST",
        paramName: "file_path",
        maxFilesize: 2,
        maxFiles: 10,
        acceptedFiles: ".pdf,.csv,.xls,.xlsx",
        addRemoveLinks: true,
        dictRemoveFile: "Remove",
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 10,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: function() {
            let dz = this;
            // Load existing files
            let existingAttachment = JSON.parse($('#existingAttachment').val());
            existingAttachment.forEach(function(attachment) {
                let mockFile = { 
                    name: attachment.file_path.split('/').pop(), 
                    size: 12345, 
                    id: attachment.id, 
                    existingFile: true 
                };
                dz.emit("addedfile", mockFile);
                dz.emit("complete", mockFile);
            });

            // Handle form submission
            $('#editFormDoc').submit(function(e) {
                e.preventDefault();
                
                // If there are files in the queue, process them first
                if (dz.getQueuedFiles().length > 0) {
                    dz.processQueue();
                } else {
                    // If no files, just submit form data
                    submitFormData();
                }
            });

            // Menambahkan _method PUT ke FormData
        dz.on("sending", function(file, xhr, formData) {
            formData.append("_method", "PUT");
        });
        
            // After files are processed
        dz.on("successmultiple", function(files, response) {
                submitFormData();
        });
          // Event untuk menangani penghapusan file
          dz.on("removedfile", function(file) {
                if (file.existingFile) {
                    deletedFiles.push(file.id);
                    $("#deleted_files").val(JSON.stringify(deletedFiles));

                    // Kirim AJAX request untuk menghapus file dari server
                    $.ajax({
                        url: "/document/delete-file/" + file.id,  
                        type: "DELETE",
                        data: { _token: $('meta[name="csrf-token"]').attr('content') },
                        success: function(response) {
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            toastr.error('Gagal menghapus file.');
                        }
                    });
                }
            });
        }
    });

    function submitFormData() {
        let formData = new FormData($('#editFormDoc')[0]);
        formData.append('_method', 'PUT');

        $.ajax({
            url: "/document/update/" + $('#documentId').val(),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#submitBtn').prop('disabled', true);
            },
            success: function(response) {
                if (response.status) {
                    showToast('success', response.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showToast('error', response.message);
                }
            },
            error: function(xhr) {
                let message = 'An error occurred while updating the document.';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showToast('error', message);
            },
            complete: function() {
                $('#submitBtn').prop('disabled', false);
            }
        });
    }
});
</script>
@endsection
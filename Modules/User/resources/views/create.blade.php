@extends('layouts.layout')
@section('content')
    @include('layouts.breadcrumb')
    <section class="content">
        <div class="card card-primary">
            <form id="createFormUser" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Roles</label>
                                <select class="allRole" name="roles[]" multiple="multiple" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" name="password" id="password" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="image">Upload Photo</label>
                            <input type="file" class="dropify" name="image" id="image">
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-end">

                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button type="button"onclick="window.location.href='{{ route('users.index') }}'"
                            class="btn btn-warning"><span>Back</span></button>
                    </div>
                </div>
            </form>
        </div>

    </section>
@endsection
@section('script')
    <script>
        $(document).ready(() => {
            $('.dropify').dropify();
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

            $('#createFormUser').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    url: '/users/store',
                    type: 'POST',
                    data: formData,
                    processData: false,  
                    contentType: false, 
                    success: function(response) {
                        showToast('success', response.message)

                        window.location.href = '/users/edit/' + response.data;
                    },
                    error: (xhr) => {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            console.log(errors);
                            // Iterasi untuk semua error
                            for (const [field, messages] of Object.entries(errors)) {
                                messages.forEach(message => {
                                    showToast('error', message);
                                    console.log(message); 
                                });
                            }
                        } else {
                            showToast('error', xhr.responseJSON.error);
                            console.log(xhr.responseJSON.error);
                        }
                    }
                });
            });




        });
    </script>
@endsection

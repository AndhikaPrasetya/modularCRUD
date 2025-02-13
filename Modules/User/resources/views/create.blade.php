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
                                <input type="text" class="form-control" name="name" id="name" placeholder="nama" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="E-mail" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="roles">Roles</label>
                                <select class="allRole" name="roles[]" multiple="multiple" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" name="password" id="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="image">Foto</label>
                                <input type="file" class="form-control" name="image" accept=".jpg, .png, .jpeg">
                            </div>
                            {{-- <label for="image"> Foto Profile</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div> --}}
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-start">
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
                showToast('success', response.message);
                setTimeout(() => {
                window.location.href = '/users';
                }, 2000);
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
                    showToast('error', xhr.responseJSON.error);
                }
            }
        });
    });
});    </script>
@endsection

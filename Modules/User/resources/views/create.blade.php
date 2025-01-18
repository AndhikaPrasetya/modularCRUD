@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $breadcrumb }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="card card-primary">
            <form id="createFormUser">
                @csrf
                <div class="card-body">
                    <input type="hidden">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">password</label>
                        <input type="text" class="form-control" name="password" id="password" required>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button"onclick="window.location.href='{{ route('users.index') }}'"
                        class="btn btn-warning"><span>Back</span></button>
                </div>
            </form>
        </div>

    </section>
@endsection
@section('script')
    <script>
        $(document).ready(() => {

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            const showToast = (icon, message) => {
                Toast.fire({
                    icon: icon,
                    title: message
                });
            };
            $('#createFormUser').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/users/store',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {
                        window.location.href = '/users/edit/' + data.data;
                    },
                    error: (xhr) => {
                      const message = xhr.responseJSON.message;
                        if (xhr.status === 422) {
                            showToast('error', message);
                            console.log(message);
                        }
                        showToast('error', message);

                    }
                });
            });
        })
    </script>
@endsection

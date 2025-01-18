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
            <form id="updateFormUser" data-id="{{ $data->id }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ $data->name }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" class="form-control" name="email" id="email"
                            value="{{ $data->email }}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">new password</label>
                        <input type="text" class="form-control" name="password" id="password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>


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

            const handleFormSubmit = (formId) => {
                const form = $(`#${formId}`);
                const id = form.data('id');

                $.ajax({
                    url: `/users/update/${id}`,
                    type: 'PUT',
                    data: form.serialize(),
                    success: (response) => {
                        if (response.success) {
                            showToast('success', response.message);
                        } else {
                            showToast('error', response.message);
                        }
                    },
                    error: (xhr) => {
                        if (xhr.status === 422) {
                            showToast('error', xhr.responseJSON.message);
                        }
                        showToast('error', xhr);

                    }
                });
            };

            $('#updateFormUser').on('submit', function(e) {
                e.preventDefault();
                handleFormSubmit('updateFormUser');
            });


        });
    </script>
@endsection

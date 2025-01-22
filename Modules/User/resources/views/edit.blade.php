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
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
                        <li class="breadcrumb-item">Edit</li>
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
                   <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name"   value="{{ $data->name }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email"   value="{{ $data->email }}">
                        </div>
                    </div>
                   </div>
                   <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Roles</label>                     
                            <select class="allRole" name="roles[]" multiple="multiple" style="width: 100%;">
                                @foreach($roles as $role)
                                <option value="{{$role}}" {{in_array($role, $userRole)?'selected':''}}>{{$role}}</option>
                                @endforeach         
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="password">New password</label>
                            <input type="text" class="form-control" name="password" id="password">
                        </div>
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
                        const errors = xhr.responseJSON.errors;
                        // Iterasi untuk semua error
                        for (const [field, messages] of Object.entries(errors)) {
                            messages.forEach(message => {
                                showToast('error', message);
                                // console.log(message); 
                            });
                        }
                    } else {
                        showToast('error', 'An unexpected error occurred.');
                        console.log(xhr.responseJson);
                    }
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

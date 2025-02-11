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
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                        <li class="breadcrumb-item">Edit</li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">

        <div class="card card-primary">
    
            <form id="updateFormJenisDokumen" data-id="{{ $jenisDokumen->id }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nama_jenis_dokumen">Nama Jenis Dokumen</label>
                                <input type="text" class="form-control" name="nama_jenis_dokumen" id="nama_jenis_dokumen" value="{{ $jenisDokumen->nama_jenis_dokumen }}"
                                    required>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="card-footer">
                    <div class="d-flex justify-content-start">

                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button type="button" onclick="window.location.href='{{ route('roles.index') }}'"
                            class="btn btn-warning">
                            <span>Back</span>
                        </button>
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
                //get id form
                const form = $(`#${formId}`);
                //get id user
                const id = form.data('id');

                $.ajax({
                    url: `/jenisDokumen/update/${id}`,
                    type: 'PUT',
                    data: form.serialize(),
                    success: (response) => {
                        if (response.status) {
                            showToast('success', response.message);
                            setTimeout(() => {
                                window.location.href = '/jenisDokumen';
                            }, 2000);
                        } else {
                            showToast('error', response.message);
                        }
                    },
                    error: function(xhr) {
                        // console.log(xhr.responseJSON.error);
                        if (xhr.status === 422) {
                            showToast('error', xhr.responseJSON.errors);
                            // console.log(xhr.responseJSON.errors)
                        } else {
                            showToast('error', xhr.responseJSON.message);
                        }
                    }
                });
            };

            $('#updateFormJenisDokumen').on('submit', function(e) {
                e.preventDefault();
                handleFormSubmit('updateFormJenisDokumen');
            });
        });
    </script>
@endsection

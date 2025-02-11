@extends('layouts.layout')
@section('content')
    @include('layouts.breadcrumb')
    <section class="content">

        <div class="card card-primary">

            <form id="createFormJenisDokumen">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nama_jenis_dokumen">Nama Jenis Dokumen</label>
                                <input type="text" class="form-control " name="nama_jenis_dokumen" id="nama_jenis_dokumen" required>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-start">

                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button type="button"onclick="window.location.href='{{ route('jenisDokumen.index') }}'"
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
            toastr.options = {
                "positionClass": "toast-top-right", // Posisi toast
                "timeOut": "1000",
                "closeButton": true,
                "progressBar": true,
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

            const handleCreateForm = (formId) => {
                const form = $(`#${formId}`);
                $.ajax({
                    url: '/jenisDokumen/store',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.status) {
                            showToast('success', response.message)
                            //move page after 1000
                            setTimeout(() => {
                                window.location.href = '/jenisDokumen';
                            }, 1000);
                        } else {
                            showToast('error', response.message)
                        }
                    },
                    error: function(xhr) {
                        // console.log(xhr.responseJSON.error);
                        if (xhr.status === 422) {
                            showToast('error', xhr.responseJSON.errors);
                        } else {
                            showToast('error', xhr.responseJSON.message);
                        }
                    }
                });
            }
            $('#createFormJenisDokumen').on('submit', function(e) {
                e.preventDefault();
                handleCreateForm('createFormJenisDokumen');
            });


        })
    </script>
@endsection

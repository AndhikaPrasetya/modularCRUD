@extends('layouts.layout')
@section('content')
@include('layouts.breadcrumb')
    <section class="content">
        <div class="card card-primary">
            <form id="createFormPerusahaan">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nama">Name</label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="nama"
                                    required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="email"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control" id="alamat" rows="3" placeholder="alamat"></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="no_telp">No Phone</label>
                                <input type="tel" class="form-control" name="no_telp" id="no_telp"
                                    placeholder="Nomer Handphone" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="kode_pos">Kode Pos</label>
                                <input type="text" class="form-control" name="kode_pos" id="kode_pos"
                                    placeholder="kode pos" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="no_domisili">Nomer Domisili</label>
                                <input type="text" class="form-control" name="no_domisili" id="no_domisili"
                                    placeholder="no domisili" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nama_domisili">Nama Domisili</label>
                                <input type="text" class="form-control" name="nama_domisili" id="nama_domisili"
                                    placeholder="nama domisili" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="alamat_domisili">Alamat Domisili</label>
                                <textarea name="alamat_domisili" class="form-control" id="alamat_domisili" rows="3" placeholder="alamat domisili"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="province_domisili">Province Domisili</label>
                                <input type="text" class="form-control" name="province_domisili" id="province_domisili"
                                    placeholder="Provinsi domisili" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="kota_domisili">Kota Domisili</label>
                                <input type="text" class="form-control" name="kota_domisili" id="kota_domisili"
                                    placeholder="kota domisili" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="no_npwp">Nomer NPWP</label>
                                <input type="text" class="form-control" name="no_npwp" id="no_npwp"
                                    placeholder="Nomer NPWP" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nama_npwp">Nama NPWP</label>
                                <input type="text" class="form-control" name="nama_npwp" id="nama_npwp"
                                    placeholder="nama NPWP" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="alamat_npwp">Alamat NPWP</label>
                                <textarea name="alamat_npwp" class="form-control" id="alamat_npwp" rows="3" placeholder="alamat NPWP"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button"onclick="window.location.href='{{ route('permission.index') }}'"
                        class="btn btn-warning"><span>Back</span></button>
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
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "1000",
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
            const handleCreateForm = (formId) => {
                const form = $(`#${formId}`);
                $.ajax({
                    url: '/perusahaan/store',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.status) {
                            showToast('success', response.message)
                            setTimeout(() => {
                                window.location.href = '/perusahaan';
                            }, 1000);
                        } else {
                            showToast('error', response.message)
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
                            showToast('error', xhr.responseJSON.error);
                        }
                    }
                });
            }
            $('#createFormPerusahaan').on('submit', function(e) {
                e.preventDefault();
                handleCreateForm('createFormPerusahaan');
            });


        })
    </script>
@endsection

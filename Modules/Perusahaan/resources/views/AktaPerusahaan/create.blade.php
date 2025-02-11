@extends('layouts.layout')
@section('content')
    @include('layouts.breadcrumb')
    <section class="content">

        <div class="card card-primary">
            <form id="createFormAkta" enctype="multipart/form-data" id="dropzoneArea" class="dropzone">
                @csrf

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h3>Informasi Perusahaan</h3>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="uid_profile_perusahaan">Perusahaan</label>
                                    <select class="form-control" name="uid_profile_perusahaan" id="uid_profile_perusahaan">
                                        <option value="" disabled selected>Pilih Perusahaan</option>
                                        @foreach ($perusahaan as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status">
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="active">Active</option>
                                    <option value="expired">expired</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="domisili_perusahaan">Domisili</label>
                                <textarea name="domisili_perusahaan" class="form-control" id="domisili_perusahaan" rows="3" placeholder="domisili" readonly></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h3>Informasi Akta</h3>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="kode_akta">Kode Akta</label>
                                <input type="text" class="form-control" name="kode_akta" id="kode_akta" placeholder="kode akta" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="nama_akta">Nama Akta</label>
                                <input type="text" class="form-control" name="nama_akta" id="nama_akta" placeholder="nama akta" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="sk_kemenkum_ham">SK Kemenkum HAM</label>
                                <input type="text" class="form-control" name="sk_kemenkum_ham" id="sk_kemenkum_ham" placeholder="SK kemenkum HAM"
                                    required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="nama_notaris">Nama Notaris</label>
                                <input type="text" class="form-control" name="nama_notaris" id="nama_notaris" placeholder="nama notaris">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="tgl_terbit">Tanggal Terbit</label>
                                <input type="date" class="form-control" name="tgl_terbit" id="tgl_terbit">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="no_doc">No Document</label>
                                <input type="text" class="form-control" name="no_doc" id="no_doc" placeholder="nomer document">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Upload Files</label>
                                <div id="dropzoneArea" class="dropzone"></div>
                            </div>
                        </div>

                    </div>

                    <div id="dynamic-input-direktur">
                        <div class="row">
                            <div class="col-12">
                                <h3>Informasi Direktur dan Komisaris</h3>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nama_direktur">Nama Direktur</label>
                                    <input type="text" class="form-control" name="nama_direktur[]" id="nama_direktur" placeholder="nama"
                                        required>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" class="form-control" name="jabatan[]" id="jabatan" placeholder="jabatan" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="durasi_jabatan">Durasi Jabatan</label>
                                    <input type="text" class="form-control" name="durasi_jabatan[]" placeholder="Durasi Jabatan"
                                        id="durasi_jabatan" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 text-left">
                        <button type="button" class="btn btn-primary add-row-direktur"><i class="fas fa-plus"></i></button>
                    </div>

                    <div id="dynamic-input-saham">
                        <div class="row ">
                            <div class="col-12">
                                <h3>Informasi Saham</h3>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="pemegang_saham">Pemegang saham</label>
                                    <input type="text" class="form-control" name="pemegang_saham[]" id="pemegang_saham" placeholder="nama"
                                        required>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="jumlah_saham">Nominal saham</label>
                                    <input type="text" class="form-control" name="jumlah_saham[]" id="jumlah_saham" placeholder="jumlah"
                                        required>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="saham_persen">Saham %</label>
                                    <input type="text" class="form-control" name="saham_persen[]" id="saham_persen" placeholder="%"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 text-left">
                        <button type="button" class="btn btn-primary add-row-saham"><i class="fas fa-plus"></i></button>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan" rows="3"></textarea>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button"onclick="window.location.href='{{ route('aktaPerusahaan.index') }}'"
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
            Dropzone.autoDiscover = false;
            let fileList = [];
            let myDropzone = new Dropzone("#dropzoneArea", {
                url: "{{ route('aktaPerusahaan.store') }}",
                paramName: "file_path",
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 10,
                maxFiles: 10,
                maxFilesize: 2,
                acceptedFiles: ".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.csv,.ppt,.pptx",
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                init: function() {
                    let myDropzone = this;
                    $('#createFormAkta').on('submit', function(e) {
                        e.preventDefault();

                        if (myDropzone.getQueuedFiles().length > 0) {
                            myDropzone.processQueue();
                        } else {
                            submitForm();
                        }
                    });
                    myDropzone.on("sendingmultiple", function(data, xhr, formData) {
                        let formValues = $('#createFormAkta').serializeArray();
                        $.each(formValues, function(index, field) {
                            formData.append(field.name, field.value);
                        });
                    });
                    myDropzone.on("successmultiple", function(files, response) {
                        showToast('success', response.message);
                        setTimeout(() => {
                            window.location.href = '/aktaPerusahaan/edit/' + response
                                .perusahaanId
                        }, 1000);
                    });
                    myDropzone.on("error", function(file, message) {
                        showToast('error', message);
                    });
                }
            });


            function submitForm() {
                let formData = new FormData($('#createFormAkta')[0]);
                $.ajax({
                    url: "{{ route('aktaPerusahaan.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        showToast('success', 'Document uploaded successfully!');
                        setTimeout(() => {
                            window.location.href = '/aktaPerusahaan/edit/' + response
                                .perusahaanId;
                        }, 1000);
                    },
                    error: function(xhr) {
                        showToast('error', 'Something went wrong.');
                    }
                });
            }

            //get data domisili
            $('#uid_profile_perusahaan').on('change', function(e) {
                const perusahaan_id = this.value;

                if (perusahaan_id) {
                    fetch(`{{ route('perusahaan.domisili') }}?id=${perusahaan_id}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('domisili_perusahaan').value = data.domisili;
                            } else {
                                alert('Gagal mengambil data domisili.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

            });

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

            //dynamic input 
            $('.add-row-direktur').on('click', function(e) {
                e.preventDefault();

                if (e.target.classList.contains('add-row-direktur')) {
                    const newRow = document.createElement('div');
                    newRow.classList.add('row','align-items-center');
                    newRow.innerHTML = `
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="nama_direktur">Nama Direktur</label>
                        <input type="text" class="form-control" name="nama_direktur[]" placeholder="nama" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan[]" placeholder="jabatan" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="durasi_jabatan">Durasi Jabatan</label>
                        <input type="text" class="form-control" name="durasi_jabatan[]" placeholder="Durasi Jabatan" required>
                    </div>
                </div>
                <div class="col-1">
                                <button type="button" class="btn btn-danger remove-row"><i class="fas fa-trash"></i></button>
                            </div>
            `;
                    const container = document.getElementById('dynamic-input-direktur');
                    container.appendChild(newRow);
                }
            });
            $('.add-row-saham').on('click', function(e) {
                e.preventDefault();

                if (e.target.classList.contains('add-row-saham')) {
                    const newRow = document.createElement('div');
                    newRow.classList.add('row','align-items-center');
                    newRow.innerHTML = `
                 <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="pemegang_saham">Pemegang saham</label>
                                <input type="text" class="form-control" name="pemegang_saham[]" id="pemegang_saham" placeholder="nama"
                                    required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="jumlah_saham">Nominal saham</label>
                                <input type="text" class="form-control" name="jumlah_saham[]" id="jumlah_saham" placeholder="jumlah"
                                    required>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="saham_persen">Saham %</label>
                                <input type="text" class="form-control" name="saham_persen[]" id="saham_persen" placeholder="%"
                                    required>
                            </div>
                        </div>
                         <div class="col-1 text-left">
                    <button type="button" class="btn btn-danger remove-row"><i class="fas fa-trash"></i></button>
                </div>
            `;
                    const container = document.getElementById('dynamic-input-saham');
                    container.appendChild(newRow);
                }
            });

            $(document).on('click', '.remove-row', function(e) {
                e.preventDefault();
                $(this).closest('.row').remove();
            });

        });
    </script>
@endsection

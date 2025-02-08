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
                        <li class="breadcrumb-item"><a href="{{ route('perusahaan.index') }}">Perusahaan</a></li>
                        <li class="breadcrumb-item">Edit</li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">

        <div class="card card-primary">
            <form id="editFormAkta" class="dropzone" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="aktaId" value="{{ $akta->id }}">
                <input type="hidden" id="existingAttachment" value='@json($existingAttachment)'>
                <input type="hidden" name="deleted_files" id="deleted_files">
                <div class="card-body">

                    <div class="row mb-4">
                        <div class="col-12">
                            <h3>Informasi Perusahaan</h3>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="uid_profile_perusahaan">Perusahaan</label>
                                @if ($perusahaan->isNotEmpty())
                                    <select class="form-control" name="uid_profile_perusahaan" id="uid_profile_perusahaan">
                                        <option value="" disabled selected>Pilih Perusahaan</option>
                                        @foreach ($perusahaan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $akta->uid_profile_perusahaan ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status">
                                    <option value="" disabled>Pilih Status</option>
                                    <option value="active" {{ old('status', $akta->status) == 'active' ? 'selected' : '' }}>
                                        Active</option>

                                    <option value="expired"
                                        {{ old('status', $akta->status) == 'expired' ? 'selected' : '' }}>expired</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="domisili_perusahaan">Domisili</label>
                                <textarea name="domisili_perusahaan" class="form-control" id="domisili_perusahaan" rows="3" readonly>{{ $domisili }}</textarea>
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
                                <input type="text" class="form-control" name="kode_akta" id="kode_akta"
                                    value="{{ $akta->kode_akta }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="nama_akta">Nama Akta</label>
                                <input type="text" class="form-control" name="nama_akta" id="nama_akta"
                                    value="{{ $akta->nama_akta }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="sk_kemenkum_ham">SK Kemenkum HAM</label>
                                <input type="text" class="form-control" name="sk_kemenkum_ham" id="sk_kemenkum_ham"
                                    value="{{ $akta->sk_kemenkum_ham }}">
                            </div>
                        </div>


                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="nama_notaris">Nama Notaris</label>
                                <input type="text" class="form-control" name="nama_notaris" id="nama_notaris"
                                    value="{{ $akta->nama_notaris }}">
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="tgl_terbit">Tanggal Terbit</label>
                                <input type="date" class="form-control" name="tgl_terbit" id="tgl_terbit"
                                    value="{{ \Carbon\Carbon::parse($akta->tgl_terbit)->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="no_doc">No Document</label>
                                <input type="tel" class="form-control" name="no_doc" id="no_doc"
                                    value="{{ $akta->no_doc }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Upload Files</label>
                                <div id="dropzone" class="dropzone">
                                    <div class="dz-message" data-dz-message>
                                        <span>Drop files here or click to upload</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="dynamic-input-direktur">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h3>Informasi Direktur dan Komisaris</h3>
                            </div>
                        </div>
                        @foreach ($direkturs as $direktur)
                            <div class="row align-items-center">
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <input type="hidden" name="id_direktur[]" value="{{ $direktur->id }}">
                                        <label for="nama_direktur">Nama Direktur</label>
                                        <input type="text" class="form-control" name="nama_direktur[]"
                                            id="nama_direktur" value="{{ $direktur->nama_direktur }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="jabatan">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan[]" id="jabatan"
                                            value="{{ $direktur->jabatan }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="durasi_jabatan">Durasi Jabatan</label>
                                        <input type="text" class="form-control" name="durasi_jabatan[]"
                                            id="durasi_jabatan" value="{{ $direktur->durasi_jabatan }}">
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-danger remove-row-direktur"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="text-left mb-3">
                        <button type="button" class="btn btn-primary add-row-direktur"><i class="fas fa-plus"></i></button>
                    </div>

                    <div id="dynamic-input-saham">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h3>Informasi Saham</h3>
                            </div>
                        </div>
                            @foreach ($shareholders as $shareholder)
                            <div class="row align-items-center">
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <input type="hidden" name="id_saham[]" value="{{ $shareholder->id }}">
                                        <label for="pemegang_saham">Pemegang saham</label>
                                        <input type="text" class="form-control" name="pemegang_saham[]"
                                            id="pemegang_saham" value="{{ $shareholder->pemegang_saham }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="jumlah_saham">Nominal saham</label>
                                        <input type="text" class="form-control" name="jumlah_saham[]"
                                            id="jumlah_saham" value="{{ $shareholder->jumlah_saham }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="saham_persen">Saham %</label>
                                        <input type="text" class="form-control" name="saham_persen[]"
                                            id="saham_persen" value="{{ $shareholder->saham_persen }}">
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-danger remove-row-saham"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                            @endforeach
                    </div>
                    <div class="text-left mb-3">
                        <button type="button" class="btn btn-primary add-row-saham"><i class="fas fa-plus"></i></button>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan" rows="3">{{ $akta->keterangan }}</textarea>
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
        $(document).ready(function() {

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

                url: "/aktaPerusahaan/update/" + $('#aktaId').val(),
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
                    $('#editFormAkta').submit(function(e) {
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

                            $.ajax({
                                url: "/aktaPerusahaan/delete-file/" + file.id,
                                type: "DELETE",
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    showToast('success', response.message);
                                },
                                error: function(xhr) {
                                    showToast('error', 'Gagal Hapus File');
                                }
                            });
                        }
                    });
                }
            });

            function submitFormData() {
                let formData = new FormData($('#editFormAkta')[0]);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: "/aktaPerusahaan/update/" + $('#aktaId').val(),
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
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        showToast('error', message);
                    },
                    complete: function() {
                        $('#submitBtn').prop('disabled', false);
                    }
                });
            }

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

            //dynamic input 
            $(document).on('click','.add-row-direktur', function(e) {
                e.preventDefault();

                if (e.target.classList.contains('add-row-direktur')) {
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'align-items-center');
                    newRow.innerHTML = `
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="nama_direktur">Nama Direktur</label>
                        <input type="text" class="form-control" name="nama_direktur[]" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan[]" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="durasi_jabatan">Durasi Jabatan</label>
                        <input type="text" class="form-control" name="durasi_jabatan[]" required>
                    </div>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger remove-row-direktur"><i class="fas fa-trash"></i></button>
                </div>
            `;
                    const container = document.getElementById('dynamic-input-direktur');
                    container.appendChild(newRow);
                }
            });
            $(document).on('click','.add-row-saham', function(e) {
                e.preventDefault();

                if (e.target.classList.contains('add-row-saham')) {
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'align-items-center');
                    newRow.innerHTML = `
                 <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="pemegang_saham">Pemegang saham</label>
                                <input type="text" class="form-control" name="pemegang_saham[]" id="pemegang_saham"
                                    required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="jumlah_saham">Nominal saham</label>
                                <input type="text" class="form-control" name="jumlah_saham[]" id="jumlah_saham"
                                    required>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="saham_persen">Saham %</label>
                                <input type="text" class="form-control" name="saham_persen[]" id="saham_persen"
                                    required>
                            </div>
                        </div>
                            <div class="col-1">
                       <button type="button" class="btn btn-danger remove-row-saham"><i class="fas fa-trash"></i></button>
                   </div>
            `;
                    const container = document.getElementById('dynamic-input-saham');
                    container.appendChild(newRow);
                }
            });

            $(document).on('click', '.remove-row-direktur', function(e) {
                e.preventDefault();

                let row = $(this).closest('.row');
                let id = row.find('input[name="id_direktur[]"]').val();

                if (!id) {
                    row.remove();
                    return;
                }

                $.ajax({
                    url: "/delete-direktur/" + id, // Ganti dengan URL endpoint yang sesuai
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            row
                        .remove(); // Hapus baris dari tampilan jika berhasil dihapus dari database
                            toastr.success("Data berhasil dihapus!");
                        } else {
                            toastr.error("Gagal menghapus data.");
                        }
                    },
                    error: function(xhr) {
                        toastr.error("Terjadi kesalahan saat menghapus data.");
                    },
                    complete: function() {
                        row.find('.remove-row').prop('disabled',
                        false); // Aktifkan kembali tombol
                    }
                });

            });
            $(document).on('click', '.remove-row-saham', function(e) {
                e.preventDefault();

                let row = $(this).closest('.row');
                let id = row.find('input[name="id_saham[]"]').val();

                if (!id) {
                    row.remove();
                    return;
                }

                $.ajax({
                    url: "/delete-saham/" + id, 
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            row
                        .remove(); 
                            toastr.success("Data berhasil dihapus!");
                        } else {
                            toastr.error("Gagal menghapus data.");
                        }
                    },
                    error: function(xhr) {
                        toastr.error("Terjadi kesalahan saat menghapus data.");
                    },
                    complete: function() {
                        row.find('.remove-row-saham').prop('disabled',
                        false);
                    }
                });

            });

        });
    </script>
@endsection

@extends('layouts.layout')
@section('content')
@include('layouts.breadcrumb')
<section class="content">

  <div class="card card-primary">
      <form id="createFormSewa">
          @csrf
          <div class="card-body">
            <div class="row mb-4">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="no_dokumen">No dokumen</label>
                        <input type="text" class="form-control" name="no_dokumen" id="no_dokumen" placeholder="Nomer Dokumen" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="jenis_dokumen_id">Jenis Dokumen</label>
                            <select class="form-control" name="jenis_dokumen_id" id="jenis_dokumen_id">
                                <option value="" disabled selected>Pilih jenis Dokumen</option>
                                @foreach ($jenisDokumen as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_jenis_dokumen }}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="lokasi_id">Lokasi</label>
                            <select class="form-control" name="lokasi_id" id="lokasi_id">
                                <option value="" disabled selected>Pilih Lokasi</option>
                                @foreach ($lokasi as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="nama_notaris">Nama Notaris</label>
                        <input type="text" class="form-control" name="nama_notaris" id="nama_notaris" placeholder="Nama Notaris" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="sign_by">sign by</label>
                        <input type="text" class="form-control" name="sign_by" id="sign_by" placeholder="Sign By" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="nama_pemilik_awal">nama pemilik awal</label>
                        <input type="text" class="form-control" name="nama_pemilik_awal" id="nama_pemilik_awal" placeholder="nama pemilik awal" required>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="tanggal_dokumen">tanggal dokumen</label>
                        <input type="date" class="form-control" name="tanggal_dokumen" id="tanggal_dokumen" required>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="tentang">Tentang</label>
                        <input type="text" class="form-control" name="tentang" id="tentang" required>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="no_sertifikat">No Sertifikat</label>
                        <input type="text" class="form-control" name="no_sertifikat" id="no_sertifikat" placeholder="sewa akhir" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="jenis_sertifikat">Jenis Sertifikat</label>
                        <select name="jenis_sertifikat" id="jenis_sertifikat" class="form-control">
                            <option value="" selected disabled>Pilih Jenis Sertifikat</option>
                            <option value="HGB">HGB</option>
                            <option value="SHM">SHM</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="tgl_sertifikat">Tanggal Sertifikat</label>
                        <input type="date" class="form-control" name="tgl_sertifikat" id="tgl_sertifikat" placeholder="sewa akhir" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="tgl_akhir_sertifikat">Tanggal Akhir Sertifikat</label>
                        <input type="date" class="form-control" name="tgl_akhir_sertifikat" id="tgl_akhir_sertifikat" placeholder="sewa akhir" required>
                    </div>
                </div>
              </div>

          <div class="row mb-4">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="sewa_awal">sewa awal</label>
                    <input type="date" class="form-control" name="sewa_awal" id="sewa_awal" placeholder="sewa awal" required>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="sewa_akhir">Sewa Akhir</label>
                    <input type="date" class="form-control" name="sewa_akhir" id="sewa_akhir" placeholder="sewa akhir" required>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="sewa_handover">Sewa HandOver</label>
                    <input type="date" class="form-control" name="sewa_handover" id="sewa_handover" placeholder="sewa akhir" required>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="sewa_grace_period">Sewa Grace Period</label>
                    <input type="text" class="form-control" name="sewa_grace_period" id="sewa_grace_period" placeholder="sewa grace period" >
                </div>
            </div>
          </div>
        </div>

          <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button
              type="button"onclick="window.location.href='{{ route('sewaMenyewa.index') }}'"
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
        const handleCreateForm = (formId) =>{
          const form = $(`#${formId}`);
          $.ajax({
            url:'/sewaMenyewa/store',
            type:'POST',
            data:form.serialize(),
            success:function(response){
              if (response.status) {
                  showToast('success',response.message)
                 setTimeout(() => {
                    window.location.href = '/sewaMenyewa/edit/' + response.sewaId;
                 }, 1000);
              } else {
                  showToast('error',response.message)
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
        $('#createFormSewa').on('submit', function(e){
          e.preventDefault();
          handleCreateForm('createFormSewa');
        });

      
       });

     
    </script>
@endsection


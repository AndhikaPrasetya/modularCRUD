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
        <form id="editFormSewa" data-id="{{$data->id}}">
            @csrf
            @method('PUT')
            <div class="card-body">
              <div class="row mb-4">
                  <div class="col-12 col-md-4">
                      <div class="form-group">
                          <label for="no_dokumen">No dokumen</label>
                          <input type="text" class="form-control" name="no_dokumen" id="no_dokumen" value="{{$data->no_dokumen}}">
                      </div>
                  </div>
                  <div class="col-12 col-md-4">
                      <div class="form-group">
                          <label for="jenis_dokumen_id">Jenis Dokumen</label>
                          @if ($jenisDokumen->isNotEmpty())
                              <select class="form-control" name="jenis_dokumen_id" id="jenis_dokumen_id">
                                  <option value="" disabled selected>Pilih jenis Dokumen</option>
                                  @foreach ($jenisDokumen as $item)
                                      <option value="{{ $item->id }}"{{$data->jenis_dokumen_id ==  $item->id ? 'selected' : ''}}>{{ $item->nama_jenis_dokumen }}</option>
                                  @endforeach
                              </select>
                          @endif
                      </div>
                  </div>
                  <div class="col-12 col-md-4">
                      <div class="form-group">
                          <label for="lokasi_id">Lokasi</label>
                          @if ($lokasi->isNotEmpty())
                              <select class="form-control" name="lokasi_id" id="lokasi_id">
                                  <option value="" disabled selected>Pilih Lokasi</option>
                                  @foreach ($lokasi as $item)
                                      <option value="{{ $item->id }}" {{$data->lokasi_id == $item->id ? 'selected' : ''}}>{{ $item->nama }}</option>
                                  @endforeach
                              </select>
                          @endif
                      </div>
                  </div>
                
              </div>
              <div class="row mb-4">
                  <div class="col-12 col-md-4">
                      <div class="form-group">
                          <label for="nama_notaris">Nama Notaris</label>
                          <input type="text" class="form-control" name="nama_notaris" id="nama_notaris" value="{{$data->nama_notaris}}">
                      </div>
                  </div>
                  <div class="col-12 col-md-4">
                      <div class="form-group">
                          <label for="sign_by">sign by</label>
                          <input type="text" class="form-control" name="sign_by" id="sign_by"value="{{$data->sign_by}}">
                      </div>
                  </div>
                  <div class="col-12 col-md-4">
                      <div class="form-group">
                          <label for="nama_pemilik_awal">nama pemilik awal</label>
                          <input type="text" class="form-control" name="nama_pemilik_awal" id="nama_pemilik_awal" value="{{$data->nama_pemilik_awal}}">
                      </div>
                  </div>
              </div>
              <div class="row mb-4">
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="tanggal_dokumen">tanggal dokumen</label>
                          <input type="date" class="form-control" name="tanggal_dokumen" id="tanggal_dokumen" value="{{\Carbon\Carbon::parse($data->tanggal_dokumen)->format('Y-m-d')}}">
                      </div>
                  </div>
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="tentang">Tentang</label>
                          <input type="text" class="form-control" name="tentang" id="tentang" value="{{$data->tentang}}">
                      </div>
                  </div>
              </div>
  
              <div class="row mb-4">
                  <div class="col-12 col-md-3">
                      <div class="form-group">
                          <label for="no_sertifikat">No Sertifikat</label>
                          <input type="text" class="form-control" name="no_sertifikat" id="no_sertifikat" value="{{$data->no_sertifikat}}">
                      </div>
                  </div>
                  <div class="col-12 col-md-3">
                      <div class="form-group">
                          <label for="jenis_sertifikat">Jenis Sertifikat</label>
                          <select name="jenis_sertifikat" id="jenis_sertifikat" class="form-control">
                              <option value="" selected disabled>Pilih Jenis Sertifikat</option>
                              <option value="HGB" {{$data->jenis_sertifikat == 'HGB' ? 'selected' :''}}>HGB</option>
                              <option value="HM" {{$data->jenis_sertifikat == 'HM' ? 'selected' :''}}>HM</option>
      
                          </select>
                      </div>
                  </div>
                  <div class="col-12 col-md-3">
                      <div class="form-group">
                          <label for="tgl_sertifikat">Tanggal Sertifikat</label>
                          <input type="date" class="form-control" name="tgl_sertifikat" id="tgl_sertifikat" value="{{\Carbon\Carbon::parse($data->tgl_sertifikat)->format('Y-m-d')}}">
                      </div>
                  </div>
                  <div class="col-12 col-md-3">
                      <div class="form-group">
                          <label for="tgl_akhir_sertifikat">Tanggal Akhir Sertifikat</label>
                          <input type="date" class="form-control" name="tgl_akhir_sertifikat" id="tgl_akhir_sertifikat" value="{{\Carbon\Carbon::parse($data->tgl_akhir_sertifikat)->format('Y-m-d')}}">
                      </div>
                  </div>
                </div>
  
            <div class="row mb-4">
              <div class="col-12 col-md-3">
                  <div class="form-group">
                      <label for="sewa_awal">sewa awal</label>
                      <input type="date" class="form-control" name="sewa_awal" id="sewa_awal" value="{{\Carbon\Carbon::parse($data->sewa_awal)->format('Y-m-d')}}">
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="form-group">
                      <label for="sewa_akhir">Sewa Akhir</label>
                      <input type="date" class="form-control" name="sewa_akhir" id="sewa_akhir" value="{{\Carbon\Carbon::parse($data->sewa_akhir)->format('Y-m-d')}}">
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="form-group">
                      <label for="sewa_handover">Sewa HandOver</label>
                      <input type="date" class="form-control" name="sewa_handover" id="sewa_handover" value="{{\Carbon\Carbon::parse($data->sewa_handover)->format('Y-m-d')}}">
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="form-group">
                      <label for="sewa_grace_period">Sewa Grace Period</label>
                      <input type="text" class="form-control" name="sewa_grace_period" id="sewa_grace_period" value="{{$data->sewa_grace_period}}">
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
        const handleEditForm = (formId) => {
                //get id form
                const form = $(`#${formId}`);
                //get id user
                const id = form.data('id');

                $.ajax({
                    url: `/sewaMenyewa/update/${id}`,
                    type: 'PUT',
                    data: form.serialize(),
                    success: (response) => {
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
        $('#editFormSewa').on('submit', function(e){
          e.preventDefault();
          handleEditForm('editFormSewa');
        });

    });
    </script>
@endsection


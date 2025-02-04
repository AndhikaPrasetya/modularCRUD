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
      <form id="editFormPerusahaan" data-id="{{ $data->id }}">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="nama">Name</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{$data->nama}}">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{$data->email}}">
                    </div>
                </div>
            </div>
          
          <div class="row">
            <div class="col-12 mb-3">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control" id="alamat" rows="3">{{$data->alamat}}</textarea>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="telp">No Phone</label>
                    <input type="tel" class="form-control" name="telp" id="telp" value="{{$data->telp}}">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="kode_pos">Kode Pos</label>
                    <input type="text" class="form-control" name="kode_pos" id="kode_pos" value="{{$data->kode_pos}}">
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="no_domisili">Nomer Domisili</label>
                    <input type="text" class="form-control" name="no_domisili" id="no_domisili" value="{{$data->no_domisili}}">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="nama_domisili">Nama Domisili</label>
                    <input type="text" class="form-control" name="nama_domisili" id="nama_domisili" value="{{$data->nama_domisili}}">
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="alamat_domisili">Alamat Domisili</label>
                    <textarea name="alamat_domisili" class="form-control" id="alamat_domisili" rows="3">{{$data->alamat_domisili}}</textarea>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="province_domisili">Province Domisili</label>
                    <input type="text" class="form-control" name="province_domisili" id="province_domisili" value="{{$data->province_domisili}}">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="kota_domisili">Kota Domisili</label>
                    <input type="text" class="form-control" name="kota_domisili" id="kota_domisili" value="{{$data->kota_domisili}}">
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="no_npwp">Nomer NPWP</label>
                    <input type="text" class="form-control" name="no_npwp" id="no_npwp" value="{{$data->no_npwp}}">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="nama_npwp">Nama NPWP</label>
                    <input type="text" class="form-control" name="nama_npwp" id="nama_npwp" value="{{$data->nama_npwp}}">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="alamat_npwp">Alamat NPWP</label>
                    <textarea name="alamat_npwp" class="form-control" id="alamat_npwp" rows="3">{{$data->alamat_npwp}}</textarea>
                </div>
            </div>
          </div>
        </div>
  
          <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button
              type="button"onclick="window.location.href='{{ route('perusahaan.index') }}'"
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
                    url: `/perusahaan/update/${id}`,
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
        $('#editFormPerusahaan').on('submit', function(e){
          e.preventDefault();
          handleEditForm('editFormPerusahaan');
        });


       })

     
    </script>
@endsection


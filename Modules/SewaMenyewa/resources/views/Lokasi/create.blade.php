@extends('layouts.layout')
@section('content')
@include('layouts.breadcrumb')
<section class="content">

  <div class="card card-primary">
      <form id="createFormLokasi">
          @csrf
          <div class="card-body">
            <div class="row mb-4">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="uid_profile_perusahaan">Perusahaan</label>
                        @if ($perusahaan->isNotEmpty())
                            <select class="form-control" name="uid_profile_perusahaan" id="uid_profile_perusahaan">
                                <option value="" disabled selected>Pilih Perusahaan</option>
                                @foreach ($perusahaan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="nama">Name</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Lengkap" required>
                    </div>
                </div>
                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" class="form-control" id="alamat" placeholder="Alamat Lengkap"></textarea>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="phone">No Phone</label>
                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Nomor Phone" required>
                    </div>
                </div>
            </div>
          
          <div class="row mb-4">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="category" id="category">
                        <option value="" disabled selected>Pilih Category</option>
                        <option value="office">Office</option>
                        <option value="gudang/workshop">Gudang / Workshop</option>
                        <option value="outlet/clinic">Outlet / Clinic</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="type">Type</label>
                    <select class="form-control" name="type" id="type">
                        <option value="" disabled selected>Pilih Type</option>
                        <option value="mall">Mall</option>
                        <option value="non-mall">Non Mall</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="status">status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="" disabled selected>Pilih Status</option>
                        <option value="fadly_own">Fadly Own</option>
                        <option value="rent">Rent</option>
                        <option value="zap_own">Zap Own</option>
                    </select>
                </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="luas">Luas</label>
                    <input type="text" class="form-control" name="luas" id="luas" placeholder="Luas Area" required>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" required>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="pph">PPH</label>
                    <input type="text" class="form-control" name="pph" id="pph" placeholder="PPH" required>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label for="ppn">PPN</label>
                    <input type="text" class="form-control" name="ppn" id="ppn" placeholder="PPN" required>
                </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="deposit">Deposit</label>
                    <input type="text" class="form-control" name="deposit" id="deposit" placeholder="Jumlah Deposit" required>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="no_pbb">Nomer PBB</label>
                    <input type="text" class="form-control" name="no_pbb" id="no_pbb" placeholder="Nomer PBB" required>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="pembayar_pbb">Pembayar PBB</label>
                    <select class="form-control" name="pembayar_pbb" id="pembayar_pbb">
                        <option value="" disabled selected>Pilih Pembayar</option>
                        <option value="fadly">Fadly</option>
                        <option value="sharing">Sharing</option>
                        <option value="pemilik">Pemilik</option>
                        <option value="zap">Zap</option>
                    </select>
                </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="id_pln">ID PLN</label>
                    <input type="text" class="form-control" name="id_pln" id="id_pln" placeholder="ID PLN" required>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="daya">Daya</label>
                    <input type="text" class="form-control" name="daya" id="daya" placeholder="daya listrik" required>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="id_pdam">ID PDAM</label>
                    <input type="text" class="form-control" name="id_pdam" id="id_pdam" placeholder="ID PDAM" required>
                </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="denda_telat_bayar">Denda Telat Bayar</label>
                    <input type="text" class="form-control" name="denda_telat_bayar" id="denda_telat_bayar" placeholder="Denda keterlambatan" required>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="denda_pembatalan">Denda Pembatalan</label>
                    <input type="text" class="form-control" name="denda_pembatalan" id="denda_pembatalan" placeholder="Denda pembatalan" required>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="denda_pengosongan">Denda Pengosongan</label>
                    <input type="text" class="form-control" name="denda_pengosongan" id="denda_pengosongan" placeholder="Denda pengosongan" required>
                </div>
            </div>
          </div>

          <div id="dynamic-input-nopd">
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="nopd">Nopd</label>
                        <input type="text" class="form-control" name="nopd[]" id="nopd" placeholder="nopd"
                            required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="bentuk">Bentuk</label>
                        <input type="text" class="form-control" name="bentuk[]" id="bentuk" placeholder="Bentuk" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="ukuran">Ukuran</label>
                        <input type="text" class="form-control" name="ukuran[]" placeholder="ukuran"
                            id="ukuran" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 text-left">
            <button type="button" class="btn btn-primary add-row-nopd"><i class="fas fa-plus"></i></button>
        </div>

        <div id="dynamic-input-internet">
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="id_internet">ID internet</label>
                        <input type="text" class="form-control" name="id_internet[]" id="id_internet" placeholder="ID Internet"
                            required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="speed_internet">Speed Internet</label>
                        <input type="text" class="form-control" name="speed_internet[]" id="speed_internet" placeholder="Speed Internet" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="harga_internet">Harga Internet</label>
                        <input type="text" class="form-control" name="harga_internet[]" placeholder="Harga Internet"
                            id="harga_internet" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 text-left">
            <button type="button" class="btn btn-primary add-row-internet"><i class="fas fa-plus"></i></button>
        </div>
         
        </div>
  
          <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button
              type="button"onclick="window.location.href='{{ route('lokasi.index') }}'"
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
            url:'/lokasi/store',
            type:'POST',
            data:form.serialize(),
            success:function(response){
              if (response.status) {
                  showToast('success',response.message)
                 setTimeout(() => {
                    window.location.href = '/lokasi/edit/' + response.lokasiId;
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
        $('#createFormLokasi').on('submit', function(e){
          e.preventDefault();
          handleCreateForm('createFormLokasi');
        });

        $('.add-row-nopd').on('click', function(e) {
                e.preventDefault();

                if (e.target.classList.contains('add-row-nopd')) {
                    const newRow = document.createElement('div');
                    newRow.classList.add('row','align-items-center');
                    newRow.innerHTML = `
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="nopd">Nopd</label>
                        <input type="text" class="form-control" name="nopd[]" id="nopd" placeholder="nopd"
                            required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="bentuk">Bentuk</label>
                        <input type="text" class="form-control" name="bentuk[]" id="bentuk" placeholder="bentuk" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="ukuran">Ukuran</label>
                        <input type="text" class="form-control" name="ukuran[]" placeholder="ukuran"
                            id="ukuran" required>
                    </div>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger remove-row"><i class="fas fa-trash"></i></button>
                </div>
            `;
                    const container = document.getElementById('dynamic-input-nopd');
                    container.appendChild(newRow);
                }
            });
        $('.add-row-internet').on('click', function(e) {
                e.preventDefault();

                if (e.target.classList.contains('add-row-internet')) {
                    const newRow = document.createElement('div');
                    newRow.classList.add('row','align-items-center');
                    newRow.innerHTML = `
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="id_internet">ID internet</label>
                        <input type="text" class="form-control" name="id_internet[]" id="id_internet" placeholder="ID internet"
                            required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="speed_internet">Speed Internet</label>
                        <input type="text" class="form-control" name="speed_internet[]" id="speed_internet" placeholder="Speed Internet" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="harga_internet">Harga Internet</label>
                        <input type="text" class="form-control" name="harga_internet[]" placeholder="Harga Internet"
                            id="harga_internet" required>
                    </div>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger remove-row"><i class="fas fa-trash"></i></button>
                </div>
            `;
                    const container = document.getElementById('dynamic-input-internet');
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


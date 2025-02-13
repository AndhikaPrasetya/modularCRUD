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
        <form id="editFormLokasi" data-id="{{$lokasi->id}}">
            @csrf
            @method('PUT')
            <div class="card-body">
              <div class="row mb-4">
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="uid_profile_perusahaan">Perusahaan</label>
                          @if ($perusahaan->isNotEmpty())
                              <select class="form-control" name="uid_profile_perusahaan" id="uid_profile_perusahaan">
                                  <option value="" disabled selected>Pilih Perusahaan</option>
                                  @foreach ($perusahaan as $item)
                                      <option value="{{ $item->id }}"  {{ $item->id == $lokasi->uid_profile_perusahaan ? 'selected' : '' }}>{{ $item->nama }}</option>
                                  @endforeach
                              </select>
                          @endif
                      </div>
                  </div>
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="nama">Name</label>
                          <input type="text" class="form-control" name="nama" id="nama" value="{{$lokasi->nama}}">
                      </div>
                  </div>
                  <div class="col-12 col-md-12">
                      <div class="form-group">
                          <label for="alamat">Alamat</label>
                          <textarea name="alamat" class="form-control" id="alamat">{{$lokasi->alamat}}</textarea>
                      </div>
                  </div>
                  <div class="col-12 col-md-4">
                      <div class="form-group">
                          <label for="phone">No Phone</label>
                          <input type="tel" class="form-control" name="phone" id="phone" value="{{$lokasi->phone}}">
                      </div>
                  </div>
              </div>
            
            <div class="row mb-4">
              <div class="col-12 col-md-4">
                  <div class="form-group">
                      <label for="category">Category</label>
                      <select class="form-control" name="category" id="category">
                          <option value="" disabled selected>Pilih Category</option>
                          <option value="office"{{$lokasi->category == 'office' ? 'selected' : ''}}>Office</option>
                          <option value="gudang/workshop" {{$lokasi->category == 'gudang/workshop' ? 'selected' : ''}}>Gudang / Workshop</option>
                          <option value="outlet/clinic" {{$lokasi->category == 'outlet/clinic' ? 'selected' : ''}}>Outlet / Clinic</option>
                      </select>
                  </div>
              </div>
              <div class="col-12 col-md-4">
                  <div class="form-group">
                      <label for="type">Type</label>
                      <select class="form-control" name="type" id="type">
                          <option value="" disabled selected>Pilih Type</option>
                          <option value="mall" {{$lokasi->type == 'mall' ?'selected':''}}>Mall</option>
                          <option value="non-mall"  {{$lokasi->type == 'non-mall' ?'selected':''}}>Non Mall</option>
                      </select>
                  </div>
              </div>
              <div class="col-12 col-md-4">
                  <div class="form-group">
                      <label for="status">status</label>
                      <select class="form-control" name="status" id="status">
                          <option value="" disabled selected>Pilih Status</option>
                          <option value="fadly_own"  {{$lokasi->status == 'fadly_own' ?'selected':''}}>Fadly Own</option>
                          <option value="rent"  {{$lokasi->status == 'rent' ?'selected':''}}>Rent</option>
                          <option value="zap_own"  {{$lokasi->status == 'zap_own' ?'selected':''}}>Zap Own</option>
                      </select>
                  </div>
              </div>
            </div>
  
            <div class="row mb-4">
              <div class="col-12 col-md-3">
                  <div class="form-group">
                      <label for="luas">Luas</label>
                      <input type="text" class="form-control" name="luas" id="luas" value="{{$lokasi->luas}}">
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="form-group">
                      <label for="harga">Harga</label>
                      <input type="text" class="form-control" name="harga" id="harga" value="{{$lokasi->harga}}">
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="form-group">
                      <label for="pph">PPH</label>
                      <input type="text" class="form-control" name="pph" id="pph" value="{{$lokasi->pph}}">
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="form-group">
                      <label for="ppn">PPN</label>
                      <input type="text" class="form-control" name="ppn" id="ppn" value="{{$lokasi->ppn}}">
                  </div>
              </div>
            </div>
  
            <div class="row mb-4">
              <div class="col-12 col-md-4">
                  <div class="form-group">
                      <label for="deposit">Deposit</label>
                      <input type="text" class="form-control" name="deposit" id="deposit" value="{{$lokasi->deposit}}">
                  </div>
              </div>
              <div class="col-12 col-md-4">
                  <div class="form-group">
                      <label for="no_pbb">Nomer PBB</label>
                      <input type="text" class="form-control" name="no_pbb" id="no_pbb" value="{{$lokasi->no_pbb}}">
                  </div>
              </div>
              <div class="col-12 col-md-4">
                  <div class="form-group">
                      <label for="pembayar_pbb">Pembayar PBB</label>
                      <select class="form-control" name="pembayar_pbb" id="pembayar_pbb">
                          <option value="" disabled selected>Pilih Pembayar</option>
                          <option value="fadly"{{$lokasi->pembayar_pbb == 'fadly' ? 'selected' : ''}}>Fadly</option>
                          <option value="sharing" {{$lokasi->pembayar_pbb == 'sharing' ? 'selected' : ''}}>Sharing</option>
                          <option value="pemilik" {{$lokasi->pembayar_pbb == 'pemilik' ? 'selected' : ''}}>Pemilik</option>
                          <option value="zap" {{$lokasi->pembayar_pbb == 'zap' ? 'selected' : ''}}>Zap</option>
                      </select>
                  </div>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-12 col-md-4">
                  <div class="form-group">
                      <label for="id_pln">ID PLN</label>
                      <input type="text" class="form-control" name="id_pln" id="id_pln" value="{{$lokasi->id_pln}}">
                  </div>
              </div>
              <div class="col-12 col-md-4">
                  <div class="form-group">
                      <label for="daya">Daya</label>
                      <input type="text" class="form-control" name="daya" id="daya" value="{{$lokasi->daya}}">
                  </div>
              </div>
              <div class="col-12 col-md-4">
                  <div class="form-group">
                      <label for="id_pdam">ID PDAM</label>
                      <input type="text" class="form-control" name="id_pdam" id="id_pdam" value="{{$lokasi->id_pdam}}">
                  </div>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-12 col-md-4">
                  <div class="form-group">
                      <label for="denda_telat_bayar">Denda Telat Bayar</label>
                      <input type="text" class="form-control" name="denda_telat_bayar" id="denda_telat_bayar" value="{{$lokasi->denda_telat_bayar}}">
                  </div>
              </div>
              <div class="col-12 col-md-4">
                  <div class="form-group">
                      <label for="denda_pembatalan">Denda Pembatalan</label>
                      <input type="text" class="form-control" name="denda_pembatalan" id="denda_pembatalan" value="{{$lokasi->denda_pembatalan}}">
                  </div>
              </div>
              <div class="col-12 col-md-4">
                  <div class="form-group">
                      <label for="denda_pengosongan">Denda Pengosongan</label>
                      <input type="text" class="form-control" name="denda_pengosongan" id="denda_pengosongan" value="{{$lokasi->denda_pengosongan}}">
                  </div>
              </div>
            </div>
  
            <div id="dynamic-input-nopd">
                @foreach ($lokasiNopd as $nopd)
                <div class="row align-items-center">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <input type="hidden" name="id_nopd[]" value={{$nopd->id}}>
                            <label for="nopd">Nopd</label>
                            <input type="text" class="form-control" name="nopd[]" id="nopd"
                                value="{{$nopd->nopd}}">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="bentuk">Bentuk</label>
                            <input type="text" class="form-control" name="bentuk[]" id="bentuk" value="{{$nopd->bentuk}}">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="ukuran">Ukuran</label>
                            <input type="text" class="form-control" name="ukuran[]"
                                id="ukuran" value="{{$nopd->ukuran}}">
                        </div>
                    </div>
                    <div class="col-1">
                        @if (!$loop->first)
                        <button type="button" class="btn btn-danger remove-row-nopd"><i class="fas fa-trash"></i></button>
                        @endif
                    </div>
                </div>
                @endforeach
          </div>
          <div class="mb-3 text-left">
              <button type="button" class="btn btn-primary add-row-nopd"><i class="fas fa-plus"></i></button>
          </div>

          
          <div id="dynamic-input-internet">
            @foreach ($internetServices as $internet)
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <input type="hidden" name="internet_id[]" value={{$internet->id}}>
                    <div class="form-group">
                        <label for="id_internet">ID internet</label>
                        <input type="text" class="form-control" name="id_internet[]" id="id_internet"
                            value="{{$internet->id_internet}}">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="speed_internet">Speed Internet</label>
                        <input type="text" class="form-control" name="speed_internet[]" id="speed_internet" value="{{$internet->speed_internet}}">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="harga_internet">Harga Internet</label>
                        <input type="text" class="form-control" name="harga_internet[]"
                            id="harga_internet" value="{{$internet->harga_internet}}">
                    </div>
                </div>
                <div class="col-1">
                    @if (!$loop->first)
                        <button type="button" class="btn btn-danger remove-row-internet"><i class="fas fa-trash"></i></button>
                    @endif
                </div>
            </div>
            @endforeach
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
        const handleEditForm = (formId) => {
                //get id form
                const form = $(`#${formId}`);
                //get id user
                const id = form.data('id');

                $.ajax({
                    url: `/lokasi/update/${id}`,
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
            };
        $('#editFormLokasi').on('submit', function(e){
          e.preventDefault();
          handleEditForm('editFormLokasi');
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
                        <input type="text" class="form-control" name="nopd[]" id="nopd"
                            required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="bentuk">Bentuk</label>
                        <input type="text" class="form-control" name="bentuk[]" id="bentuk" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="ukuran">Ukuran</label>
                        <input type="text" class="form-control" name="ukuran[]"
                            id="ukuran" required>
                    </div>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger remove-row-nopd"><i class="fas fa-trash"></i></button>
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
                        <input type="text" class="form-control" name="id_internet[]" id="id_internet"
                            required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="speed_internet">Speed Internet</label>
                        <input type="text" class="form-control" name="speed_internet[]" id="speed_internet" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="harga_internet">Harga Internet</label>
                        <input type="text" class="form-control" name="harga_internet[]"
                            id="harga_internet" required>
                    </div>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger remove-row-internet"><i class="fas fa-trash"></i></button>
                </div>
            `;
                    const container = document.getElementById('dynamic-input-internet');
                    container.appendChild(newRow);
                }
    });


        $(document).on('click', '.remove-row-nopd', function(e) {
                e.preventDefault();

                let row = $(this).closest('.row');
                let id = row.find('input[name="id_nopd[]"]').val();

                if (!id) {
                    row.remove();
                    return;
                }

                $.ajax({
                    url: "/delete-nopd/" + id, // Ganti dengan URL endpoint yang sesuai
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status) {
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

        $(document).on('click', '.remove-row-internet', function(e) {
                e.preventDefault();

                let row = $(this).closest('.row');
                let id = row.find('input[name="internet_id[]"]').val();

                if (!id) {
                    row.remove();
                    return;
                }

                $.ajax({
                    url: "/delete-internet/" + id, 
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status) {
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


       })

     
    </script>
@endsection


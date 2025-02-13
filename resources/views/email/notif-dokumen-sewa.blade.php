@component('mail::message')
# Peringatan Sertifikat Kedaluwarsa


Berikut adalah daftar sertifikat yang akan expired:

@foreach ($listSertifikat as $sertifikat)
- **No Sertifikat:** {{ $sertifikat->no_sertifikat }}  
  **Tanggal Kedaluwarsa:** {{ $sertifikat->tgl_akhir_sertifikat }}  
@endforeach

Silakan perpanjang sebelum tenggat waktu.

Terima kasih
@endcomponent

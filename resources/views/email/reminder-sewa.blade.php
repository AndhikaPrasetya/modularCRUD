<!DOCTYPE html>
<html>
<head>
    <title>Peringatan Sertifikat Kedaluwarsa</title>
</head>
<body>
    <h2>Halo</h2>
    <p>Berikut adalah daftar dokumen sewa menyewa yang akan kedaluwarsa:</p>
    <ul>
        
        @foreach($listSertifikat as $sertifikat)
            <li>
                <strong>No Sertifikat:</strong> {{ $sertifikat->no_sertifikat }} -
                <strong>Tanggal Kedaluwarsa:</strong> {{ $sertifikat->tgl_akhir_sertifikat }}
            </li>
        @endforeach
    </ul>

    <p>Silakan perpanjang sebelum tenggat waktu.</p>
    <p>Terima kasih.</p>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Pengajuan Cuti</title>
</head>
<body style="font-family:Arial,sans-serif;background:#f3f4f6;padding:24px;">
<div style="max-width:640px;margin:0 auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
    <div style="background:#1f2937;color:#ffffff;padding:16px 20px;font-weight:700;">SIMPEG - Update Status Cuti</div>
    <div style="padding:20px;line-height:1.6;color:#111827;">
        <p>Halo {{ $namaPegawai }},</p>
        <p>Pengajuan cuti Anda telah diproses dengan status:</p>

        <div style="display:inline-block;padding:6px 12px;border-radius:999px;background:{{ $statusColor }}1A;color:{{ $statusColor }};font-weight:700;">
            {{ $statusText }}
        </div>

        <table style="width:100%;border-collapse:collapse;font-size:14px;margin-top:14px;">
            <tr><td style="padding:6px 0;color:#6b7280;">Jenis Cuti</td><td style="padding:6px 0;font-weight:600;">{{ $jenisCuti }}</td></tr>
            <tr><td style="padding:6px 0;color:#6b7280;">Periode</td><td style="padding:6px 0;font-weight:600;">{{ $tanggalMulai }} s/d {{ $tanggalSelesai }}</td></tr>
            <tr><td style="padding:6px 0;color:#6b7280;">Durasi</td><td style="padding:6px 0;font-weight:600;">{{ $jumlahHari }} hari kerja</td></tr>
            <tr><td style="padding:6px 0;color:#6b7280;vertical-align:top;">Catatan Admin</td><td style="padding:6px 0;">{{ $catatanAdmin ?: '-' }}</td></tr>
        </table>

        <p style="margin-top:16px;">Terima kasih telah menggunakan SIMPEG.</p>
        <p style="color:#6b7280;font-size:12px;margin-top:20px;">Email ini dikirim otomatis oleh sistem SIMPEG.</p>
    </div>
</div>
</body>
</html>

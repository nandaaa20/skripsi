# ERD SIMPEG (Versi Implementasi Saat Ini)

Berikut ERD berdasarkan struktur migration yang saat ini digunakan di proyek.

```mermaid
erDiagram
    USERS {
        BIGINT id PK
        VARCHAR nip UK
        VARCHAR name
        VARCHAR email
        VARCHAR password
        VARCHAR role
        TIMESTAMP email_verified_at
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    PEGAWAI {
        BIGINT id PK
        BIGINT user_id FK
        VARCHAR nip UK
        VARCHAR nama_lengkap
        VARCHAR jabatan
        VARCHAR departemen
        ENUM jenis_kelamin
        DATE tanggal_lahir
        VARCHAR no_telepon
        TEXT alamat
        DATE tanggal_masuk
        ENUM status_kepegawaian
        INT kuota_cuti
        INT sisa_cuti
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    CUTI {
        BIGINT id PK
        VARCHAR nip FK
        DATE tanggal_mulai
        DATE tanggal_selesai
        INT jumlah_hari
        VARCHAR jenis_cuti
        TEXT alasan
        ENUM status
        TEXT catatan_admin
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    KEHADIRAN {
        BIGINT id PK
        VARCHAR nip FK
        DATE tanggal
        ENUM status
        TEXT keterangan
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    USERS ||--|| PEGAWAI : "1 user punya 1 pegawai"
    PEGAWAI ||--o{ CUTI : "1 pegawai punya banyak cuti"
    PEGAWAI ||--o{ KEHADIRAN : "1 pegawai punya banyak kehadiran"
```

## Catatan Relasi

- `pegawai.user_id` mereferensikan `users.id`.
- `cuti.nip` mereferensikan `pegawai.nip`.
- `kehadiran.nip` mereferensikan `pegawai.nip`.
- `users.nip` dan `pegawai.nip` sama-sama bernilai unik (business key), tetapi PK teknis tetap `id`.

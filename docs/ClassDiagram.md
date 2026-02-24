# Class Diagram SIMPEG (Versi Implementasi Saat Ini)

Berikut class diagram level implementasi (domain + application layer utama) berdasarkan kode yang ada di proyek.

```mermaid
classDiagram
    class User {
        +id: bigint
        +nip: string
        +name: string
        +email: string|null
        +role: string
        +pegawai()
    }

    class Pegawai {
        +id: bigint
        +user_id: bigint
        +nip: string
        +nama_lengkap: string
        +jabatan: string|null
        +departemen: string|null
        +status_kepegawaian: string
        +kuota_cuti: int
        +sisa_cuti: int
        +cuti()
        +kehadiran()
        +user()
    }

    class Cuti {
        +id: bigint
        +nip: string
        +tanggal_mulai: date
        +tanggal_selesai: date
        +jumlah_hari: int
        +jenis_cuti: string
        +alasan: text
        +status: enum
        +catatan_admin: text|null
        +pegawai()
    }

    class Kehadiran {
        +id: bigint
        +nip: string
        +tanggal: date
        +status: enum
        +keterangan: text|null
        +pegawai()
    }

    class PegawaiCutiController {
        +index()
        +create()
        +store(Request)
    }

    class AdminCutiController {
        +index()
        +show(Cuti)
        +updateStatus(Request, Cuti)
    }

    class AdminPegawaiController {
        +index(Request)
        +create()
        +store(Request)
        +show(Pegawai)
        +edit(Pegawai)
        +update(Request, Pegawai)
        +destroy(Pegawai)
        +resetPassword(Pegawai)
    }

    class PegawaiDashboardController {
        +index()
    }

    class RoleMiddleware {
        +handle(Request, Closure, role): Response
    }

    User "1" --> "1" Pegawai : hasOne/belongsTo
    Pegawai "1" --> "*" Cuti : hasMany/belongsTo
    Pegawai "1" --> "*" Kehadiran : hasMany/belongsTo

    PegawaiCutiController ..> Cuti : uses
    PegawaiCutiController ..> Pegawai : uses (auth user relation)
    AdminCutiController ..> Cuti : uses
    AdminCutiController ..> Pegawai : updates sisa_cuti
    AdminPegawaiController ..> Pegawai : CRUD
    AdminPegawaiController ..> User : sync akun
    PegawaiDashboardController ..> Cuti : statistik
    PegawaiDashboardController ..> Kehadiran : statistik
```

## Catatan
- Diagram ini menekankan kelas yang paling relevan dengan modul kepegawaian, cuti, dan kehadiran.
- `nip` adalah business key unik, sementara relasi teknis antartabel saat ini menggunakan `id`, `user_id`, dan `nip`.
- Komponen notifikasi email dikirim dari controller menggunakan `Mail` facade dengan template Blade HTML.

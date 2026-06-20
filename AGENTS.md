# TPLE006 Connect — Agent Instructions

**Stack:** Laravel 12 + MySQL + Tailwind CSS 3 + Alpine.js + vanilla JS. No Bootstrap.
**Status:** Scaffolded, Phase 1 complete. App at `http://kelas-ku.test`.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
```

- `composer create-project` fails if dir is non-empty. Use temp dir, then move files.
- `storage:link` required for `lampiran` / `foto` uploads.

## Environment

| Key | Value | Note |
|-----|-------|------|
| `DB_CONNECTION` | `mysql` | Laragon MySQL, root/password, database `kelas_ku` |
| `QUEUE_CONNECTION` | `database` | Uses `jobs` table |
| `CACHE_STORE` | `database` | Uses `cache` table |
| `SESSION_DRIVER` | `database` | Uses `sessions` table |
| `APP_LOCALE` / `APP_FAKER_LOCALE` | `id` / `id_ID` | Faker generates Indonesian data |
| `KELAS_KODE` | `TPLE006` | Required for registration (`kode_kelas` field) |

## Commands

| Command | Purpose |
|---------|---------|
| `php artisan test` | Run all tests |
| `php artisan test --filter=TestName` | Single test |
| `php artisan test --testsuite=Feature` | Feature tests only |
| `php artisan test --testsuite=Unit` | Unit tests only |
| `composer test` | `config:clear` then `php artisan test` |
| `php artisan migrate --seed` | Rebuild schema + seed |
| `php artisan migrate:fresh --seed` | Drop all, re-run, seed |
| `npm run build` | Rebuild Vite assets (Tailwind) |
| `composer dev` | `artisan serve` + queue:listen + pail + Vite concurrently |

## Testing

- Tests use `RefreshDatabase` + **SQLite in-memory** (`phpunit.xml`). No MySQL needed.
- Factory states: `Mahasiswa::factory()->admin()->create()`, `->administrator()->create()`, `->unverified()->create()`.

## Database

| Table | Notes |
|-------|-------|
| `mahasiswa` | User model. Table name = `mahasiswa` not `users`. Columns: `nama`, `nim` (unique), `email` (unique), `no_hp`, `password`, `foto`, `role` (string: `anggota`, `admin`, `administrator`), `angkatan` |
| `posts` | FK `user_id` → mahasiswa. `judul`, `isi`, `kategori` (varchar), `lampiran` (storage path) |
| `comments` | Self-referencing `parent_id` for nested replies |
| `reactions` | Unique `[post_id, user_id]`. `like` / `dislike` |
| `notifications` | `type` (string: `postingan_baru`, `komentar_baru`, `pengumuman_penting`), `status` (enum: `read`, `unread`) |
| `struktur_kelas` | Self-referencing `parent_id`. Columns: `jabatan`, `user_id`, `foto`, `urutan`, `deskripsi` |

## Routes

- **Guest:** `/login`, `/register` (requires `kode_kelas`), `/forgot-password`, `/reset-password`
- **Auth + verified:** `/dashboard`, `/feed`, `/posts/*`, `/mahasiswa`, `/mahasiswa/{mahasiswa}`, `/profile`, `/notifications`, `/struktur-kelas`
- **Admin (auth + `role:admin`):** `/admin/dashboard`, `/admin/mahasiswa/*`, `/admin/struktur/*`

Registration is open (requires valid `KELAS_KODE`). Admin panel for CRUD mahasiswa.

## Key Files

| File | Purpose |
|------|---------|
| `app/Models/Mahasiswa.php` | User model (Authenticatable). Has `isAdmin()`, `isAdministrator()`, `isAtLeast($role)` helpers |
| `app/Models/Post.php` | `HasMany` comments, reactions |
| `app/Models/StrukturKelas.php` | Self-referencing `parent()` / `children()` for class structure tree |
| `app/Http/Middleware/RoleMiddleware.php` | Hierarchy-based (`anggota < admin < administrator`). Usage: `middleware('role:admin')` |
| `routes/web.php` | All routes. Admin group under `/admin` prefix + `role:admin` |
| `database/factories/MahasiswaFactory.php` | Has `admin()`, `administrator()`, `unverified()` states |

## Default Accounts

| Role | Email | Password |
|------|-------|----------|
| Administrator | admin@tple006.com | password |

## Gotchas

- **Carbon pinned:** `nesbot/carbon:3.8.4` due to PHP 8.2. Audit ignore `PKSA-csyb-yc4p-mnbs`.
- **`name` → `nama`:** Breeze defaults use `name` field. All auth views/controllers/form requests use `nama`. Registration requires `nim`, `no_hp`, `angkatan` + `kode_kelas`.
- **Model:** `App\Models\Mahasiswa` (not `User`). Table = `mahasiswa`. Configured in `config/auth.php`.
- **Factory:** `MahasiswaFactory` (not `UserFactory`).
- **Queue:** `QUEUE_CONNECTION=database` — run `php artisan queue:work` for async jobs (or use `QUEUE_CONNECTION=sync` in `.env` for sync mode).
- **File uploads:** Stored under `storage/app/public/lampiran/` or `storage/app/public/foto/`. `storage:link` required.
- **Role enforcement:** `admin` role cannot assign `administrator` — only `administrator` can (enforced in `Admin\MahasiswaController`).

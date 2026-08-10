# Polsri Bank Sampah - Technical Architecture & Flow Report (Version 2 - Dynamic Point & Voucher Ecosystem)

This document provides a comprehensive technical analysis of **Version 2 (V2)** of the **Polsri Bank Sampah System**. It covers the UUID-based dynamic ecosystem, citizen registration & approval room (*Masyarakat* NIK/KTP verification), bank branch user accounts (*BankSampahUser*), QR ticket-based waste deposit with dynamic weight-to-point calculation, QR point-to-voucher redemption, eco-educational articles, and system conversion parameters.

---

## 1. V2 Executive Summary & Architecture

Version 2 introduces a modernized **UUID-based architecture** and a point/voucher-based gamification engine. It decouples the core system into distinct roles (Masyarakat, Admin Bank Sampah Branch, Super Admin) and replaces direct cash accounting with QR ticket verification and configurable point conversion rates (`settings`).

```
+-----------------------------------------------------------------------------------+
|                           POLSRI BANK SAMPAH - VERSION 2                          |
+-----------------------------------------------------------------------------------+
| • UUID Primary Key Architecture & HasUuids Model Booting                          |
| • Citizen Registration & Approval Room (NIK + Identity Photo Review)              |
| • Branch Bank Sampah User Management (Created by Super Admin)                     |
| • QR Code Setor Sampah Tickets & Dynamic Point Calculation                        |
| • QR Code Point-to-Voucher Redemption & Verification Engine                       |
| • Eco Articles & System Conversion Parameters (gram_per_point / point_per_voucher)|
+-----------------------------------------------------------------------------------+
```

---

## 2. V2 Data Flow Diagrams (DFD) - Yourdon + De Marco Style

In accordance with the **Yourdon + De Marco** methodology, system processes are shown as numbered circles/ovals, data stores as open rectangles (`D1`, `D2`, etc.), external entities as rectangles, and data flows as directional arrows.

### 2.1 Level 0: Context Diagram (V2 Boundary)

The Context Diagram defines the external boundary of the V2 system, illustrating how actors interact with **Polsri Bank Sampah V2 Engine [Process 0.0]**.

```mermaid
graph TD
    %% External Entities
    E1["Masyarakat Applicant / Citizen (User)"]
    E2["Admin Bank Sampah (Branch Agent)"]
    E3["Super Admin (System Owner)"]

    %% Process 0.0
    P0(("0.0<br>Polsri Bank Sampah<br>V2 Point & QR Engine"))

    %% Data Flows E1
    E1 -->|"Register Info, NIK, KTP Photo, Request Setor Ticket, Request Tukar Poin Ticket, QR Code Scan"| P0
    P0 -->|"Approval Room Status, Points & Vouchers Balance, QR Ticket Cards, Educational Articles"| E1

    %% Data Flows E2
    E2 -->|"Branch Login, Scan QR Code, Input Actual Waste Weight, Validate Setor Ticket, Validate Voucher Redemption"| P0
    P0 -->|"Scanned Ticket Details, Branch Daily Activity Summary, Deposit Verification Status"| E2

    %% Data Flows E3
    E3 -->|"Review & Approve Applicant NIK/KTP, Create Branch Office Accounts, Manage Articles, Update Conversion Rates"| P0
    P0 -->|"Pending Verification Queue, Branch Performance, System Logs, System Parameters Summary"| E3
```

---

### 2.2 Level 1: Subsystem Process Decomposition (V2)

Level 1 partitions **Process 0.0** into five core functional sub-systems for V2.

```mermaid
graph TD
    %% External Entities
    E1["Masyarakat (User)"]
    E2["Admin Bank Sampah"]
    E3["Super Admin"]

    %% Data Stores
    D1[("D1: users & masyarakats")]
    D2[("D2: banksampahusers")]
    D3[("D3: tiketsetorsampahs & settings")]
    D4[("D4: tikettukarpoins")]
    D5[("D5: artikels")]

    %% Level 1 Processes
    P1(("1.0<br>Citizen Onboarding &<br>SuperAdmin Approval Room"))
    P2(("2.0<br>Bank Branch Office<br>Account Management"))
    P3(("3.0<br>QR Ticket Setor &<br>Dynamic Point Calculation"))
    P4(("4.0<br>QR Point-to-Voucher<br>Redemption Engine"))
    P5(("5.0<br>Eco Articles &<br>System Parameter Settings"))

    %% Data Flows P1
    E1 -->|"Submit Reg Info, NIK & KTP Photo"| P1
    E3 -->|"Review & Approve Verification"| P1
    P1 <--> D1

    %% Data Flows P2
    E3 -->|"Create & Manage Branch Accounts"| P2
    E2 -->|"Branch Agent Authentication"| P2
    P2 <--> D2

    %% Data Flows P3
    E1 -->|"Generate Setor Ticket"| P3
    E2 -->|"Scan QR & Input Actual Weight"| P3
    P3 <--> D3
    P3 -->|"Update Points & Gramasi"| D1

    %% Data Flows P4
    E1 -->|"Generate Point Redemption Ticket"| P4
    E2 -->|"Scan QR & Validate Voucher Exchange"| P4
    P4 <--> D4
    P4 -->|"Deduct Points / Credit Vouchers"| D1

    %% Data Flows P5
    E3 -->|"CRUD Articles & Conversion Rates"| P5
    E1 -->|"View Eco Educational Articles"| P5
    P5 <--> D5
```

---

### 2.3 Level 2: Detailed Process Flow (V2 QR Setor & Dynamic Calculation)

```mermaid
graph TD
    E1["Masyarakat"] -->|"1. Generate Ticket (berat_sampah)"| P3_1(("3.1<br>Create Pending<br>QR Ticket"))
    P3_1 -->|"INSERT status: 'Menunggu', UUID & QR Code"| D3[("D3: tiketsetorsampahs")]
    
    E2["Admin Bank Sampah"] -->|"2. Scan QR Code"| P3_2(("3.2<br>Fetch & Display<br>Ticket Detail"))
    D3 -->|"Return Ticket Detail"| P3_2
    
    E2 -->|"3. Input Actual Weight (berat_sampah_actual)"| P3_3(("3.3<br>Calculate Points &<br>Update Balance"))
    D_Settings[("D: settings")] -->|"Fetch gram_per_point Rate"| P3_3
    
    P3_3 -->|"Calculate: points = floor(weight / gram_per_point)"| P3_3
    P3_3 -->|"UPDATE tiketsetorsampahs status = 'Selesai'"| D3
    P3_3 -->|"UPDATE masyarakats (poin += points, total_gramasi += weight, total_selesai += 1)"| D1[("D1: masyarakats")]
    P3_3 -->|"4. Return Completion Summary"| E2
```

---

## 3. V2 Entity Relationship Diagram (ERD) & Data Dictionary

### 3.1 Visual Entity Relationship Diagram (V2 Mermaid ERD)

Below is the complete V2 database structure illustrating UUID primary keys, foreign keys, data types, and cardinalities.

```mermaid
erDiagram
    users ||--o| masyarakats : "has profile (1:1)"
    users ||--o{ users : "registered_by (1:N)"
    users ||--o{ banksampahusers : "created_by (1:N)"
    users ||--o{ masyarakats : "approved_by (1:N)"

    masyarakats ||--o{ tiketsetorsampahs : "generates deposit ticket (1:N)"
    banksampahusers ||--o{ tiketsetorsampahs : "validates deposit ticket (1:N)"

    masyarakats ||--o{ tikettukarpoins : "generates voucher ticket (1:N)"
    banksampahusers ||--o{ tikettukarpoins : "validates voucher ticket (1:N)"

    users {
        bigint id PK
        string user_code
        string name
        string username
        string email
        string password
        bigint registered_by FK
        string avatar
        string phone
        string no_rekening
        string bank
        string address
    }

    masyarakats {
        uuid masyarakat_id PK
        bigint user_id FK
        string nik
        bigint approved_by FK
        string identity_photo
        enum gender
        enum verification
        int poin
        int voucher
        int total_gramasi
        int total_selesai
    }

    banksampahusers {
        uuid banksampah_id PK
        bigint created_by FK
        string username
        string password
        string nama_bank_sampah
        text alamat
        string kecamatan
        string jam_operasional
        string nomor_telepon
        text deskripsi
    }

    tiketsetorsampahs {
        uuid tiketsampah_id PK
        uint tiketsampah_inc
        uuid masyarakat_id FK
        uuid banksampah_id FK
        int berat_sampah
        int berat_sampah_actual
        int poin
        string qr_code_id
        enum status
    }

    tikettukarpoins {
        uuid tiketpoin_id PK
        uint tiketpoin_inc
        uuid masyarakat_id FK
        uuid banksampah_id FK
        int poin
        string qr_code_id
        enum status
    }

    artikels {
        uuid artikel_id PK
        string judul_artikel
        string gambar_artikel
        text isi_artikel
    }

    settings {
        bigint settings_id PK
        int gram_per_point
        int point_per_voucher
    }
```

---

### 3.2 V2 Data Dictionary (7 Eloquent Models & Database Schemas)

| Model Class Name | DB Table Name | Primary Key | Attributes / `$fillable` | Data Types & Defaults | Key Eloquent Relationships |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **`Masyarakat`** | `masyarakats` | `masyarakat_id` (UUID) | `masyarakat_id`, `user_id`, `nik`, `approved_by`, `identity_photo`, `gender`, `verification`, `poin`, `voucher`, `total_gramasi`, `total_selesai` | UUID PK, `gender` enum, `verification` enum default 'Menunggu', `poin`/`voucher`/`total_gramasi`/`total_selesai` default 0 | - `user()`: belongsTo `User`<br>- `approver()`: belongsTo `User`<br>- `tiketSetorSampah()`: hasMany `TiketSetorSampah`<br>- `tiketTukarPoin()`: hasMany `TiketTukarPoin` |
| **`BankSampahUser`** | `banksampahusers` | `banksampah_id` (UUID) | `banksampah_id`, `created_by`, `username`, `password`, `nama_bank_sampah`, `alamat`, `kecamatan`, `jam_operasional`, `nomor_telepon`, `deskripsi` | UUID PK, `created_by` FK to `users.id`, `password` hidden | - `creator()`: belongsTo `User`<br>- `tiketSetorSampah()`: hasMany `TiketSetorSampah`<br>- `tiketTukarPoin()`: hasMany `TiketTukarPoin` |
| **`TiketSetorSampah`**| `tiketsetorsampahs` | `tiketsampah_id` (UUID)| `tiketsampah_id`, `tiketsampah_inc`, `masyarakat_id`, `banksampah_id`, `berat_sampah`, `berat_sampah_actual`, `poin`, `qr_code_id`, `status` | UUID PK, auto incrementing `tiketsampah_inc`, `status` enum ('Menunggu','Selesai') | - `masyarakat()`: belongsTo `Masyarakat`<br>- `bankSampahUser()`: belongsTo `BankSampahUser` |
| **`TiketTukarPoin`** | `tikettukarpoins` | `tiketpoin_id` (UUID) | `tiketpoin_id`, `tiketpoin_inc`, `masyarakat_id`, `banksampah_id`, `poin`, `qr_code_id`, `status` | UUID PK, auto incrementing `tiketpoin_inc`, `status` enum ('Menunggu','Selesai') | - `masyarakat()`: belongsTo `Masyarakat`<br>- `bankSampahUser()`: belongsTo `BankSampahUser` |
| **`Artikel`** | `artikels` | `artikel_id` (UUID) | `artikel_id`, `judul_artikel`, `gambar_artikel`, `isi_artikel` | UUID PK | None |
| **`Setting`** | `settings` | `settings_id` (bigint)| `gram_per_point`, `point_per_voucher` | Bigint PK, `gram_per_point` int, `point_per_voucher` int | System conversion rates |
| **`User`** (V2 Ext) | `users` | `id` (bigint) | `registered_by` | FK to `users.id` | - `masyarakat()`: hasOne `Masyarakat`<br>- `admin_banksampah()`: hasOne `BankSampahUser` |

---

## 4. V2 Core Application Flows (Sequence Diagrams)

### Flow 1: V2 Citizen (Masyarakat) Registration & Super Admin Approval Room

This sequence illustrates V2 citizen onboarding with NIK verification, KTP photo upload, waiting room hold, and Super Admin review.

```mermaid
sequenceDiagram
    autonumber
    actor User as Citizen Applicant
    actor SA as Super Admin
    participant Auth as AuthController / SuperAdminController
    participant DB as MySQL Database

    User->>Auth: GET /register
    Auth-->>User: Render V2 registration form (Name, NIK, Phone, KTP photo)

    User->>Auth: POST /register (Name, Email, NIK, Password, Identity Photo)
    Auth->>DB: INSERT INTO users (name, email, password, registered_by = NULL)
    Auth->>DB: Move uploaded KTP photo & INSERT INTO masyarakats (user_id, nik, identity_photo, verification = 'Menunggu')
    DB-->>Auth: Records saved
    Auth-->>User: Redirect to /v2/waiting (Waiting Room)

    loop Polling status in Waiting Room
        User->>Auth: GET /v2/waiting
        Auth->>DB: SELECT verification FROM masyarakats WHERE user_id = current_user
        DB-->>Auth: Return verification state
        alt Verification == 'Menunggu'
            Auth-->>User: Display "Akun Anda sedang ditinjau oleh Super Admin"
        else Verification == 'Disetujui'
            Auth-->>User: Redirect to /v2/dashboard
        else Verification == 'Ditolak'
            Auth-->>User: Display "Pendaftaran ditolak"
        end
    end

    SA->>Auth: GET /v2/super-admin/masyarakat
    Auth->>DB: SELECT * FROM masyarakats WHERE verification = 'Menunggu'
    DB-->>Auth: Return queue list
    Auth-->>SA: Display pending applicants queue

    SA->>Auth: POST /v2/super-admin/masyarakat/{id}/review-process (action: 'Disetujui' / 'Ditolak')
    Auth->>DB: UPDATE masyarakats SET verification = action, approved_by = super_admin_id WHERE masyarakat_id = $id
    DB-->>Auth: Record updated
    Auth-->>SA: Redirect to list with status updated
```

---

### Flow 2: V2 Super Admin Bank Sampah Branch Creation Flow

This flow describes how a Super Admin creates a new Bank Sampah branch user account.

```mermaid
sequenceDiagram
    autonumber
    actor SA as Super Admin
    participant SACtrl as SuperAdminController
    participant DB as MySQL Database

    SA->>SACtrl: GET /v2/super-admin/bank-sampah/create
    SACtrl-->>SA: Render branch account creation form

    SA->>SACtrl: POST /v2/super-admin/bank-sampah (nama_bank_sampah, username, password, alamat, kecamatan, phone)
    SACtrl->>DB: Generate UUID for banksampah_id
    SACtrl->>DB: Hash password & INSERT INTO banksampahusers (created_by = super_admin_id, username, password, nama_bank_sampah, ...)
    DB-->>SACtrl: Branch account created
    SACtrl-->>SA: Redirect to /v2/super-admin/bank-sampah with success alert
```

---

### Flow 3: V2 QR Ticket Waste Deposit & Dynamic Point Calculation Flow

This flow describes V2 ticket-based waste deposit where points are calculated dynamically based on system settings.

```mermaid
sequenceDiagram
    autonumber
    actor Nasabah as Masyarakat (User)
    actor Admin as Admin Bank Sampah Branch
    participant SetorCtrl as TiketsetorsampahController
    participant DB as MySQL Database

    Nasabah->>SetorCtrl: GET /tiket-sampah/create
    SetorCtrl->>DB: SELECT * FROM banksampahusers
    DB-->>SetorCtrl: Return branch list
    SetorCtrl-->>Nasabah: Render ticket request form

    Nasabah->>SetorCtrl: POST /tiket-sampah (banksampah_id, berat_sampah)
    SetorCtrl->>DB: Generate UUID & unique QR code string
    SetorCtrl->>DB: INSERT INTO tiketsetorsampahs (masyarakat_id, banksampah_id, berat_sampah, qr_code_id, status = 'Menunggu')
    DB-->>SetorCtrl: Ticket saved
    SetorCtrl-->>Nasabah: Display Ticket Card with QR Code

    Admin->>SetorCtrl: GET /v2/admin/scan (Scan QR / Input QR ID)
    Admin->>SetorCtrl: GET /v2/admin/tiket-setor/{id}
    SetorCtrl->>DB: SELECT * FROM tiketsetorsampahs WHERE qr_code_id = $qrCode
    DB-->>SetorCtrl: Return pending ticket details

    Admin->>SetorCtrl: PUT /v2/admin/tiket-setor/{id}/validate (berat_sampah_actual)
    SetorCtrl->>DB: SELECT gram_per_point FROM settings LIMIT 1
    DB-->>SetorCtrl: Return conversion rate (e.g. 1000 gram = 1 point)
    
    SetorCtrl->>SetorCtrl: Compute points = floor(berat_sampah_actual / gram_per_point)
    SetorCtrl->>DB: UPDATE tiketsetorsampahs SET berat_sampah_actual = weight, poin = computed_points, status = 'Selesai' WHERE tiketsampah_id = $id
    SetorCtrl->>DB: UPDATE masyarakats SET poin = poin + computed_points, total_gramasi = total_gramasi + weight, total_selesai = total_selesai + 1 WHERE masyarakat_id = $masyarakatId
    DB-->>SetorCtrl: Commit updates
    SetorCtrl-->>Admin: Redirect to admin ticket index with success summary
```

---

### Flow 4: V2 QR Point-to-Voucher Exchange & Redemption Flow

This sequence covers redeeming earned points for digital vouchers via QR ticket validation.

```mermaid
sequenceDiagram
    autonumber
    actor Nasabah as Masyarakat (User)
    actor Admin as Admin Bank Sampah Branch
    participant PoinCtrl as TikettukarpoinController
    participant DB as MySQL Database

    Nasabah->>PoinCtrl: GET /tiket-poin/create
    PoinCtrl->>DB: SELECT poin FROM masyarakats WHERE user_id = current_user
    PoinCtrl->>DB: SELECT point_per_voucher FROM settings LIMIT 1
    DB-->>PoinCtrl: Return current points & exchange rate
    PoinCtrl-->>Nasabah: Render point redemption form

    Nasabah->>PoinCtrl: POST /tiket-poin (banksampah_id, poin_requested)
    alt Requested points > user available points
        PoinCtrl-->>Nasabah: Return validation error ("Poin Anda tidak cukup")
    else Points sufficient
        PoinCtrl->>DB: Generate UUID & QR code string
        PoinCtrl->>DB: INSERT INTO tikettukarpoins (masyarakat_id, banksampah_id, poin = requested, qr_code_id, status = 'Menunggu')
        DB-->>PoinCtrl: Redemption ticket saved
        PoinCtrl-->>Nasabah: Display Voucher Ticket with QR Code
    end

    Admin->>PoinCtrl: PUT /v2/admin/tiket-poin/{id}/validate
    PoinCtrl->>DB: SELECT * FROM tikettukarpoins WHERE tiketpoin_id = $id AND status = 'Menunggu'
    DB-->>PoinCtrl: Return ticket detail
    PoinCtrl->>DB: SELECT point_per_voucher FROM settings LIMIT 1
    DB-->>PoinCtrl: Return voucher conversion rate (e.g. 100 points = 1 voucher)

    PoinCtrl->>PoinCtrl: Calculate vouchers_earned = floor(ticket.poin / point_per_voucher)
    PoinCtrl->>DB: UPDATE tikettukarpoins SET status = 'Selesai' WHERE tiketpoin_id = $id
    PoinCtrl->>DB: UPDATE masyarakats SET poin = poin - ticket.poin, voucher = voucher + vouchers_earned WHERE masyarakat_id = $masyarakatId
    DB-->>PoinCtrl: Commit transaction
    PoinCtrl-->>Admin: Redirect with redemption confirmation
```

---

### Flow 5: V2 Eco Educational Article & Conversion Rate Management Flow

This sequence describes Super Admin management of eco educational articles and system conversion parameters.

```mermaid
sequenceDiagram
    autonumber
    actor SA as Super Admin
    participant SettingCtrl as SettingController
    participant ArtikelCtrl as ArtikelController
    participant DB as MySQL Database

    SA->>SettingCtrl: GET /v2/super-admin/pengaturan
    SettingCtrl->>DB: SELECT * FROM settings LIMIT 1
    DB-->>SettingCtrl: Return current rates (gram_per_point, point_per_voucher)
    SettingCtrl-->>SA: Render conversion settings form

    SA->>SettingCtrl: PUT /v2/super-admin/pengaturan (gram_per_point, point_per_voucher)
    SettingCtrl->>DB: UPDATE settings SET gram_per_point = $gram, point_per_voucher = $voucher
    DB-->>SettingCtrl: Settings updated
    SettingCtrl-->>SA: Redirect back with success message

    SA->>ArtikelCtrl: POST /v2/super-admin/edukasi (judul_artikel, gambar_artikel, isi_artikel)
    ArtikelCtrl->>DB: Generate UUID for artikel_id
    ArtikelCtrl->>DB: INSERT INTO artikels (artikel_id, judul_artikel, gambar_artikel, isi_artikel)
    DB-->>ArtikelCtrl: Article saved
    ArtikelCtrl-->>SA: Redirect to articles index with success banner
```

---

## 5. V2 Controller Execution & Method Mapping Matrix

Below is a complete matrix mapping all V2 controllers to routed endpoints, middleware permissions, and database operations.

```
+------------------------------+-------------------------------------+-----------------------------+------------------------------------+
| Controller Class             | Endpoint Route Prefix               | Middleware / Role           | Key Responsibilities & Methods     |
+------------------------------+-------------------------------------+-----------------------------+------------------------------------+
| AuthController (V2)          | /login, /register, /v2/waiting      | auth:web                    | login(), register(), profile(),    |
|                              |                                     |                             | waiting room status polling        |
| MasyarakatController         | /v2/masyarakats                     | auth:web                    | Profile & NIK verification         |
| BanksampahuserController     | /v2/banksampahusers                 | auth:web                    | Branch office lookup & details     |
| TiketsetorsampahController   | /tiket-sampah, /v2/admin/tiket-setor| auth:web, Admin Bank Sampah | indexV2(), create(), store(),      |
|                              |                                     |                             | adminIndex(), adminValidate()      |
| TikettukarpoinController     | /tiket-poin, /v2/admin/tiket-poin  | auth:web, Admin Bank Sampah | indexV2(), create(), store(),      |
|                              |                                     |                             | adminIndex(), adminValidate()      |
| SuperAdminController         | /v2/super-admin/*                   | middleware:role:Super Admin | dashboard(), masyarakatIndex(),    |
|                              |                                     |                             | bankSampahStore(), reviewProcess() |
| ArtikelController            | /v2/artikels, /v2/super-admin/edukasi| auth:web, Super Admin       | Educational news CRUD              |
| SettingController            | /v2/settings, /v2/super-admin/pengaturan| auth:web, Super Admin  | index(), update() conversion rates |
| DashboardController (V2)     | /v2/dashboard, /v2/admin/dashboard  | auth:web                    | indexV2(), adminBankSampahDashboard|
+------------------------------+-------------------------------------+-----------------------------+------------------------------------+
```

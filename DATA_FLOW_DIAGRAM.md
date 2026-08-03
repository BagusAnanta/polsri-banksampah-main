# BANK SAMPAH - DATA FLOW DIAGRAM ANALYSIS
**Generated:** August 3, 2026  
**Project:** Polsri Bank Sampah Management System  
**Framework:** Laravel 8+ with Spatie Permissions

---

## 1. HIGH-LEVEL SYSTEM ARCHITECTURE

```
┌─────────────────────────────────────────────────────────────────┐
│                     EXTERNAL USERS                              │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐          │
│  │  Masyarakat  │  │ Admin Bank   │  │ Super Admin  │          │
│  │   (Public)   │  │   Sampah     │  │   (Staff)    │          │
│  └──────────────┘  └──────────────┘  └──────────────┘          │
└────────────────────────┬────────────────────────────────────────┘
                         │
                    HTTPS/Web
                         │
┌────────────────────────▼────────────────────────────────────────┐
│              LARAVEL WEB APPLICATION                            │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │  Routes (web.php)                                          │ │
│  │  - Auth routes (/login, /register)                         │ │
│  │  - Dashboard routes (/v2/dashboard)                        │ │
│  │  - Admin routes (/v2/admin/*)                              │ │
│  │  - SA routes (/v2/super-admin/*)                           │ │
│  └────────────────────────────────────────────────────────────┘ │
│                         │                                        │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │  Middleware Stack                                          │ │
│  │  - auth:web → Authenticate.php                             │ │
│  │  - role:* → Spatie\Permission\Middleware\RoleMiddleware   │ │
│  │  - csrf → VerifyCsrfToken                                  │ │
│  └────────────────────────────────────────────────────────────┘ │
│                         │                                        │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │  Controllers                                               │ │
│  │  - AuthController (login, register)                        │ │
│  │  - DashboardController (dashboards)                        │ │
│  │  - TiketsetorsampahController (deposits)                   │ │
│  │  - TikettukarpoinController (redemptions)                  │ │
│  │  - ArtikelController (articles)                            │ │
│  │  - SuperAdminController (admin)                            │ │
│  └────────────────────────────────────────────────────────────┘ │
│                         │                                        │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │  Models (Business Logic)                                   │ │
│  │  - User, Masyarakat, BankSampahUser                         │ │
│  │  - TiketSetorSampah, TiketTukarPoin                        │ │
│  │  - Artikel, Setting                                        │ │
│  └────────────────────────────────────────────────────────────┘ │
│                         │                                        │
└────────────────────────┬────────────────────────────────────────┘
                         │
              Database Driver (PDO)
                         │
┌────────────────────────▼────────────────────────────────────────┐
│         DATABASE (MySQL/SQLite)                                 │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │  Core Tables                                               │ │
│  │  - users, roles, permissions, model_has_roles             │ │
│  │  - masyarakats, banksampahusers                            │ │
│  │  - tiketsetorsampahs, tikettukarpoins                      │ │
│  │  - artikels, settings                                      │ │
│  └────────────────────────────────────────────────────────────┘ │
│                                                                  │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │  File Storage (public/ui/images/)                          │ │
│  │  - masyarakat/ → KTP photos                                │ │
│  │  - artikel/ → Article images                               │ │
│  │  - profile/ → User avatars                                 │ │
│  └────────────────────────────────────────────────────────────┘ │
└────────────────────────────────────────────────────────────────┘
```

---

## 2. AUTHENTICATION FLOW

```
START (User visits /login)
│
├─► [1] Display Login Form
│   │   - resources/views/v2/auth/login.blade.php
│   │
│   └─► USER ENTERS: username/NIK + password
│
├─► [2] POST /login → AuthController::login()
│   │   - Validate input (required fields)
│   │   - Query users table WHERE username OR nik = input
│   │
│   ├─► NOT FOUND
│   │   └─► return redirect('/login')->with('error')
│   │
│   └─► FOUND → Verify password hash
│       │   - Auth::attempt(['username' => $username, 'password' => $password])
│       │
│       ├─► INVALID PASSWORD
│       │   └─► return redirect('/login')->with('error')
│       │
│       └─► PASSWORD VALID
│           │
│           ├─► [3] Load User Relations
│           │   - $user = User::with('roles', 'masyarakat')->find($id)
│           │
│           ├─► [4] Verify Masyarakat Status (CURRENTLY DISABLED)
│           │   │   - if $user->masyarakat->verification === 'Menunggu'
│           │   │   - should redirect to /v2/waiting (commented out)
│           │   │
│           │   └─► [SECURITY GAP] Unverified users can access dashboard
│           │
│           ├─► [5] Session Regeneration
│           │   │   - session()->regenerate()
│           │   │
│           │   └─► Session ID changed for security
│           │
│           └─► [6] Role-based Redirect
│               │   - Check user roles via Spatie\Permission
│               │   - Store role info in session
│               │
│               ├─► IF role = 'Super Admin'
│               │   └─► redirect('/v2/sa/dashboard')
│               │
│               ├─► IF role = 'Admin Bank Sampah'
│               │   └─► redirect('/v2/admin/dashboard')
│               │
│               └─► IF role = 'Masyarakat'
│                   └─► redirect('/v2/dashboard')

END
```

---

## 3. USER REGISTRATION FLOW

```
START (User visits /register)
│
├─► [1] Display Registration Form
│   │   - resources/views/v2/auth/register.blade.php
│   │   - Form fields: name, email, username, NIK, gender, password, KTP photo
│   │
│   └─► USER SUBMITS DATA
│
├─► [2] POST /register → AuthController::register()
│   │   - Validate input:
│   │     * name: required|string
│   │     * email: required|email|unique:users
│   │     * username: required|unique:users
│   │     * nik: required|16 digits|unique:masyarakats
│   │     * gender: required|enum:Laki-laki,Perempuan
│   │     * password: required|confirmed|min:8
│   │     * identity_photo: required|image|max:2048
│   │
│   ├─► VALIDATION FAILS
│   │   └─► return redirect()->back()->withErrors($validator)
│   │
│   └─► VALIDATION PASSES
│       │
│       ├─► [3] START DB TRANSACTION (NO - missing!)
│       │   └─► [BUG] Partial writes if error occurs
│       │
│       ├─► [4] Upload KTP Photo
│       │   │   - File location: public/ui/images/masyarakat/
│       │   │   - Filename: time() . '_' . uniqid() . '.' . extension
│       │   │   - Stored path: $filename (relative)
│       │   │
│       │   └─► [SECURITY] No virus scanning
│       │
│       ├─► [5] Create User Record
│       │   │   INSERT INTO users
│       │   │   (id, name, email, username, avatar, password, created_at, updated_at)
│       │   │
│       │   └─► $userId = User::create([...])
│       │
│       ├─► [6] Assign 'Masyarakat' Role
│       │   │   - $user->assignRole('Masyarakat')
│       │   │   - INSERT INTO model_has_roles
│       │   │
│       │   └─► Role assignment recorded
│       │
│       ├─► [7] Create Masyarakat Profile
│       │   │   INSERT INTO masyarakats
│       │   │   (masyarakat_id, user_id, nik, identity_photo, gender, 
│       │   │    verification, poin, voucher, total_gramasi, total_selesai,
│       │   │    created_at, updated_at)
│       │   │
│       │   ├─► masyarakat_id: UUID (auto-generated)
│       │   ├─► user_id: FK → users.id
│       │   ├─► verification: 'Menunggu' (default)
│       │   ├─► poin: 0 (default)
│       │   ├─► voucher: 0 (default)
│       │   └─► total_gramasi, total_selesai: 0 (default)
│       │
│       ├─► [8] COMMIT TRANSACTION (NO - missing!)
│       │
│       └─► [9] Redirect & Flash Success
│           └─► return redirect('/v2/waiting')->with('success', 'Registration complete')

END (User now in verification queue)
```

---

## 4. TRASH DEPOSIT FLOW (Setor Sampah)

```
START (Masyarakat user on /tiket-sampah)
│
├─► [1] GET /tiket-sampah → TiketsetorsampahController::indexV2()
│   │   - Auth Check: user must be authenticated
│   │   - Load: $masyarakat = Masyarakat::where('user_id', $user->id)->first()
│   │
│   ├─► NO MASYARAKAT RECORD
│   │   └─► redirect('/login') - [BUG] Should show error
│   │
│   └─► MASYARAKAT EXISTS
│       │
│       ├─► [2] Query Deposit Tickets
│       │   │   SELECT * FROM tiketsetorsampahs
│       │   │   WHERE masyarakat_id = ? AND deleted_at IS NULL
│       │   │   ORDER BY created_at DESC
│       │   │
│       │   └─► [BUG] No pagination - all records loaded in memory
│       │
│       ├─► [3] Query Settings
│       │   │   SELECT * FROM settings LIMIT 1
│       │   │   - gram_per_point: default 10
│       │   │
│       │   └─► Used for display calculations only
│       │
│       └─► [4] Render List View
│           └─► resources/views/v2/user/masyarakat/tiket-sampah-index.blade.php

USER CLICKS "CREATE DEPOSIT"
│
├─► [5] GET /tiket-sampah/create
│   │   → TiketsetorsampahController::create()
│   │   - Load masyarakat (same check)
│   │   - Load bank sampah list
│   │   - Load settings
│   │
│   └─► Render form: resources/views/v2/user/masyarakat/tiket-sampah-create.blade.php

USER SUBMITS FORM
│
├─► [6] POST /tiket-sampah → TiketsetorsampahController::store()
│   │   - Validate input:
│   │     * masyarakat_id: required|exists:masyarakats
│   │     * banksampah_id: required|exists:banksampahusers
│   │     * berat_sampah: required|integer|min:1
│   │
│   ├─► VALIDATION FAILS
│   │   └─► return redirect()->back()->withErrors()
│   │
│   └─► VALIDATION PASSES
│       │
│       ├─► [7] Query Settings
│       │   │   $setting = Setting::first()
│       │   │   $gramPerPoint = $setting->gram_per_point ?? 10
│       │   │
│       │   └─► Get conversion rate
│       │
│       ├─► [8] Calculate Points
│       │   │   $poin = floor($berat_sampah / $gramPerPoint)
│       │   │   Example: 150 grams ÷ 10 = 15 points
│       │   │
│       │   └─► Point value calculated
│       │
│       ├─► [9] Generate QR Code ID
│       │   │   $qrCodeId = 'TS-' . Str::random(10)
│       │   │   Example: 'TS-aBcDeFgHiJ'
│       │   │
│       │   └─► [ISSUE] Not actual QR code, just string
│       │
│       ├─► [10] Generate Auto-Increment Counter
│       │   │   $tiketsampah_inc = max(tiketsampah_inc) + 1
│       │   │
│       │   └─► [BUG] Race condition in concurrent requests
│       │
│       ├─► [11] Create Ticket Record
│       │   │   INSERT INTO tiketsetorsampahs
│       │   │   (tiketsampah_id, tiketsampah_inc, masyarakat_id, banksampah_id,
│       │   │    berat_sampah, poin, qr_code_id, status, created_at)
│       │   │
│       │   ├─► tiketsampah_id: UUID
│       │   ├─► status: 'Menunggu' (default)
│       │   ├─► berat_sampah_actual: NULL (to be filled by admin)
│       │   └─► Created ticket ready for validation
│       │
│       └─► [12] Return Success Response
│           └─► return redirect('/tiket-sampah')->with('success')

BANK STAFF VIEWS TICKET
│
├─► [13] Admin accesses /v2/admin/tiket
│   │   → Routes to: admin tiket-index view
│   │   [INCOMPLETE] View should list all pending tickets
│   │
│   └─► [BUG] Data not being passed to view

ADMIN SCANS QR CODE (Alternative flow)
│
├─► [14] GET /v2/admin/scan
│   │   → admin scan.blade.php
│   │   - QR Scanner initialized (html5-qrcode@2.1.5)
│   │   - User points camera at QR code
│   │
│   ├─► QR SCANNED
│   │   │   - JavaScript captures: decodedText = 'TS-aBcDeFgHiJ'
│   │   │
│   │   └─► [SECURITY BUG] Unvalidated redirect:
│   │       window.location.href = `/admin/tiket/${decodedText}`
│   │
│   └─► [15] GET /admin/tiket/{qr_value}
│       │   - Should validate UUID format
│       │   - Should check ticket exists
│       │   - [MISSING] No validation logic
│       │
│       └─► Redirect to ticket detail or 404

ADMIN VALIDATES DEPOSIT
│
├─► [16] GET /v2/admin/tiket/{id}/edit (or show view)
│   │   - Load ticket: $ticket = TiketSetorSampah::findOrFail($id)
│   │   - Load masyarakat: $masyarakat = $ticket->masyarakat
│   │
│   └─► Display form with fields to verify

ADMIN SUBMITS VALIDATION
│
├─► [17] PUT /v2/admin/tiket/{id} → TiketsetorsampahController::adminValidate()
│   │   - Validate input:
│   │     * berat_sampah_actual: required|integer|min:1
│   │     * status: required|in:Selesai,Ditolak
│   │
│   ├─► VALIDATION FAILS
│   │   └─► return redirect()->back()->withErrors()
│   │
│   └─► VALIDATION PASSES
│       │
│       ├─► [18] Query Settings
│       │   │   $setting = Setting::first()
│       │   │   $gramPerPoint = $setting->gram_per_point
│       │   │
│       │   └─► Get conversion rate
│       │
│       ├─► [19] Recalculate Points Based on Actual Weight
│       │   │   $newPoin = floor($berat_sampah_actual / $gramPerPoint)
│       │   │   Example: 120 actual grams ÷ 10 = 12 points
│       │   │
│       │   └─► Points may differ from user's estimate
│       │
│       ├─► [20] Check Status
│       │   │
│       │   ├─► IF status = 'Ditolak' (Rejected)
│       │   │   │   - Update ticket status: 'Ditolak'
│       │   │   │   - DO NOT add points to masyarakat
│       │   │   │
│       │   │   └─► Ticket rejected, no points credited
│       │   │
│       │   └─► IF status = 'Selesai' (Completed)
│       │       │
│       │       ├─► [21] Update Ticket
│       │       │   │   UPDATE tiketsetorsampahs SET
│       │       │   │   berat_sampah_actual = ?,
│       │       │   │   poin = ?,
│       │       │   │   status = 'Selesai',
│       │       │   │   updated_at = now()
│       │       │   │   WHERE tiketsampah_id = ?
│       │       │   │
│       │       │   └─► [BUG] Not wrapped in transaction
│       │       │
│       │       ├─► [22] Update Masyarakat Profile
│       │       │   │   UPDATE masyarakats SET
│       │       │   │   total_gramasi += berat_sampah_actual,
│       │       │   │   poin += newPoin,
│       │       │   │   total_selesai += 1,
│       │       │   │   updated_at = now()
│       │       │   │   WHERE masyarakat_id = ?
│       │       │   │
│       │       │   └─► Masyarakat stats and points updated
│       │       │
│       │       ├─► [23] Check Voucher Threshold
│       │       │   │   $setting = Setting::first()
│       │       │   │   $pointPerVoucher = $setting->point_per_voucher ?? 500
│       │       │   │
│       │       │   │   IF masyarakat.poin >= pointPerVoucher
│       │       │   │   THEN
│       │       │   │     voucher_count = floor(masyarakat.poin / pointPerVoucher)
│       │       │   │     UPDATE masyarakats SET voucher = voucher_count
│       │       │   │
│       │       │   └─► Vouchers automatically generated at threshold
│       │       │
│       │       └─► [24] Send Success Response
│       │           └─► return redirect()->with('success')

END (Deposit ticket fully processed)
```

---

## 5. POINT REDEMPTION FLOW (Tukar Poin)

```
START (Masyarakat user on /tiket-poin)
│
├─► [1] GET /tiket-poin → TikettukarpoinController::indexV2()
│   │   - Auth Check: user must be authenticated
│   │   - Load: $masyarakat = Masyarakat::where('user_id', $user->id)->first()
│   │
│   ├─► NO MASYARAKAT
│   │   └─► redirect('/login')
│   │
│   └─► MASYARAKAT EXISTS
│       │
│       ├─► [2] Calculate Available Points
│       │   │   SELECT SUM(poin) FROM tiketsetorsampahs
│       │   │   WHERE masyarakat_id = ? AND status = 'Selesai'
│       │   │   Result: $totalPoinDeposit
│       │   │
│       │   ├─► [3] Calculate Redeemed Points
│       │   │   SELECT SUM(poin) FROM tikettukarpoins
│       │   │   WHERE masyarakat_id = ? AND status = 'Selesai'
│       │   │   Result: $totalPoinRedeemed
│       │   │
│       │   ├─► [4] Calculate Balance
│       │   │   $availablePoin = $totalPoinDeposit - $totalPoinRedeemed
│       │   │
│       │   └─► Available points determined
│       │
│       ├─► [5] Query Redemption Tickets
│       │   │   SELECT * FROM tikettukarpoins
│       │   │   WHERE masyarakat_id = ?
│       │   │   ORDER BY created_at DESC
│       │   │   [BUG] No pagination
│       │   │
│       │   └─► Load user's redemptions
│       │
│       └─► [6] Render List View
│           └─► resources/views/v2/user/masyarakat/tiket-poin-index.blade.php

USER CLICKS "CREATE REDEMPTION"
│
├─► [7] GET /tiket-poin/create
│   │   → TikettukarpoinController::create()
│   │
│   ├─► [8] Calculate Available Points (AGAIN - duplication)
│   │   │   Same as steps 2-4 above
│   │   │
│   │   └─► [PERFORMANCE] Recalculated unnecessarily
│   │
│   ├─► [9] Load Settings
│   │   │   $setting = Setting::first()
│   │   │   $pointPerVoucher = $setting->point_per_voucher ?? 500
│   │   │   [BUG] Created in memory but not persisted
│   │   │
│   │   └─► Settings for display
│   │
│   └─► [10] Render Form
│       └─► resources/views/v2/user/masyarakat/tiket-poin-create.blade.php

USER SUBMITS FORM
│
├─► [11] POST /tiket-poin → TikettukarpoinController::store()
│   │   - Validate input:
│   │     * masyarakat_id: required|exists:masyarakats
│   │     * banksampah_id: required|exists:banksampahusers
│   │     * poin: required|integer|min:1
│   │
│   ├─► VALIDATION FAILS
│   │   └─► return redirect()->back()->withErrors()
│   │
│   └─► VALIDATION PASSES
│       │
│       ├─► [12] Query Masyarakat
│       │   │   $masyarakat = Masyarakat::find($masyarakat_id)
│       │   │
│       │   └─► Get user profile
│       │
│       ├─► [13] Calculate Available Points (AGAIN)
│       │   │   Same calculation as before
│       │   │   $availablePoin = totalDeposit - totalRedeemed
│       │   │
│       │   └─► [DUPLICATION] Third time in same flow
│       │
│       ├─► [14] Validate Sufficient Points
│       │   │   IF requested_poin > availablePoin
│       │   │   THEN
│       │   │     return redirect()->back()->with('error', 'Insufficient points')
│       │   │
│       │   └─► User must have enough points
│       │
│       ├─► [15] Generate QR Code
│       │   │   $qrCodeId = 'TP-' . Str::random(10)
│       │   │
│       │   └─► Redemption QR generated
│       │
│       ├─► [16] Generate Auto-Increment
│       │   │   $tiketpoin_inc = max(tiketpoin_inc) + 1
│       │   │   [BUG] Same race condition as deposits
│       │   │
│       │   └─► Counter incremented
│       │
│       ├─► [17] Create Redemption Ticket
│       │   │   INSERT INTO tikettukarpoins
│       │   │   (tiketpoin_id, tiketpoin_inc, masyarakat_id, banksampah_id,
│       │   │    poin, qr_code_id, status, created_at)
│       │   │
│       │   ├─► tiketpoin_id: UUID
│       │   ├─► status: 'Menunggu' (default)
│       │   └─► Ticket created, awaiting admin approval
│       │
│       └─► [18] Return Success
│           └─► return redirect('/tiket-poin')->with('success')

ADMIN APPROVES REDEMPTION
│
├─► [19] Admin scans QR or accesses ticket detail
│   │   - Similar to deposit validation flow
│   │
│   └─► GET /v2/admin/tiket/{id}

ADMIN SUBMITS APPROVAL
│
├─► [20] PUT /v2/admin/tiket/{id} → TikettukarpoinController::adminValidate()
│   │   - Validate: status in [Selesai, Ditolak]
│   │
│   └─► VALIDATION PASSES
│       │
│       ├─► [21] Check Status
│       │   │
│       │   ├─► IF status = 'Ditolak'
│       │   │   │   - Update ticket status to 'Ditolak'
│       │   │   │   - DO NOT deduct points
│       │   │   │
│       │   │   └─► Redemption rejected
│       │   │
│       │   └─► IF status = 'Selesai'
│       │       │
│       │       ├─► [22] Update Redemption Ticket
│       │       │   │   UPDATE tikettukarpoins SET
│       │       │   │   status = 'Selesai',
│       │       │   │   updated_at = now()
│       │       │   │   WHERE tiketpoin_id = ?
│       │       │   │
│       │       │   └─► [BUG] Not in transaction
│       │       │
│       │       ├─► [23] Update Masyarakat
│       │       │   │   UPDATE masyarakats SET
│       │       │   │   poin -= ticket.poin,
│       │       │   │   voucher += 1,
│       │       │   │   updated_at = now()
│       │       │   │   WHERE masyarakat_id = ?
│       │       │   │
│       │       │   └─► Points deducted, voucher incremented
│       │       │
│       │       └─► [24] Return Success
│       │           └─► return redirect()->with('success')

END (Redemption ticket fully processed)
```


---

## 6. DASHBOARD DATA FLOW (Masyarakat)

```
START (User visits /v2/dashboard)
│
├─► [1] GET /v2/dashboard → DashboardController::indexV2()
│   │   - Auth check: user must be logged in
│   │   - Role check: 'Masyarakat' role required
│   │
│   └─► Proceed to data loading
│
├─► [2] Load Masyarakat Profile
│   │   $masyarakat = Masyarakat::where('user_id', $user->id)->first()
│   │   Load: poin, voucher, total_gramasi, total_selesai
│   │
│   └─► User profile loaded
│
├─► [3] Calculate Current Points
│   │   SELECT SUM(poin) FROM tiketsetorsampahs
│   │   WHERE masyarakat_id = ? AND status = 'Selesai'
│   │   → $totalPoinDeposit
│   │
│   ├─► [4] Calculate Redeemed Points
│   │   SELECT SUM(poin) FROM tikettukarpoins
│   │   WHERE masyarakat_id = ? AND status = 'Selesai'
│   │   → $totalPoinRedeemed
│   │
│   ├─► [5] Calculate Balance
│   │   $currentPoin = $totalPoinDeposit - $totalPoinRedeemed
│   │
│   └─► [PERFORMANCE BUG] Calculated on every page load
│
├─► [6] Load 6-Month Trend Data
│   │   For each month (last 6):
│   │   SELECT SUM(poin) FROM tiketsetorsampahs
│   │   WHERE masyarakat_id = ? 
│   │   AND MONTH(created_at) = ? 
│   │   AND YEAR(created_at) = ?
│   │   AND status = 'Selesai'
│   │
│   └─► Chart data populated
│
├─► [7] Load Recent Deposits (Last 3)
│   │   SELECT * FROM tiketsetorsampahs
│   │   WHERE masyarakat_id = ?
│   │   ORDER BY created_at DESC
│   │   LIMIT 3
│   │
│   └─► Recent transactions shown
│
├─► [8] Load Recent Redemptions (Last 3)
│   │   SELECT * FROM tikettukarpoins
│   │   WHERE masyarakat_id = ?
│   │   ORDER BY created_at DESC
│   │   LIMIT 3
│   │
│   └─► Latest redemptions displayed
│
├─► [9] Load Settings
│   │   SELECT * FROM settings LIMIT 1
│   │   Get: gram_per_point, point_per_voucher
│   │
│   └─► Display configuration loaded
│
└─► [10] Render Dashboard View
    └─► resources/views/v2/user/masyarakat/dashboard.blade.php
        Displays:
        - KPI cards: current points, total weight, completed deposits
        - ApexCharts: 6-month trend
        - Recent transactions table
        - Quick action buttons
```

---

## 7. ARTICLE MANAGEMENT FLOW (Super Admin)

```
START (Super Admin on /v2/sa/edukasi)
│
├─► [1] GET /v2/sa/edukasi → ArtikelController::index()
│   │   - Auth check: user logged in
│   │   - Role check: 'Super Admin' role required
│   │
│   ├─► [2] Query All Articles
│   │   SELECT * FROM artikels
│   │   ORDER BY created_at DESC
│   │   [BUG] No pagination - all articles loaded
│   │
│   └─► Render article list view
│
SA CLICKS "CREATE ARTICLE"
│
├─► [3] GET /v2/sa/edukasi/create
│   │   → ArtikelController::create()
│   │   - Show create form
│   │
│   └─► resources/views/v2/sa/edukasi-create.blade.php

SA SUBMITS NEW ARTICLE
│
├─► [4] POST /v2/sa/edukasi → ArtikelController::store()
│   │   - Validate input:
│   │     * judul_artikel: required|string
│   │     * isi_artikel: required|string
│   │     * gambar_artikel: nullable|image|max:2048|mimes:jpeg,png,jpg,gif,svg,webp
│   │
│   ├─► VALIDATION FAILS
│   │   └─► return redirect()->back()->withErrors()
│   │
│   └─► VALIDATION PASSES
│       │
│       ├─► [5] Upload Image (if provided)
│       │   │   File location: public/ui/images/artikel/
│       │   │   Filename: time() . '_' . uniqid() . '.' . extension
│       │   │   [SECURITY] No virus scanning, MIME spoofing possible
│       │   │
│       │   └─► Image stored
│       │
│       ├─► [6] Create Article Record
│       │   │   INSERT INTO artikels
│       │   │   (artikel_id, judul_artikel, gambar_artikel, isi_artikel, 
│       │   │    created_at, updated_at)
│       │   │
│       │   ├─► artikel_id: UUID
│       │   ├─► gambar_artikel: relative path to image
│       │   └─► Article created
│       │
│       └─► [7] Return Success
│           └─► return redirect('/v2/sa/edukasi')->with('success')

SA EDITS ARTICLE
│
├─► [8] GET /v2/sa/edukasi/{id}/edit
│   │   → ArtikelController::edit($id)
│   │   - Load article by UUID
│   │   - Show edit form with current data
│   │
│   └─► resources/views/v2/sa/edukasi-edit.blade.php

SA UPDATES ARTICLE
│
├─► [9] PUT /v2/sa/edukasi/{id} → ArtikelController::update($id)
│   │   - Validate (same as create)
│   │
│   ├─► VALIDATION PASSES
│   │   │
│   │   ├─► [10] Check for New Image
│   │   │   │
│   │   │   ├─► IF new image uploaded
│   │   │   │   │   - Delete old image: File::delete($oldPath)
│   │   │   │   │   - Upload new image
│   │   │   │   │
│   │   │   │   └─► Old file cleanup performed
│   │   │   │
│   │   │   └─► Update Article Record
│   │   │       UPDATE artikels SET
│   │   │       judul_artikel = ?,
│   │   │       gambar_artikel = ?,
│   │   │       isi_artikel = ?,
│   │   │       updated_at = now()
│   │   │       WHERE artikel_id = ?
│   │   │
│   │   └─► [11] Return Success
│   │       └─► return redirect('/v2/sa/edukasi')->with('success')

SA DELETES ARTICLE
│
├─► [12] DELETE /v2/sa/edukasi/{id} → ArtikelController::destroy($id)
│   │   - Load article
│   │
│   ├─► [13] Delete Image File
│   │   │   $path = public_path($artikel->gambar_artikel)
│   │   │   IF File::exists($path)
│   │   │   THEN File::delete($path)
│   │   │
│   │   └─► Image file removed
│   │
│   ├─► [14] Delete Article Record
│   │   │   DELETE FROM artikels
│   │   │   WHERE artikel_id = ?
│   │   │
│   │   └─► Database record removed
│   │
│   └─► [15] Return Success
│       └─► return redirect('/v2/sa/edukasi')->with('success')
```

---

## 8. EDUCATION VIEW FLOW (Masyarakat - Current Issue)

```
START (User visits /v2/edukasi)
│
├─► [1] GET /v2/edukasi
│   │   Route: routes/web.php line ~340
│   │   Currently maps to: static view (placeholder)
│   │   [BUG] Does NOT call ArtikelController::index()
│   │
│   └─► Render static view
│
├─► [2] Expected Flow (What SHOULD happen)
│   │   - GET /v2/edukasi → ArtikelController::index()
│   │   - SELECT * FROM artikels ORDER BY created_at DESC
│   │   - Load all articles
│   │   - Render with article cards
│   │
│   └─► [NOT IMPLEMENTED] Articles not displayed

CURRENT STATE:
- Route returns: view('v2.user.masyarakat.edukasi-index')
- This view currently shows: empty collection or static text
- No database query executed
- Articles created by SA are not visible to users

FIX REQUIRED:
- Change route to call: ArtikelController::index()
- OR add method to route: DashboardController::getEdukasi()
```

---

## 9. HISTORY/RIWAYAT FLOW (Incomplete)

```
START (User visits /riwayat)
│
├─► [1] GET /riwayat → DashboardController::getRiwayat()
│   │   [PARTIALLY IMPLEMENTED] Method exists but view integration unclear
│   │
│   └─► Intended to show transaction history
│
├─► [2] Expected Data Loading
│   │   - Combine deposits and redemptions
│   │   - Sort by date (newest first)
│   │   - Show: date, type, amount, status
│   │   - Support filtering/search
│   │
│   └─► [NOT FULLY IMPLEMENTED]

CURRENT ISSUES:
- Method exists but returns data without clear view mapping
- No pagination on large transaction lists
- UI template may not display correctly
```

---

## 10. QR SCAN TO VALIDATION FLOW (With Security Issue)

```
ADMIN SCANS DEPOSIT TICKET
│
├─► [1] Admin at /v2/admin/scan
│   │   - html5-qrcode library loads
│   │   - Camera permission requested
│   │   - User points camera at QR code
│   │
│   └─► QR CODE CAPTURED
│
├─► [2] JavaScript Decode QR
│   │   onScanSuccess(decodedText) {
│   │       window.location.href = `/admin/tiket/${decodedText}`;
│   │   }
│   │
│   ├─► [SECURITY BUG] Direct redirect without validation:
│   │   - decodedText used directly in URL
│   │   - Example scanned value: 'TS-aBcDeFgHiJ'
│   │   - No UUID format check
│   │   - No existence verification
│   │
│   └─► Vulnerability: Malformed data could cause 404 or wrong redirect

CORRECT FLOW (What SHOULD happen):
│
├─► [3] Validate QR Format
│   │   - Check if matches pattern: ^TS-[a-zA-Z0-9]{10}$
│   │   - Check if matches pattern: ^TP-[a-zA-Z0-9]{10}$
│   │   - If invalid → show error
│   │
│   └─► Format validation passed
│
├─► [4] Lookup Ticket
│   │   SELECT * FROM tiketsetorsampahs
│   │   WHERE qr_code_id = ?
│   │   OR SELECT * FROM tikettukarpoins
│   │   WHERE qr_code_id = ?
│   │
│   ├─► NOT FOUND
│   │   └─► Show error: "Ticket not found"
│   │
│   └─► FOUND → Proceed to detail view
│       - Load ticket with relations
│       - Show: customer info, weight, status, actions
│       - Allow: approve, reject, cancel

END (Admin can validate ticket)
```

---

## 11. DATA VALIDATION & CONSISTENCY MAP

```
USER CREATION
├─► Input Validation: ✓ (email, username unique; password strength)
├─► Database Consistency: ⚠ (No transaction wrapping)
├─► File Upload: ⚠ (No virus scanning, MIME spoofing possible)
└─► Points Initialization: ✓ (Set to 0)

DEPOSIT TICKET CREATION
├─► Input Validation: ✓ (weight required)
├─► Masyarakat Lookup: ⚠ (No error handling)
├─► Point Calculation: ✓ (Math verified)
├─► QR Generation: ⚠ (Not actual QR code)
├─► Auto-Increment: ✗ (Race condition possible)
└─► Database Write: ⚠ (Not in transaction)

DEPOSIT VALIDATION (by Admin)
├─► Ticket Lookup: ✓ (with error handling)
├─► Weight Input: ✓ (validated)
├─► Point Recalculation: ✓ (verified)
├─► Masyarakat Update: ⚠ (Not in transaction, could fail partially)
├─► Status Update: ✓ (Selesai/Ditolak valid)
└─► Voucher Logic: ⚠ (No transaction for multi-step update)

REDEMPTION TICKET CREATION
├─► Input Validation: ✓ (points required)
├─► Point Balance Check: ✓ (sufficient funds verified)
├─► Masyarakat Lookup: ⚠ (No error handling)
├─► QR Generation: ⚠ (Not actual QR code)
├─► Auto-Increment: ✗ (Race condition possible)
└─► Database Write: ⚠ (Not in transaction)

REDEMPTION VALIDATION (by Admin)
├─► Ticket Lookup: ✓ (with error handling)
├─► Status Update: ✓ (Selesai/Ditolak valid)
├─► Masyarakat Deduction: ⚠ (Not in transaction)
├─► Voucher Increment: ⚠ (Not verified for consistency)
└─► Point Balance: ⚠ (Could go negative if race condition exists)
```


---

## 12. DATABASE SCHEMA & RELATIONSHIPS DIAGRAM

```
┌─────────────────────────────────────────────────────────────────────┐
│                          USERS TABLE                                │
├─────────────────────────────────────────────────────────────────────┤
│ PK: id (auto-increment)                                             │
│ Fields: name, email (unique), username (unique), avatar,            │
│         password (hashed), remember_token, timestamps               │
│                                                                      │
│ Relations:                                                          │
│ ├─► hasOne: Masyarakat (via user_id)                               │
│ ├─► hasMany: Orders (via user_id)                                  │
│ ├─► hasMany: Tabungan (via user_id)                                │
│ └─► hasMany: Tickets (via user_id) [legacy]                        │
│                                                                      │
│ Spatie Relations:                                                   │
│ ├─► hasMany: Roles (via model_has_roles)                           │
│ └─► hasMany: Permissions (via model_has_permissions)               │
└─────────────────────────────────────────────────────────────────────┘
                              ▲ FK
                              │
        ┌─────────────────────┼──────────────────────┐
        │                     │                      │
┌───────▼────────────────────────────────┐  ┌──────▼──────────────────┐
│      MASYARAKAT TABLE                  │  │  BANKSAMPAHUSER TABLE  │
├───────────────────────────────────────┤  ├──────────────────────────┤
│ PK: masyarakat_id (UUID)              │  │ PK: banksampah_id (UUID)│
│ FK: user_id (cascade)                 │  │ FK: created_by (set null)
│ FK: approved_by (set null) [Super Admin]  │                        │
│                                        │  │ Fields:                │
│ Fields:                                │  │ - username, password   │
│ - nik (16 chars, unique)              │  │ - nama_bank_sampah     │
│ - identity_photo (path)               │  │ - alamat, kecamatan    │
│ - gender (enum)                       │  │ - jam_operasional      │
│ - verification (enum: Menunggu/       │  │ - nomor_telepon        │
│              Disetujui/Ditolak)       │  │ - deskripsi            │
│ - poin (integer, default 0)           │  │ - timestamps           │
│ - voucher (integer, default 0)        │  │                        │
│ - total_gramasi (integer)             │  │ Relations:             │
│ - total_selesai (integer)             │  │ ├─► hasMany: Deposits  │
│ - timestamps                          │  │ └─► hasMany: Redempts  │
│                                        │  │                        │
│ Relations:                             │  └──────────────────────────┘
│ ├─► belongsTo: User (user_id)        │
│ ├─► belongsTo: User as Approver      │
│ ├─► hasMany: Deposits                │
│ └─► hasMany: Redemptions             │
└───────────────────────────────────────┘
        ▲                           ▲
        │                           │
        ├─────────┬────────────┬────┘
        │         │            │
        │    FK   │            │ FK
    ┌───▼──────────▼───┐   ┌───▼─────────────────────┐
    │  TIKETSETOR       │   │  TIKTTUKAR              │
    │  SAMPAH TABLE     │   │  POIN TABLE             │
    ├───────────────────┤   ├─────────────────────────┤
    │ PK: tiketsampah_id│   │ PK: tiketpoin_id (UUID) │
    │     (UUID)        │   │                         │
    │ Unique counter:   │   │ Unique counter:         │
    │ - tiketsampah_inc │   │ - tiketpoin_inc         │
    │   (auto-inc)      │   │   (auto-inc)            │
    │                   │   │                         │
    │ FK: masyarakat_id │   │ FK: masyarakat_id (FK)  │
    │ FK: banksampah_id │   │ FK: banksampah_id (FK)  │
    │                   │   │                         │
    │ Fields:           │   │ Fields:                 │
    │ - berat_sampah    │   │ - poin (integer)        │
    │ - berat_actual    │   │ - qr_code_id            │
    │ - poin            │   │ - status (enum)         │
    │ - qr_code_id      │   │ - timestamps            │
    │ - status (enum)   │   │                         │
    │ - timestamps      │   │ Relations:              │
    │                   │   │ ├─► belongsTo: Msykt    │
    │ Relations:        │   │ └─► belongsTo: BankSmp  │
    │ ├─► belongsTo:    │   │                         │
    │ │   Masyarakat    │   └─────────────────────────┘
    │ └─► belongsTo:    │
    │     BankSampah    │
    └───────────────────┘

┌───────────────────────────┐      ┌──────────────────────┐
│    ARTIKEL TABLE          │      │  SETTING TABLE       │
├───────────────────────────┤      ├──────────────────────┤
│ PK: artikel_id (UUID)     │      │ PK: settings_id      │
│                           │      │     (auto-increment) │
│ Fields:                   │      │                      │
│ - judul_artikel           │      │ Fields:              │
│ - gambar_artikel (path)   │      │ - gram_per_point     │
│ - isi_artikel (text)      │      │ - point_per_voucher  │
│ - timestamps              │      │ - timestamps         │
│                           │      │                      │
│ Relations: None           │      │ Pattern: Singleton   │
│ (Standalone)              │      │ (Only 1 record)      │
└───────────────────────────┘      └──────────────────────┘

SPATIE PERMISSION TABLES:
┌────────────────────────┐  ┌─────────────────────┐
│  ROLES TABLE           │  │  PERMISSIONS TABLE  │
├────────────────────────┤  ├─────────────────────┤
│ id, name, guard_name   │  │ id, name, guard_name│
│                        │  │                     │
│ Records:               │  │ [System-defined]    │
│ - Super Admin          │  │ [Not actively used] │
│ - Admin Bank Sampah    │  └─────────────────────┘
│ - Masyarakat           │
└────────────────────────┘
```

---

## 13. ROLE-BASED ACCESS CONTROL (RBAC) MATRIX

```
┌─────────────────────┬─────────────────┬──────────────────┬─────────────────┐
│     FEATURE         │  MASYARAKAT     │ ADMIN BANK SAMPAH│  SUPER ADMIN    │
├─────────────────────┼─────────────────┼──────────────────┼─────────────────┤
│ Authentication      │ ✓ Login/Register│ ✓ Login Only     │ ✓ Login Only    │
│ Dashboard Access    │ ✓ /v2/dashboard │ ✓ /v2/admin/*    │ ✓ /v2/sa/*      │
│                     │                 │                  │                 │
│ DEPOSIT TICKETS     │                 │                  │                 │
│ - Create            │ ✓ Own tickets   │ ✗                │ ✓ (Admin)       │
│ - View Own          │ ✓ All own       │ ✓ All at bank    │ ✓ All system    │
│ - View All          │ ✗               │ ✓ All            │ ✓ All           │
│ - Validate/Approve  │ ✗               │ ✓ At their bank  │ ✓ All banks     │
│ - Cancel            │ ✓ Own pending   │ ✗                │ ✓ All           │
│ - Delete            │ ✗               │ ✗                │ ✓ All           │
│                     │                 │                  │                 │
│ REDEMPTION TICKETS  │                 │                  │                 │
│ - Create            │ ✓ Own tickets   │ ✗                │ ✓ (Admin)       │
│ - View Own          │ ✓ All own       │ ✓ All at bank    │ ✓ All system    │
│ - View All          │ ✗               │ ✓ All            │ ✓ All           │
│ - Validate/Approve  │ ✗               │ ✓ At their bank  │ ✓ All banks     │
│ - Cancel            │ ✓ Own pending   │ ✗                │ ✓ All           │
│ - Delete            │ ✗               │ ✗                │ ✓ All           │
│                     │                 │                  │                 │
│ MASYARAKAT MGMT     │                 │                  │                 │
│ - View Own Profile  │ ✓ Own only      │ ✗                │ ✓ All           │
│ - Edit Own Profile  │ ✗ (Incomplete)  │ ✗                │ ✗               │
│ - View All          │ ✗               │ ✗                │ ✓ All           │
│ - Approve/Verify    │ ✗               │ ✗                │ ✓ Pending       │
│ - Reject            │ ✗               │ ✗                │ ✓ Pending       │
│ - Edit Other        │ ✗               │ ✗                │ ✓ Limited       │
│ - Delete            │ ✗               │ ✗                │ ✓ All           │
│                     │                 │                  │                 │
│ ARTICLES (EDUKASI)  │                 │                  │                 │
│ - View              │ ✓ Published     │ ✗                │ ✓ All           │
│ - Create            │ ✗               │ ✗                │ ✓ All           │
│ - Edit              │ ✗               │ ✗                │ ✓ Own/All       │
│ - Delete            │ ✗               │ ✗                │ ✓ All           │
│                     │                 │                  │                 │
│ SETTINGS            │                 │                  │                 │
│ - View              │ ✗               │ ✗                │ ✓ Implicit      │
│ - Update            │ ✗               │ ✗                │ ✓ Explicit      │
│                     │                 │                  │                 │
│ BANK SAMPAH MGMT    │                 │                  │                 │
│ - Create Account    │ ✗               │ ✗                │ ✓ All           │
│ - View Own          │ ✗               │ ✓ Own            │ ✓ All           │
│ - View All          │ ✗               │ ✗                │ ✓ All           │
│ - Edit Own          │ ✗               │ ✗ (Missing)      │ ✓ All           │
│ - Delete            │ ✗               │ ✗                │ ✓ All           │
│                     │                 │                  │                 │
│ QR SCANNING         │ ✗               │ ✓ Own bank       │ ✓ All banks     │
│ - Access Scanner    │ ✗               │ ✓                │ ✓               │
│ - View Ticket       │ ✓ Own only      │ ✓ Own bank       │ ✓ All           │
│                     │                 │                  │                 │
│ REPORTS/ANALYTICS   │                 │                  │                 │
│ - Dashboard Stats   │ ✓ Own data      │ ✓ Bank data      │ ✓ System-wide   │
│ - Export            │ ✗               │ ✗                │ ✗               │
│ - Audit Logs        │ ✗               │ ✗                │ ✗               │
└─────────────────────┴─────────────────┴──────────────────┴─────────────────┘

MIDDLEWARE ENFORCEMENT POINTS:
├─► /v2/dashboard         → middleware('auth:web')
├─► /v2/admin/*           → middleware('auth:web', 'role:Admin Bank Sampah|Super Admin')
├─► /v2/sa/*              → middleware('auth:web', 'role:Super Admin')
└─► Public routes         → No auth required (/login, /register, /help)
```


---

## 14. CRITICAL DATA FLOW GAPS & ISSUES

### Issue #1: Missing Admin Dashboard Data Pass

```
PROBLEM:
Route: GET /v2/admin/dashboard
Controller: DashboardController::adminBankSampahDashboard() [NOT IMPLEMENTED]
View: resources/views/v2/admin/dashboard.blade.php

EXPECTED FLOW:
1. Query pending deposits: SELECT COUNT(*) FROM tiketsetorsampahs 
   WHERE status = 'Menunggu' AND banksampah_id = current_admin_bank
2. Query completed deposits: SELECT COUNT(*) WHERE status = 'Selesai' ...
3. Query pending redemptions: SELECT COUNT(*) FROM tikettukarpoins 
   WHERE status = 'Menunggu' AND banksampah_id = current_admin_bank
4. Pass variables to view: $pendingDeposits, $completedDeposits, etc.
5. Render dashboard with KPI cards

ACTUAL FLOW:
1. Route redirects to dashboard view
2. View tries to access undefined variables
3. Dashboard shows 0 or error

IMPACT: Admin sees blank/broken dashboard
FIX: Implement adminBankSampahDashboard() method
```

### Issue #2: Education View Route Mismatch

```
PROBLEM:
Route: GET /v2/edukasi
Current: Maps to static view (placeholder)
Expected: Should call ArtikelController::index()

CURRENT CODE (routes/web.php):
Route::get('/edukasi', function () {
    return view('v2.user.masyarakat.edukasi-index');
});

SHOULD BE:
Route::get('/edukasi', [ArtikelController::class, 'index'])->name('edukasi.index');

IMPACT:
- Articles created by Super Admin are not visible
- Users see empty education section
- Database query never executed

FIX: Change route to call controller method
```

### Issue #3: Race Condition in Auto-Increment

```
PROBLEM:
File: app/Models/TiketSetorSampah.php (boot method)

CODE:
if (empty($model->tiketsampah_inc)) {
    $model->tiketsampah_inc = (static::max('tiketsampah_inc') ?? 0) + 1;
}

SCENARIO (Concurrent Requests):
T1: Request A reads max(tiketsampah_inc) = 5 → calculates 6
T2: Request B reads max(tiketsampah_inc) = 5 → calculates 6
T1: Saves with tiketsampah_inc = 6
T2: Saves with tiketsampah_inc = 6  [DUPLICATE!]

IMPACT:
- Duplicate ticket numbers in same batch
- Audit trail confusion
- Inventory tracking errors
- Impossible to identify unique tickets

FIX:
Option 1: Use database sequence (AUTO_INCREMENT on column)
Option 2: Wrap in DB::transaction() with row locking
Option 3: Use UUID-based naming without auto-increment
```

### Issue #4: Unvalidated QR Code Redirect

```
PROBLEM:
File: resources/views/v2/user/adminbanksampah/qr-scan.blade.php:62

CODE:
onScanSuccess(decodedText) {
    window.location.href = `/admin/tiket/${decodedText}`;
}

VULNERABILITY:
- decodedText used directly in URL
- No format validation
- No existence check
- No error handling

ATTACK SCENARIOS:
1. Malformed QR: User scans corrupted QR → redirects to /admin/tiket/garbage → 404
2. SQL Injection: User crafts QR with SQL → /admin/tiket/; DROP TABLE--
   (Mitigated by Laravel routing but poor UX)
3. Path Traversal: /admin/tiket/../../../etc/passwd
4. Wrong Ticket: Admin scans deposit QR but system tries to find redemption ticket

IMPACT: 404 errors, confusing UX, potential security issues

FIX:
1. Validate format: /^(TS|TP)-[a-zA-Z0-9]{10}$/ 
2. Query database before redirect
3. Check ticket exists and belongs to bank
4. Show error message if not found
5. Log all scan attempts
```

### Issue #5: Point Calculation Duplication

```
PROBLEM:
Same calculation repeated 6+ times across codebase:

Location 1: TiketsetorsampahController::store()
$poin = floor($berat_sampah / $gramPerPoint);

Location 2: TiketsetorsampahController::adminValidate()
$newPoin = floor($berat_sampah_actual / $gramPerPoint);

Location 3: TikettukarpoinController::create()
(Calculation in view logic)

Location 4: DashboardController::indexV2()
(Calculation on-the-fly)

Location 5: Database queries for point sums
(No calculation, just aggregation)

Location 6: Masyarakat model accessor (missing)

IMPACT:
- Inconsistent point values if conversion rate changes
- Hard to maintain formula in multiple places
- Performance: Recalculated on every page load
- Bug: If one location uses wrong formula, system breaks

FIX: Extract to service class or model method
```

---

## 15. DATA CONSISTENCY SCENARIOS

### Scenario A: Happy Path - Full Deposit Cycle

```
1. User creates TiketSetorSampah
   - tiketsampah_inc = 1
   - status = 'Menunggu'
   - poin = floor(100 / 10) = 10
   - Masyarakat.poin = 0 (unchanged)
   
2. Admin validates with actual weight 95g
   - tiketsampah_inc = 1 (unchanged)
   - poin = floor(95 / 10) = 9 (recalculated)
   - status = 'Selesai'
   - Masyarakat.poin = 0 + 9 = 9
   - Masyarakat.total_gramasi = 0 + 95 = 95
   - Masyarakat.total_selesai = 0 + 1 = 1

3. Check voucher threshold (assuming point_per_voucher = 500)
   - Masyarakat.poin (9) < 500
   - Masyarakat.voucher = 0 (unchanged)

RESULT: ✓ Consistent state
```

### Scenario B: Error Condition - No Transaction

```
1. Admin validates deposit at line X
   - SQL 1: UPDATE tiketsetorsampahs SET status='Selesai', poin=9
     ✓ Success - ticket marked complete

2. Line Y: UPDATE masyarakats SET poin=9, total_gramasi=95, total_selesai=1
   ✗ FAILS - database error (connection lost, disk full, etc.)

RESULT: ✗ INCONSISTENT STATE
- Ticket shows as 'Selesai' (complete)
- Masyarakat.poin = 0 (not updated)
- User's dashboard shows 0 points but ticket shows complete
- Admin dashboard shows discrepancy
- Audit trail broken

FIX REQUIRED: DB::transaction() wrapper
```

### Scenario C: Concurrent Redemption

```
User has: Masyarakat.poin = 20

T1 (Request A):
1. Check available: 20 >= 15 ✓
2. Create TiketTukarPoin with poin=15
3. Status = 'Menunggu'

T2 (Request B):
1. Check available: 20 >= 15 ✓  [RACE CONDITION]
2. Create TiketTukarPoin with poin=15
3. Status = 'Menunggu'

Admin approves both tickets:
- Ticket A: Masyarakat.poin = 20 - 15 = 5
- Ticket B: Masyarakat.poin = 5 - 15 = -10 [NEGATIVE!]

RESULT: ✗ INCONSISTENT STATE
- Point balance goes negative
- User can't redeem more but already have tickets pending
- System allows over-redemption

FIX: Lock masyarakat row during redemption creation
```

---

## 16. API RESPONSE PATTERNS

### JSON Response - Deposit Ticket Detail

```
GET /v2/tiket-sampah/{id}

Response (if request->wantsJson()):
{
  "success": true,
  "data": {
    "tiketsampah_id": "uuid-value",
    "tiketsampah_inc": 5,
    "masyarakat_id": "uuid-value",
    "banksampah_id": "uuid-value",
    "berat_sampah": 150,
    "berat_sampah_actual": null,
    "poin": 15,
    "qr_code_id": "TS-aBcDeFgHiJ",
    "status": "Menunggu",
    "created_at": "2026-08-03T10:30:00Z",
    "updated_at": "2026-08-03T10:30:00Z",
    "masyarakat": {
      "masyarakat_id": "uuid",
      "nik": "1234567890123456",
      "poin": 15
    },
    "banksampah": {
      "banksampah_id": "uuid",
      "nama_bank_sampah": "Bank Sampah Bersih"
    }
  }
}
```

### Error Response

```
POST /v2/tiket-sampah (validation fails)

{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "berat_sampah": ["The berat sampah field is required."]
  }
}

Status Code: 422 Unprocessable Entity
```

---

## 17. FILE UPLOAD FLOW DETAILS

### KTP Photo Upload (Registration)

```
1. User selects file: myfile.jpg (2.5 MB)

2. Browser validation:
   - Type check: image/* ✓
   - Size check: <= 2MB ✗
   - Form submission blocked

3. If user bypasses: HTTP POST received

4. Laravel Validation:
   $request->validate([
       'identity_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
   ]);

5. Checks:
   - File exists ✓
   - MIME type matches mimes list
     [ISSUE: MIME spoofing possible]
   - Size: 2048 KB
   - Image dimension checks: MISSING

6. File Processing:
   $filename = time() . '_' . uniqid() . '.' . $request->identity_photo->extension();
   $request->identity_photo->move(public_path('ui/images/masyarakat/'), $filename);

7. Path Storage:
   Masyarakat.identity_photo = 'ui/images/masyarakat/1722644400_66afc3b01234d.jpg'

8. Retrieval:
   In view: {{ asset('ui/images/masyarakat/' . $masyarakat->identity_photo) }}
   URL: /ui/images/masyarakat/1722644400_66afc3b01234d.jpg
   [ISSUE: Path includes subdirectory twice if stored as full path]
```

### Article Image Upload

```
Similar process:
1. Upload location: public/ui/images/artikel/
2. Validation: same as above
3. Deletion on update: File::delete(public_path($old_path))
4. [ISSUE] Old file not deleted if update fails (no transaction)
5. [ISSUE] Orphaned files if delete operation fails
```

---

## 18. SESSION & AUTHENTICATION STATE

```
LOGIN FLOW:
1. User submits username + password
2. Laravel Auth::attempt() verifies credentials
3. Session created with:
   - session('user_id') = user UUID
   - session('roles') = array of role names
   - session('_token') = CSRF token
   - session('_previous') = last URL

4. Cookie set:
   - XSRF-TOKEN (CSRF protection)
   - laravel_session (session ID)
   - laravel_token (remember-me, if applicable)

DURING REQUESTS:
- Middleware checks: auth:web guard active
- Spatie loads roles from model_has_roles table
- role:* middleware checks if user has required role
- All views access: {{ Auth::user() }}

LOGOUT FLOW:
1. GET /logout
2. Session destroyed: session()->flush()
3. All cookies cleared
4. User redirected to /login

[ISSUE] Verification check commented out:
- Unverified users (Menunggu status) can access dashboard
- Should redirect to /v2/waiting or block access
- Currently no check in middleware
```


---

## 19. PERFORMANCE BOTTLENECKS & N+1 QUERIES

### Identified N+1 Query Problems

```
PROBLEM #1: Masyarakat List View
File: SuperAdminController::masyarakatReview() or index view

Code:
$masyarakats = Masyarakat::latest('created_at')->get();
foreach ($masyarakats as $m) {
    echo $m->user->name;  // N+1 Query!
}

Queries Executed:
- 1x SELECT * FROM masyarakats
- Nx SELECT * FROM users WHERE id = ? (1 query per masyarakat)
Total: 1 + N queries (could be 1 + 1000 with 1000 users)

FIX:
$masyarakats = Masyarakat::with('user')->latest('created_at')->get();
// Now: 1 SELECT + 1 eager load JOIN = 2 total queries
```

### Identified Missing Pagination

```
LOCATIONS WITH NO PAGINATION:

1. SuperAdminController::masyarakatReview()
   - Loads ALL masyarakats into memory
   - Issue: If 10,000 users exist, memory exhaustion
   - Fix: Add ->paginate(15)

2. ArtikelController::index()
   - $artikels = Artikel::latest()->get()
   - Fix: ->paginate(10)

3. TiketsetorsampahController::indexV2()
   - $tickets = TiketSetorSampah::where(...)->get()
   - Fix: ->paginate(20)

4. TikettukarpoinController::indexV2()
   - $tickets = TiketTukarPoin::where(...)->get()
   - Fix: ->paginate(20)

IMPACT: Page load time increases linearly with data size
```

### Dashboard Point Calculation Inefficiency

```
CURRENT CODE (DashboardController::indexV2):

$masyarakat = Masyarakat::where('user_id', $user->id)->first();
$totalPoinDeposit = TiketSetorSampah::where('masyarakat_id', $masyarakat->masyarakat_id)
    ->where('status', 'Selesai')
    ->sum('poin');
$totalPoinRedeemed = TiketTukarPoin::where('masyarakat_id', $masyarakat->masyarakat_id)
    ->where('status', 'Selesai')
    ->sum('poin');

QUERIES: 3 queries executed on EVERY page load
OPTIMIZATION: Cache result for 1 hour or store in masyarakat table

BETTER APPROACH:
- Add denormalized column: Masyarakat.available_poin
- Update on ticket completion event
- Query: SELECT available_poin FROM masyarakats WHERE id = ?
- Single query instead of 3
```

---

## 20. SECURITY VULNERABILITIES SUMMARY

```
┌─────────────────────────────────────────────────────────────────────┐
│                    SECURITY ISSUE MATRIX                            │
├──────────────────────┬────────────┬──────────┬────────────────────────┤
│ ISSUE                │ SEVERITY   │ STATUS   │ IMPACT                 │
├──────────────────────┼────────────┼──────────┼────────────────────────┤
│ QR Unvalidated       │ HIGH       │ Active   │ Redirect to wrong      │
│ Redirect             │            │ Bug      │ ticket/404 errors      │
│                      │            │          │                        │
│ File Upload MIME     │ HIGH       │ Active   │ Execute malicious      │
│ Spoofing             │            │ Bug      │ files (server-side)    │
│                      │            │          │                        │
│ Race Condition       │ HIGH       │ Active   │ Duplicate ticket       │
│ Auto-Increment       │            │ Design   │ numbers, audit issues  │
│                      │            │          │                        │
│ No Transaction       │ MEDIUM     │ Active   │ Data inconsistency     │
│ Wrapping             │            │ Bug      │ on database errors     │
│                      │            │          │                        │
│ Verification Check   │ MEDIUM     │ Disabled │ Unverified users       │
│ Disabled             │            │ Code     │ access dashboard       │
│                      │            │          │                        │
│ Missing Rate         │ MEDIUM     │ Missing  │ Brute force login      │
│ Limiting             │            │ Feature  │ attacks possible       │
│                      │            │          │                        │
│ No Virus Scanning    │ MEDIUM     │ Missing  │ Malware upload via     │
│                      │            │ Feature  │ profile/article images │
│                      │            │          │                        │
│ File Permissions     │ LOW        │ Active   │ World-readable files   │
│ 0755                 │            │ Config   │ (consider 0750)        │
│                      │            │          │                        │
│ CSRF Protected       │ NONE       │ ✓        │ Middleware in place    │
│ Hardcoded Image      │ NONE       │ ✓        │ Not a SQL injection    │
│ Paths                │            │          │ (PHP variables)        │
└──────────────────────┴────────────┴──────────┴────────────────────────┘
```

---

## 21. QUICK REFERENCE: DATA FLOW DECISION TREE

```
USER VISITS /v2/dashboard
│
├─► AUTH CHECK
│   ├─► Not logged in → redirect('/login')
│   └─► Logged in → Continue
│
├─► ROLE CHECK
│   ├─► Has role 'Masyarakat' → Load masyarakat dashboard
│   ├─► Has role 'Admin Bank Sampah' → Load admin dashboard
│   │   [INCOMPLETE] Data not passed to view
│   └─► Has role 'Super Admin' → Load SA dashboard
│
├─► DATA LOADING (Masyarakat case)
│   ├─► Query: Masyarakat profile
│   ├─► Query: Point sums (3x queries)
│   ├─► Query: 6-month trend (12x queries)
│   ├─► Query: Recent deposits (1x)
│   ├─► Query: Recent redemptions (1x)
│   └─► Query: Settings (1x)
│       Total: ~20 queries
│
└─► RENDER VIEW
    └─► Display dashboard with charts/KPIs

---

USER CREATES DEPOSIT TICKET (/tiket-sampah)
│
├─► INPUT VALIDATION
│   ├─► Masyarakat exists? If not → error
│   ├─► Bank exists? If not → error
│   └─► Weight valid? If not → error
│
├─► CALCULATION
│   ├─► Load settings
│   ├─► Calculate poin = floor(weight / gram_per_point)
│   └─► Generate QR ID = prefix + random(10)
│
├─► DATABASE INSERT
│   ├─► [BUG] NOT IN TRANSACTION
│   ├─► Insert TiketSetorSampah
│   └─► Auto-increment [BUG] Race condition possible
│
└─► RESPONSE
    ├─► If JSON request → return JSON
    └─► Else → redirect with success

---

ADMIN VALIDATES DEPOSIT (/v2/admin/tiket/{id})
│
├─► LOAD TICKET
│   ├─► Query by ID (UUID)
│   ├─► Load relations: masyarakat, banksampah
│   └─► Check ticket exists
│
├─► FORM SUBMISSION
│   ├─► Input: actual weight, status (Selesai/Ditolak)
│   └─► Validate: weight required, status valid
│
├─► PROCESSING
│   ├─► [BUG] NOT IN TRANSACTION
│   ├─► Recalculate poin
│   ├─► Update ticket record
│   ├─► Update masyarakat profile
│   │   ├─► Add points
│   │   ├─► Add gramasi
│   │   └─► Increment selesai count
│   └─► Check voucher threshold
│
└─► RESPONSE
    └─► Success message or error
```

---

## 22. IMPLEMENTATION PRIORITY CHECKLIST

```
PHASE 1: CRITICAL SECURITY FIXES (Week 1)
┌────────────────────────────────────┐
│ [ ] Fix QR scan redirect validation│
│     - Validate UUID format before  │
│       redirect                     │
│     - Check ticket exists          │
│     - Proper error handling        │
│                                    │
│ [ ] Add transaction wrapping       │
│     - DB::transaction() on ticket  │
│       validation                   │
│     - Atomic masyarakat updates    │
│                                    │
│ [ ] Implement auto-increment fix   │
│     - Use database sequences or    │
│       unique constraints           │
│     - Test concurrent requests     │
└────────────────────────────────────┘

PHASE 2: DATA CONSISTENCY (Week 2)
┌────────────────────────────────────┐
│ [ ] Complete admin dashboard       │
│     - Implement data passing       │
│     - Add KPI calculations         │
│                                    │
│ [ ] Fix education route            │
│     - Map to ArtikelController     │
│     - Test article display         │
│                                    │
│ [ ] Add pagination everywhere      │
│     - TiketSetorSampah lists       │
│     - Masyarakat management        │
│     - Article lists                │
│                                    │
│ [ ] Enable verification gate       │
│     - Uncomment check or add       │
│       middleware                   │
│     - Redirect to /v2/waiting      │
└────────────────────────────────────┘

PHASE 3: PERFORMANCE (Week 3)
┌────────────────────────────────────┐
│ [ ] Fix N+1 queries                │
│     - Add eager loading (.with())  │
│     - Dashboard queries            │
│                                    │
│ [ ] Cache point calculations       │
│     - Store available_poin in DB   │
│     - Update on ticket events      │
│                                    │
│ [ ] Add query indexes              │
│     - masyarakat_id FK             │
│     - user_id FK                   │
│     - created_by FK                │
└────────────────────────────────────┘

PHASE 4: TESTING & QUALITY (Week 4)
┌────────────────────────────────────┐
│ [ ] Add unit tests                 │
│     - Point calculations           │
│     - Voucher generation           │
│     - Status transitions           │
│                                    │
│ [ ] Add feature tests              │
│     - Full deposit flow            │
│     - Concurrent scenarios         │
│     - Error conditions             │
│                                    │
│ [ ] Code cleanup                   │
│     - Remove debug comments        │
│     - Extract to service class     │
│     - Add docblocks                │
└────────────────────────────────────┘
```

---

## 23. CONTROLLER METHOD CALL GRAPH

```
HTTP Request → Route → Middleware Chain → Controller Method → Model → Database

/login              → AuthController::login()
                      ├─► User::where(username/nik)
                      └─► Masyarakat::relation check [DISABLED]

/register           → AuthController::register()
                      ├─► User::create()
                      ├─► File upload → public/ui/images/masyarakat/
                      └─► Masyarakat::create()

/v2/dashboard       → DashboardController::indexV2()
                      ├─► Masyarakat::where(user_id)
                      ├─► TiketSetorSampah::sum(poin) [3 queries]
                      ├─► TiketTukarPoin::sum(poin)
                      └─► Setting::first()

/v2/admin/dashboard → DashboardController::adminBankSampahDashboard()
                      [METHOD NOT FOUND]

/tiket-sampah       → TiketsetorsampahController::indexV2()
                      ├─► Masyarakat::where(user_id)
                      └─► TiketSetorSampah::where(masyarakat_id)

/tiket-sampah POST  → TiketsetorsampahController::store()
                      ├─► Validate input
                      ├─► Setting::first()
                      ├─► TiketSetorSampah::create() [NO TRANSACTION]
                      └─► Update masyarakat [separate from above]

/admin/tiket/{id}   → TiketsetorsampahController::adminValidate()
                      ├─► TiketSetorSampah::find()
                      ├─► Masyarakat::find()
                      ├─► Setting::first()
                      ├─► $ticket->save() [NO TRANSACTION]
                      └─► $masyarakat->save()

/v2/edukasi         → [ROUTE TO VIEW, NOT CONTROLLER]
                      └─► Should be: ArtikelController::index()

/v2/sa/edukasi      → ArtikelController::index()
                      └─► Artikel::latest()->get() [NO PAGINATION]
```

---

## 24. SUMMARY: CRITICAL PATHS & STATUS

```
WORKING FLOWS (Production Ready):
✓ User registration with KTP upload
✓ Multi-role authentication & authorization
✓ Masyarakat verification workflow
✓ Deposit ticket creation (basic)
✓ Deposit ticket validation (basic)
✓ Point calculation and storage
✓ Voucher threshold logic
✓ Redemption ticket workflow
✓ Article CRUD by Super Admin
✓ System settings management

PARTIALLY WORKING (Needs Fixes):
⚠ Admin dashboard (data not passed)
⚠ QR scanning (no validation)
⚠ Education view (route mismatch)
⚠ History/Riwayat (incomplete)
⚠ Auto-increment (race condition)
⚠ File uploads (no virus scanning)

NOT WORKING (Missing Implementation):
✗ User profile editing
✗ Password change
✗ Download receipts
✗ Audit logging
✗ Bulk imports
✗ Data export
✗ Rate limiting
✗ Email notifications (partial)

DATA INTEGRITY RISKS:
🔴 High: Missing database transactions
🔴 High: Race condition in counters
🟡 Medium: N+1 queries causing slowness
🟡 Medium: File upload security gaps
🟡 Medium: Unvalidated QR redirects
```

---

**END OF DATA FLOW DIAGRAM ANALYSIS**

Generated: August 3, 2026
Total Lines: 1600+
Last Updated: Complete comprehensive analysis

For implementation roadmap, see RECOMMENDATIONS section.
For detailed bug list, see PROJECT_ANALYSIS.md.
For database schema, see CODEBASE_ANALYSIS.md.


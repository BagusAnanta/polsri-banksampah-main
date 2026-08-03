# BANK SAMPAH - DATA FLOW VISUAL SUMMARY
**Date:** August 3, 2026  
**Project:** Polsri Bank Sampah Management System

---

## EXECUTIVE SUMMARY

This document provides a quick-reference visual guide to the Bank Sampah system's data flows, organized by user role and operation type.

---

## 1. SYSTEM ARCHITECTURE AT A GLANCE

```
┌──────────────────────────────────────────────────────────────────┐
│                    USERS (Web Browsers)                          │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐           │
│  │ Masyarakat   │  │ Admin        │  │ Super Admin  │           │
│  │ (Public)     │  │ Bank Sampah  │  │ (Staff)      │           │
│  └──────────────┘  └──────────────┘  └──────────────┘           │
└──────────────────────────┬───────────────────────────────────────┘
                    HTTPS / Web Browser
                           ▼
┌──────────────────────────────────────────────────────────────────┐
│              LARAVEL 8+ APPLICATION SERVER                       │
│  Routes → Middleware → Controllers → Models → Business Logic     │
└──────────────────────────────────────────────────────────────────┘
                    Laravel ORM (Eloquent)
                           ▼
┌──────────────────────────────────────────────────────────────────┐
│              DATABASE (MySQL/SQLite)                             │
│  Users │ Masyarakat │ Tickets │ Articles │ Settings              │
└──────────────────────────────────────────────────────────────────┘
                    File Storage (public/ui/)
                           ▼
┌──────────────────────────────────────────────────────────────────┐
│         UPLOADED FILES (KTP, Articles, Avatars)                 │
└──────────────────────────────────────────────────────────────────┘
```

---

## 2. MASYARAKAT (PUBLIC USER) FLOW MAP

```
┌─────────────────────────────────────────────────────────────────┐
│                    MASYARAKAT USER JOURNEY                      │
└─────────────────────────────────────────────────────────────────┘

[1] REGISTRATION
    /register → Upload KTP Photo → Create User + Masyarakat
    Status: "Menunggu" (waiting for approval)
    ▼

[2] VERIFICATION QUEUE
    /v2/waiting → Display "Account under review"
    Super Admin reviews KTP → Approve/Reject
    Status: "Disetujui" (approved) or "Ditolak" (rejected)
    ▼

[3] LOGIN
    /login → Username/NIK + Password → Session Created
    Auto-redirect to /v2/dashboard
    ▼

[4] DASHBOARD VIEW
    /v2/dashboard
    ├─ KPI Cards: Current Points, Total Weight, Completed Deposits
    ├─ Chart: 6-Month Point Trend
    ├─ Recent Deposits (last 3)
    └─ Recent Redemptions (last 3)
    ▼

[5] DEPOSIT WORKFLOW
    /tiket-sampah → Create Deposit → Admin Validates → Points Added
    ├─ Status: Menunggu → Selesai/Ditolak
    ├─ Points: Calculated from actual weight
    └─ Balance: Updated on masyarakat profile
    ▼

[6] REDEMPTION WORKFLOW
    /tiket-poin → Create Redemption → Admin Approves → Points Deducted
    ├─ Status: Menunggu → Selesai/Ditolak
    ├─ Validation: User must have sufficient points
    └─ Voucher: Generated at threshold (default 500 points)
    ▼

[7] EDUCATION
    /v2/edukasi → View Articles (created by Super Admin)
    ├─ Read-only access
    └─ [BUG] Currently shows empty (route mismatch)
    ▼

[8] HISTORY
    /riwayat → View All Transactions
    ├─ Deposits and redemptions combined
    └─ [INCOMPLETE] View integration unclear
```

---

## 3. ADMIN BANK SAMPAH FLOW MAP

```
┌─────────────────────────────────────────────────────────────────┐
│                  ADMIN BANK SAMPAH JOURNEY                      │
└─────────────────────────────────────────────────────────────────┘

[1] LOGIN
    /login → Username/NIK + Password → Session Created
    Auto-redirect to /v2/admin/dashboard
    ▼

[2] DASHBOARD
    /v2/admin/dashboard
    ├─ [INCOMPLETE] Data not being passed to view
    ├─ Expected: KPI cards (pending, completed tickets)
    └─ Actual: Blank/error state
    ▼

[3] TICKET MANAGEMENT
    /v2/admin/tiket → List all tickets at this bank
    ├─ Filter by status: Menunggu / Selesai / Ditolak
    ├─ View ticket details
    └─ Validate/approve individual tickets
    ▼

[4] DEPOSIT VALIDATION
    /v2/admin/tiket/{id}/edit → Input actual weight
    ├─ Recalculate points based on actual weight
    ├─ Update ticket status: Selesai / Ditolak
    ├─ Update masyarakat profile (points, gramasi, count)
    └─ Check voucher threshold
    ▼

[5] REDEMPTION APPROVAL
    /v2/admin/tiket/{id}/edit → Approve/Reject
    ├─ Status: Menunggu → Selesai / Ditolak
    ├─ If Selesai: Deduct points from masyarakat
    ├─ Generate voucher if threshold reached
    └─ Confirmation displayed
    ▼

[6] QR SCANNING
    /v2/admin/scan → Activate camera
    ├─ Scan QR code on ticket
    ├─ [BUG] Direct redirect without validation
    └─ [FIX] Need UUID format check + existence verify
    ▼

[7] PROFILE
    /profile → View own bank account details
    └─ [MISSING] Edit functionality not implemented
```

---

## 4. SUPER ADMIN FLOW MAP

```
┌─────────────────────────────────────────────────────────────────┐
│                     SUPER ADMIN JOURNEY                         │
└─────────────────────────────────────────────────────────────────┘

[1] LOGIN
    /login → Username/NIK + Password → Session Created
    Auto-redirect to /v2/sa/dashboard
    ▼

[2] DASHBOARD
    /v2/sa/dashboard
    ├─ System-wide KPIs
    ├─ Total users, pending approvals, approved count
    ├─ Bank sampah count, article count
    └─ 12-month registration trend chart
    ▼

[3] MASYARAKAT MANAGEMENT
    /v2/sa/masyarakat
    ├─ View all community members
    ├─ Review pending registrations (with KTP photo)
    ├─ Approve/Reject verification
    ├─ Edit member details
    └─ Delete members
    ▼

[4] BANK SAMPAH MANAGEMENT
    /v2/sa/bank-sampah
    ├─ View all trash banks
    ├─ Create new bank accounts
    ├─ Edit bank details (address, hours, phone)
    └─ Delete banks
    ▼

[5] ARTICLE MANAGEMENT
    /v2/sa/edukasi
    ├─ Create educational articles
    ├─ Upload article images (auto-scaled)
    ├─ Edit existing articles (with image replacement)
    ├─ Delete articles (with file cleanup)
    └─ [BUG] User view doesn't load articles (route mismatch)
    ▼

[6] SYSTEM SETTINGS
    /v2/sa/pengaturan
    ├─ gram_per_point: Grams needed for 1 point (default: 10)
    ├─ point_per_voucher: Points needed for 1 voucher (default: 500)
    └─ Update conversion rates
    ▼

[7] FULL SYSTEM ACCESS
    ├─ View all tickets (deposits and redemptions)
    ├─ Override any validation decision
    ├─ Access all reports and dashboards
    └─ System configuration
```

---

## 5. DATA LIFECYCLE: DEPOSIT TICKET

```
CREATE PHASE
    User submits form
    ├─ masyarakat_id: User's profile
    ├─ banksampah_id: Selected bank
    ├─ berat_sampah: Estimated weight (user input)
    └─ poin: floor(berat_sampah / gram_per_point)
    
    Database State:
    ├─ tiketsampah: Created, status='Menunggu'
    ├─ masyarakat.poin: UNCHANGED (0 still)
    └─ masyarakat.total_gramasi: UNCHANGED

WAITING PHASE
    ├─ User sees: "Waiting for verification"
    ├─ Admin sees: Ticket in "Menunggu" list
    └─ Duration: Variable (depends on admin processing)

VALIDATION PHASE (Admin Action)
    Admin inputs: berat_sampah_actual (verified weight)
    
    If Ditolak (Rejected):
    ├─ tiketsampah.status = 'Ditolak'
    ├─ masyarakat.poin: NO CHANGE
    └─ Ticket marked as rejected

    If Selesai (Completed):
    ├─ New poin calculated: floor(actual_weight / gram_per_point)
    ├─ tiketsampah.poin: Updated with new value
    ├─ tiketsampah.status = 'Selesai'
    ├─ masyarakat.poin: += new poin value
    ├─ masyarakat.total_gramasi: += actual_weight
    ├─ masyarakat.total_selesai: += 1
    └─ Voucher count updated (if threshold crossed)

COMPLETION PHASE
    ├─ Ticket marked as "Selesai"
    ├─ User dashboard updates automatically
    ├─ Points now available for redemption
    └─ Transaction locked (no further edits)
```

---

## 6. DATA LIFECYCLE: REDEMPTION TICKET

```
CHECK BALANCE PHASE
    User navigates to /tiket-poin/create
    
    System calculates:
    ├─ completed_deposits = SUM(tiketsetor.poin WHERE status='Selesai')
    ├─ completed_redemptions = SUM(tiketpoin.poin WHERE status='Selesai')
    └─ available_poin = completed_deposits - completed_redemptions
    
    Display: "Available: X points"

CREATE PHASE
    User submits:
    ├─ masyarakat_id: User's profile
    ├─ banksampah_id: Selected bank
    └─ poin: Amount to redeem (must be <= available)
    
    Database State:
    ├─ tiketpoin: Created, status='Menunggu'
    ├─ masyarakat.poin: UNCHANGED (still original value)
    └─ Ticket locked to prevent over-redemption

WAITING PHASE
    ├─ User sees: "Waiting for admin approval"
    ├─ Admin sees: Ticket in "Menunggu" list
    └─ Points: Still counted in available balance

APPROVAL PHASE (Admin Action)
    If Ditolak (Rejected):
    ├─ tiketpoin.status = 'Ditolak'
    ├─ masyarakat.poin: NO CHANGE
    └─ Ticket marked as rejected

    If Selesai (Completed):
    ├─ tiketpoin.status = 'Selesai'
    ├─ masyarakat.poin: -= tiketpoin.poin
    ├─ masyarakat.voucher: += 1 (for this redemption)
    └─ Points deducted from available balance

COMPLETION PHASE
    ├─ Transaction locked
    ├─ Voucher issued to user
    ├─ Points no longer available for re-redemption
    └─ Transaction visible in history
```

---

## 7. KEY BUSINESS RULES

```
POINT CALCULATION RULES
├─ Formula: floor(weight_in_grams / gram_per_point)
├─ Default: 10 grams = 1 point
├─ Example: 150 grams → 15 points
└─ Applied: On both estimate (user input) and actual (admin verified)

VOUCHER GENERATION RULES
├─ Threshold: point_per_voucher (default: 500 points)
├─ When: Triggered when masyarakat.poin >= threshold
├─ Calculation: floor(total_poin / threshold)
├─ Example: 600 points → 1 voucher; 1100 points → 2 vouchers
└─ Method: Automatic, no manual action needed

STATUS TRANSITIONS
├─ Deposit Ticket:
│  └─ Menunggu → Selesai ✓ OR Ditolak
├─ Redemption Ticket:
│  └─ Menunggu → Selesai ✓ OR Ditolak
└─ User Registration:
   └─ Menunggu → Disetujui ✓ OR Ditolak

POINT BALANCE RULES
├─ Cannot go negative (validation on redemption)
├─ Only completed tickets count
├─ Pending tickets don't affect balance
├─ Rejected tickets refund points (if was completed then rejected)
└─ Real-time calculation (no caching)

ROLE-BASED ACCESS
├─ Masyarakat: Can only see own tickets
├─ Admin Bank: Can only see tickets at their bank
├─ Super Admin: Can see all tickets system-wide
└─ Cross-bank access: Forbidden (security model)
```

---

## 8. DATABASE RELATIONSHIPS QUICK VIEW

```
ONE USER HAS ONE MASYARAKAT PROFILE
    User 1 ──── Masyarakat 1
              └─ Tracks: points, voucher, gramasi, verification status

MASYARAKAT HAS MANY DEPOSIT TICKETS
    Masyarakat 1 ──── TiketSetorSampah 1
                   ├─ TiketSetorSampah 2
                   └─ TiketSetorSampah N

MASYARAKAT HAS MANY REDEMPTION TICKETS
    Masyarakat 1 ──── TiketTukarPoin 1
                   ├─ TiketTukarPoin 2
                   └─ TiketTukarPoin N

BANK SAMPAH HAS MANY TICKETS (Both types)
    BankSampahUser 1 ──── TiketSetorSampah 1,2,3...
                       ├─ TiketTukarPoin 1,2,3...
                       └─ Only tickets created/validated at this bank

SUPER ADMIN CREATED BANK SAMPAH
    User (Super Admin) ──── BankSampahUser 1
                         └─ created_by field tracks creator

SUPER ADMIN APPROVED MASYARAKAT
    User (Super Admin) ──── Masyarakat 1
                         └─ approved_by field tracks approver
```


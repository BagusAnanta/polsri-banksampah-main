# Analisis Arsitektur UI/UX — Aplikasi "Trash Bank" (Bank Sampah-Sekanak Connect)

Aplikasi ini adalah platform manajemen bank sampah digital dengan 4 konteks akses: **Guest/Auth**, **Masyarakat (Publik)**, **Admin Bank Sampah**, dan **Super Admin**. Total 20 layar teridentifikasi dari desain.

---

## 1. Component Hierarchy

```
App
├── AuthLayout (unauthenticated shell)
│   ├── SplitPanel
│   │   ├── FormColumn
│   │   │   ├── Logo (icon + wordmark)
│   │   │   ├── HeadingBlock (title + subtitle)
│   │   │   ├── FormField (label + input, variants: text, password w/ toggle, select, tel, file-upload)
│   │   │   ├── InlineLink ("Lupa password?", "Daftar sekarang")
│   │   │   ├── PrimaryButton (full-width, pill/rounded)
│   │   │   ├── DividerWithLabel ("atau")
│   │   │   └── FooterCopyright
│   │   └── PromoColumn (image background)
│   │       ├── BrandBadge (floating, top-left)
│   │       ├── Tagline (eyebrow + heading + description)
│   │       └── CarouselDots
│   └── ThemeToggleFAB (floating, bottom-left)
│
├── WaitingRoomLayout
│   ├── TopBar (logo + "Keluar" action)
│   ├── StatusCard (icon, status pill, heading, description, greeting)
│   ├── ProgressStepper (checklist: Pendaftaran / Verifikasi / Akses)
│   ├── InfoCard "Informasi Pendaftar" (icon-label-value rows)
│   └── InfoCard "Apa yang Bisa Kamu Lakukan" (notice box, ETA row, logout link)
│
├── AppShell (authenticated — shared across all roles)
│   ├── Sidebar (icon rail, collapsible)
│   │   ├── NavIcon[] (role-dependent set)
│   │   ├── HelpIcon (bottom)
│   │   └── UserAvatarBadge (bottom, initials)
│   ├── TopNavBar
│   │   ├── LogoBadge
│   │   ├── PillTabNav (primary nav, role-dependent)
│   │   ├── IconButton (search)
│   │   ├── IconButton (notifications, badge dot)
│   │   ├── IconButton (logout)
│   │   └── UserMenu (avatar + name + points/role + chevron)
│   └── PageContent (per-role, per-page)
│       ├── Breadcrumb (optional)
│       ├── PageHeader (title + subtitle + action button)
│       ├── StatCardRow (KPI cards, 3–5 columns)
│       ├── ChartCard (line/area/donut/bar)
│       ├── SidePanelCard (progress/info/action widgets)
│       ├── ListSection (title + "Lihat semua" link)
│       ├── ItemCard (ticket/user/article card — many variants)
│       ├── TicketDetailCard (centered receipt-style card)
│       ├── DataTable / CardGrid (list views)
│       ├── FormCard (create/edit forms)
│       ├── StatusBadge (Menunggu / Selesai / Ditolak / Dibatalkan)
│       └── Modal (QR scan popup)
```

**Reusable atomic components identified:**
- `Badge/Pill` (status, count, role)
- `IconTextRow` (icon + label/value, used in identity & info blocks)
- `StatCard` (label + big number + icon)
- `ActionCard` (icon + label, used as "Menu Cepat" quick links)
- `ProgressBar` (linear, with label + percentage)
- `Button` (primary/filled, secondary/outline, danger/soft-red, ghost/text)
- `Avatar` (initials-based, colored circle)
- `FormInput`, `FormSelect`, `FileDropzone`, `PasswordInput`
- `RichTextEditorToolbar` (B/I/U, headings, lists, quote, link)

---

## 2. Layout Structure

**Global grid pattern:** consistent warm beige/olive palette, generous card padding, soft rounded corners (~12–16px radius), no hard borders — separation via subtle background shade shifts.

| Layer | Structure |
|---|---|
| **Auth pages** | 2-column split (60/40) — form left, image/promo right, full-viewport height, centered content |
| **Waiting Room** | Top bar + 2×2 responsive card grid (asymmetric: 1 large left, stacked right) |
| **Authenticated shell** | Left icon-rail sidebar (fixed, ~64px) + top horizontal bar (logo, pill-tab nav, utility icons, user menu) + scrollable content area |
| **Dashboard pages** | Header → KPI stat row (grid, 3–5 cols) → 2-column split (chart 65% / side widget 35%) → 2-column list preview row |
| **List/Ticket pages** | Header w/ CTA → stat summary row (3 cols) → vertical stack of expandable ticket cards, OR 3-column masonry card grid (admin views) |
| **Detail/Ticket pages** | Single centered narrow card (receipt metaphor, max-width ~500px) with internal sections separated by dividers |
| **Form pages (Create)** | Centered single-column card, grouped fieldsets, actions pinned bottom |
| **Settings pages** | Vertical stack of labeled setting-group cards, single column, narrow max-width |

**Consistent structural rules:**
- Sidebar → Top bar → Breadcrumb → H1+subtitle → KPI row → Main content (this order repeats on nearly every internal page)
- Cards use a two-tone beige system: page background (lighter) vs. card background (slightly darker/tan) for depth without shadows
- Status-driven color coding: amber/yellow = pending (Menunggu), green = success (Selesai/Disetujui), red = rejected/cancelled (Ditolak/Dibatalkan/Batalkan)

---

## 3. Page Breakdown

### A. Authentication (3 pages)
1. **Login** — NIK + password form, split with promo image
2. **Register** — extended form incl. gender select, phone, email, address, KTP upload, password+confirm
3. **Waiting Room** — post-registration verification status screen

### B. Role: Masyarakat / Publik (7 pages)
1. Dashboard — stats (poin, gramasi, setoran selesai), poin/bulan chart, voucher progress widget, quick actions, recent ticket previews
2. Daftar Pengajuan Setor Sampah — list + stats + "Buat Tiket" CTA
3. Halaman Pengajuan Setor Sampah (create form) *
4. Detail Tiket Pengajuan Setor Sampah *
5. Daftar Pengajuan Tukar Voucher — list + stats + "Tukar Poin" CTA
6. Halaman Pengajuan Tukar Voucher (create form) *
7. Detail Tiket Pengajuan Tukar Voucher *

*(pages 3, 4, 6, 7 referenced in ToC but visual mockup not rendered in source PDF — inferred from surrounding pattern)*

### C. Role: Admin Bank Sampah (6 pages)
1. Dashboard — ticket stats (total/pending/selesai/poin pending), tickets-per-month dual-line chart, bank info card, scan QR CTA, pending ticket previews
2. Daftar Tiket Pengajuan Setoran Sampah — card grid, filter by status
3. Detail Tiket Pengajuan Setoran Sampah — validation form (gramasi aktual input → auto poin calc) + Setujui/Tolak
4. Daftar Tiket Pengajuan Penukaran Voucher — card grid
5. Detail Tiket Pengajuan Penukaran Voucher — Setujui & Terbitkan / Batalkan
6. Popup Scan QR Tiket — camera modal for ticket lookup

### D. Role: Super Admin (9 pages)
1. Dashboard — masyarakat/bank sampah/artikel counts, approval status donut chart, pendaftaran-per-bulan bar chart, navigation shortcuts
2. Daftar Masyarakat — tab-filtered (Menunggu/Disetujui/Ditolak) card grid
3. Peninjauan Pengajuan Akun Masyarakat — KTP review + approve/reject
4. Halaman Profil Masyarakat — read-only profile + point/gramasi totals
5. Daftar Admin/Bank Sampah — list of registered bank sampah units
6. Penambahan Akun Admin/Bank Sampah — create form (login creds + bank info)
7. Daftar Artikel Edukasi — color-coded content card grid, edit/hapus actions
8. Penambahan Artikel Edukasi — title, image upload, rich-text body editor
9. Pengaturan Sistem — conversion rate config (gram→poin, poin→voucher)

**Total: 25 distinct page/state entries in the ToC (20 with visible mockups).**

---

## 4. Responsive Behavior

| Breakpoint | Auth pages | App Shell / Dashboard | Cards/Lists |
|---|---|---|---|
| **Desktop (≥1024px)** | Full 2-column split preserved | Sidebar icon-rail + horizontal pill nav visible | 3–5 col stat rows, 3-col card grids |
| **Tablet (768–1023px)** | Promo column shrinks or drops image, form takes full width | Sidebar collapses to overlay/drawer; pill nav may convert to scrollable tabs | Stat row wraps to 2 cols; card grid to 2 cols |
| **Mobile (<768px)** | Single column, promo image hidden or moved to top as a banner strip | Sidebar becomes bottom nav bar or hamburger drawer; top bar condenses to logo + avatar + hamburger | Stat cards stack vertically (1 col); ticket cards full-width stacked; charts scale down, legend moves below |

**Specific responsive concerns per component:**
- **StatCardRow**: `grid-cols-3/5` → `grid-cols-2` → `grid-cols-1`, each card retains icon-left/number-right internal layout
- **TopNavBar pill tabs**: horizontal scroll with fade-edge on mobile rather than wrapping
- **TicketDetailCard**: fixed max-width (~500px) on desktop, becomes full-bleed with side padding on mobile
- **Split auth layout**: promo column is the first to disappear (order: hide image → stack vertically → hide entirely on very small screens)
- **QR Scan Modal**: full-screen takeover on mobile vs. centered dialog on desktop
- **Data/ticket card grid** (admin views): 3 cols → 2 cols → 1 col, cards keep internal padding constant, only column count changes
- **Sidebar icon rail**: persistent narrow rail on desktop; converts to slide-over drawer triggered by hamburger on mobile, or repositions as fixed bottom tab bar (5 icons max)
- **Charts** (line/donut/bar): maintain aspect ratio via container queries; data labels/legends reflow beneath the chart instead of beside it below ~640px

---

## 5. Tailwind Component Plan

> No code generated — this is a class/token planning reference only.

### Design Tokens (suggested `tailwind.config` extensions)
```
colors:
  background: warm beige (e.g. stone-100/amber-50 custom shade)
  surface: slightly darker tan (custom, e.g. #DCC9A3-ish)
  primary: olive/dark-green (buttons, active nav) — custom "olive-700"
  success: green-600 (Selesai/Disetujui)
  warning: amber-500 (Menunggu)
  danger: red-400/500 (soft red — Ditolak/Tolak/Batalkan)
  info: sky-100/blue-100 (notice boxes)
borderRadius:
  card: rounded-xl / rounded-2xl
  button: rounded-full or rounded-lg
  input: rounded-md
boxShadow: mostly none — rely on bg-color contrast (surface vs background) instead of shadow-*
```

### Component-to-utility mapping

| Component | Key Tailwind approach |
|---|---|
| `AuthSplitLayout` | `grid grid-cols-1 lg:grid-cols-2 min-h-screen` |
| `PromoImageColumn` | `relative bg-cover bg-center` + gradient overlay `bg-gradient-to-t from-black/60` |
| `FormField` | `flex flex-col gap-1.5` label `text-sm font-medium`, input `w-full rounded-md border-none bg-[surface] px-3 py-2 focus:ring-2 focus:ring-primary` |
| `PrimaryButton` | `w-full rounded-full bg-olive-700 text-white py-2.5 font-medium hover:bg-olive-800 transition` |
| `SecondaryOutlineButton` | `border border-current rounded-lg px-4 py-2 text-sm` |
| `DangerSoftButton` (Tolak/Batalkan) | `bg-red-100 text-red-600 hover:bg-red-200 rounded-lg` |
| `AppShell` | `flex h-screen`; sidebar `w-16 flex flex-col items-center py-4 gap-4`; main `flex-1 flex flex-col overflow-hidden` |
| `TopNavBar` | `flex items-center justify-between px-6 py-3` |
| `PillTabNav` | `flex gap-1 bg-[surface] rounded-full p-1` per tab `px-4 py-1.5 rounded-full text-sm data-[active]:bg-olive-700 data-[active]:text-white` |
| `StatCardRow` | `grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4` |
| `StatCard` | `bg-[surface] rounded-xl p-4 flex flex-col gap-1` |
| `ChartCard` | `bg-[surface] rounded-xl p-4 col-span-2` (paired with recharts/chart.js container `h-64 w-full`) |
| `SidePanelCard` (voucher progress etc.) | `bg-olive-700 text-white rounded-xl p-5` w/ `ProgressBar` as `h-2 rounded-full bg-white/30` inner `bg-white` |
| `ListSection` | `flex items-center justify-between mb-3` header + `text-sm text-olive-700 hover:underline` link |
| `TicketCard` (list item) | `bg-[surface] rounded-xl p-4 flex items-center justify-between gap-4` |
| `TicketDetailCard` | `mx-auto max-w-md bg-[surface-lighter] rounded-2xl p-6 divide-y divide-[background]` |
| `StatusBadge` | `inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium` + conditional color classes via variant map |
| `DataCardGrid` (admin masonry) | `grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4` |
| `ProgressStepper` (waiting room) | `flex flex-col gap-4` each step `flex items-start gap-3` icon circle `h-8 w-8 rounded-full flex items-center justify-center` |
| `FormCard` (create ticket/article) | `max-w-2xl mx-auto bg-[surface] rounded-2xl p-6 space-y-5` |
| `FileDropzone` | `border-2 border-dashed rounded-xl p-6 text-center cursor-pointer hover:bg-[surface]/50` |
| `RichTextToolbar` | `flex gap-1 border-b border-[background] pb-2 mb-2` buttons `p-1.5 rounded hover:bg-[background]` |
| `Modal/QRScanDialog` | `fixed inset-0 flex items-center justify-center bg-black/40` panel `bg-[surface-lighter] rounded-2xl p-6 w-full max-w-sm` |
| `Avatar` | `h-8 w-8 rounded-full bg-olive-200 flex items-center justify-center text-xs font-semibold` |
| `Sidebar NavIcon` | `h-10 w-10 rounded-full flex items-center justify-center data-[active]:bg-olive-700 data-[active]:text-white hover:bg-[surface]` |

### Suggested component file structure (React + Tailwind, no code shown)
```
/components
  /layout: AuthSplitLayout, AppShell, Sidebar, TopNavBar, PillTabNav
  /ui: Button, Badge, Avatar, ProgressBar, FormField, FileDropzone, Modal
  /cards: StatCard, ChartCard, SidePanelCard, TicketCard, TicketDetailCard, ArticleCard, UserCard
  /forms: LoginForm, RegisterForm, DepositTicketForm, VoucherRedeemForm, ArticleForm, BankSampahForm, SettingsForm
  /feature: WaitingRoomStatus, ProgressStepper, QRScanModal, RichTextEditorToolbar
```

---

## Notes & Gaps
- Pages **B.3, B.4, B.6, B.7** (Pengajuan Setor Sampah form, its detail ticket, Pengajuan Tukar Voucher form, its detail ticket) are listed in the table of contents but no screenshot was embedded in the source PDF — their structure above is inferred from the equivalent Admin-side detail card pattern (Setoran/Voucher detail) and should be validated against the actual design file.
- Dark mode: a moon/sun toggle icon appears floating on the Login screen, suggesting a light/dark theme switch is planned but not shown in later screens — worth confirming if theming should propagate app-wide.

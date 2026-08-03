# Polsri Bank Sampah - Technical Architecture & Flow Report (Version 1 - Legacy Monetary System)

This document provides a comprehensive technical analysis of **Version 1 (V1)** of the **Polsri Bank Sampah System**. It covers the legacy monetary waste deposit system, cash ledger balance accounting (`Tabungan`), e-commerce product marketplace, IT support ticket engine, and IoT smart trash bin monitoring.

---

## 1. V1 Executive Summary & Architecture

Version 1 is built on **Laravel 8+** with a MySQL database using standard primary keys (`id` auto-increment). The system operates on a direct cash-equivalent model where deposited waste is calculated based on predefined prices per gram, and citizens can request cash withdrawals from their accumulated savings balance.

```
+-----------------------------------------------------------------------------------+
|                           POLSRI BANK SAMPAH - VERSION 1                          |
+-----------------------------------------------------------------------------------+
| • Direct Monetary Waste Deposit (gram -> Rp)                                      |
| • Ledger Balance & Cash-out Withdrawal Management (Tabungan)                      |
| • Recycled Goods Marketplace (Product / Order)                                    |
| • Troubleshooting Support Ticket System & Automated Multi-Email Dispatch          |
| • IoT Smart Trash Bin Monitoring (Ultrasonic Sensors) & Solenoid Control          |
+-----------------------------------------------------------------------------------+
```

---

## 2. V1 Data Flow Diagrams (DFD) - Yourdon + De Marco Style

In accordance with the **Yourdon + De Marco** methodology, system processes are shown as numbered circles/ovals, data stores as open rectangles (`D1`, `D2`, etc.), external entities as rectangles, and data flows as directional arrows.

### 2.1 Level 0: Context Diagram (V1 Boundary)

The Context Diagram defines the external boundary of the V1 system, illustrating how actors interact with **Polsri Bank Sampah V1 System [Process 0.0]**.

```mermaid
graph TD
    %% External Entities
    E1["Nasabah / User (Citizen)"]
    E2["Admin Bank Sampah"]
    E3["IT Administrator"]
    E4["IoT Ultrasonic & Solenoid Hardware"]
    E5["Email Server (SMTP Notification Mail)"]

    %% Process 0.0
    P0(("0.0<br>Polsri Bank Sampah<br>V1 Monetary System"))

    %% Data Flows E1
    E1 -->|"User Auth, Waste Deposit (qty), Cash-Out Request, Marketplace Orders, Bin Complaints, Support Ticket"| P0
    P0 -->|"Approval Status, Tabungan Saldo, PDF Slips, Order Status, Ticket Updates"| E1

    %% Data Flows E2
    E2 -->|"Login, Review Pending Deposits, Validate Deposits, Approve Cash Withdrawals, Manage Products"| P0
    P0 -->|"Pending Deposit List, Cash Withdrawal Requests, Sales Analytics, Customer Records"| E2

    %% Data Flows E3
    E3 -->|"Manage Ticket Status (Proses/Selesai), Assign Agents"| P0
    P0 -->|"Open Ticket Queue, Ticket Diagnostic Documents"| E3

    %% Data Flows E4
    E4 -->|"Ultrasonic Bin Level Logs (cm), Solenoid Switch Status"| P0
    P0 -->|"Solenoid Relay Toggle Command"| E4

    %% Data Flows E5
    P0 -->|"Support Ticket Alert Emails (TicketAddedMail)"| E5
```

---

### 2.2 Level 1: Subsystem Process Decomposition (V1)

Level 1 partitions **Process 0.0** into five core functional sub-systems for V1.

```mermaid
graph TD
    %% External Entities
    E1["Nasabah (User)"]
    E2["Admin Bank Sampah"]
    E3["IT Administrator"]
    E4["IoT Hardware"]
    E5["Email Server"]

    %% Data Stores
    D1[("D1: users")]
    D2[("D2: jenis_sampahs & bank_sampahs")]
    D3[("D3: tabungans")]
    D4[("D4: products & orders")]
    D5[("D5: box_sampahs & sensor_logs")]
    D6[("D6: tickets & upload_docs")]

    %% Level 1 Processes
    P1(("1.0<br>Authentication &<br>User Profile Management"))
    P2(("2.0<br>Waste Deposit &<br>Ledger Balance (Tabungan)"))
    P3(("3.0<br>Marketplace E-Shop &<br>Order Management"))
    P4(("4.0<br>IoT Smart Bin &<br>Solenoid Control"))
    P5(("5.0<br>IT Support Ticket &<br>Email Notification"))

    %% Data Flows P1
    E1 -->|"Login Credentials & Profile Update"| P1
    P1 <--> D1

    %% Data Flows P2
    E1 -->|"Submit Deposit Request (qty per waste ID)"| P2
    E1 -->|"Submit Cash Withdrawal Request"| P2
    E2 -->|"Validate Deposit & Approve Saldo Kredit"| P2
    P2 <--> D2
    P2 <--> D3

    %% Data Flows P3
    E1 -->|"Place Recycled Product Order"| P3
    E2 -->|"Update Order Status (Proses/Selesai)"| P3
    P3 <--> D4

    %% Data Flows P4
    E4 -->|"Log Fill Distance (cm)"| P4
    E1 -->|"Submit Bin Complaint"| P4
    E2 -->|"Toggle Solenoid Relay"| P4
    P4 <--> D5

    %% Data Flows P5
    E1 -->|"Create Support Ticket & Attach Files"| P5
    E3 -->|"Update Ticket Status"| P5
    P5 -->|"Send Mail Alert"| E5
    P5 <--> D6
```

---

### 2.3 Level 2: Detailed Process Flow (V1 Waste Deposit & Balance Credit)

```mermaid
graph TD
    E1["Nasabah"] -->|"1. Submit Waste Form (qty)"| P2_1(("2.1<br>Save Pending<br>BankSampah Entry"))
    P2_1 -->|"INSERT status: 'Pending'"| D2[("D2: bank_sampahs")]
    
    E2["Admin"] -->|"2. View Pending Requests"| P2_2(("2.2<br>Audit & Group<br>by User"))
    D2 -->|"Return Pending Items"| P2_2
    
    E2 -->|"3. Submit Approval (Approved/Gagal)"| P2_3(("2.3<br>Update Status &<br>Calculate Balance"))
    D2_Sub[("D2: jenis_sampahs")] -->|"Fetch Price/Gram"| P2_3
    
    P2_3 -->|"Calculate: total = sum(qty * harga)"| P2_3
    P2_3 -->|"UPDATE bank_sampahs status = 'approved'"| D2
    P2_3 -->|"Fetch Previous Balance"| D3[("D3: tabungans")]
    P2_3 -->|"INSERT tabungans (debit = total, sisa_saldo = prev + total, status = 'approved')"| D3
    P2_3 -->|"4. Return Success Banner"| E2
```

---

## 3. V1 Entity Relationship Diagram (ERD) & Data Dictionary

### 3.1 Visual Entity Relationship Diagram (V1 Mermaid ERD)

Below is the database structure containing all 15 V1 entities, primary keys, foreign keys, data types, and cardinalities.

```mermaid
erDiagram
    users ||--o{ users : "registered_by (1:N)"
    users ||--o{ bank_sampahs : "submits (1:N)"
    users ||--o{ tabungans : "owns balance (1:N)"
    users ||--o{ orders : "places order (1:N)"
    users ||--o{ tickets : "creates (1:N)"
    users ||--o{ upload_doc_tickets : "uploads (1:N)"
    users ||--o{ upload_doc_troubles : "uploads (1:N)"
    users ||--o{ laporan_pengaduans : "reports (1:N)"

    jenis_sampahs ||--o{ bank_sampahs : "categorizes (1:N)"
    bank_sampahs ||--o{ tabungans : "generates debit (1:N)"
    products ||--o{ orders : "contains (1:N)"
    box_sampahs ||--o{ laporan_pengaduans : "subject of (1:N)"
    tickets ||--o{ upload_doc_tickets : "has docs (1:N)"
    tickets ||--o{ upload_doc_troubles : "has trouble docs (1:N)"

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

    jenis_sampahs {
        bigint id PK
        string nama
        text catatan
        string gambar
        int harga
        double gramasi
    }

    bank_sampahs {
        bigint id PK
        bigint jenis_sampah_id FK
        bigint user_id FK
        int qty
        string tanggal_setor
        enum status
    }

    tabungans {
        bigint id PK
        bigint bank_sampah_id FK
        bigint user_id FK
        date tanggal
        decimal debit
        decimal kredit
        decimal sisa_saldo
        string status
    }

    products {
        bigint id PK
        string name
        int price
        text description
        string image
    }

    orders {
        bigint id PK
        bigint product_id FK
        bigint user_id FK
        int qty
        decimal total_price
        enum status
        date date
    }

    box_sampahs {
        bigint id PK
        string id_box
        decimal latitude
        decimal longitude
        text description
    }

    laporan_pengaduans {
        bigint id PK
        bigint box_sampah_id FK
        bigint user_id FK
        text catatan
    }

    tickets {
        bigint id PK
        bigint user_id FK
        string nomor_tiket
        string tanggal
        string judul
        text deskripsi
        string status
        bigint closed_by FK
        bigint progress_by FK
    }

    upload_doc_tickets {
        bigint id PK
        string file_upload
        bigint ticket_id FK
        bigint user_id FK
    }

    upload_doc_troubles {
        bigint id PK
        string file_upload
        bigint ticket_id FK
        bigint user_id FK
    }

    sensor_logs {
        bigint id PK
        string sensor_name
        float value
        boolean status
    }

    sensor_selenoids {
        bigint id PK
        string sensor_name
        boolean status
    }

    notification_mails {
        bigint id PK
        string email
    }

    riwayat_setors {
        bigint id PK
    }
```

---

### 3.2 V1 Data Dictionary (15 Eloquent Models & Database Tables)

| Model Class Name | DB Table Name | Primary Key | Attributes / `$fillable` | Data Types & Defaults | Key Eloquent Relationships |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **`User`** | `users` | `id` (bigint) | `user_code`, `name`, `username`, `email`, `password`, `registered_by`, `avatar`, `phone`, `no_rekening`, `bank`, `address` | Bigint PK Auto-increment, `user_code` default '0' | - `tabungans()`: hasMany `Tabungan`<br>- `orders()`: hasMany `Order`<br>- `registeredBy()`: belongsTo `User` |
| **`JenisSampah`** | `jenis_sampahs` | `id` (bigint) | `nama`, `catatan`, `gambar`, `harga`, `gramasi` | Bigint PK Auto-increment, `harga` int, `gramasi` double | - dynamic accessor `getQtyAttribute()` |
| **`BankSampah`** | `bank_sampahs` | `id` (bigint) | `jenis_sampah_id`, `user_id`, `qty`, `tanggal_setor`, `status` | Bigint PK Auto-increment, `status` enum ('Pending','Approved','Gagal') | - `user()`: belongsTo `User`<br>- `jenisSampah()`: belongsTo `JenisSampah`<br>- `tabungan()`: hasMany `Tabungan` |
| **`Tabungan`** | `tabungans` | `id` (bigint) | `bank_sampah_id`, `user_id`, `tanggal`, `debit`, `kredit`, `sisa_saldo`, `status` | Bigint PK Auto-increment, `debit`/`kredit`/`sisa_saldo` decimal(10,2) | - `bankSampah()`: belongsTo `BankSampah`<br>- `user()`: belongsTo `User` |
| **`Product`** | `products` | `id` (bigint) | `name`, `price`, `description`, `image` | Bigint PK Auto-increment, `price` int | - `orders()`: hasMany `Order` |
| **`Order`** | `orders` | `id` (bigint) | `product_id`, `user_id`, `qty`, `total_price`, `description`, `status`, `date` | Bigint PK Auto-increment, `status` enum ('pending','proses','selesai','batal') | - `user()`: belongsTo `User`<br>- `product()`: belongsTo `Product` |
| **`BoxSampah`** | `box_sampahs` | `id` (bigint) | `id_box`, `latitude`, `longitude`, `description` | Bigint PK Auto-increment, `id_box` unique, lat/long decimal | - `laporanPengaduan()`: hasMany `LaporanPengaduan` |
| **`LaporanPengaduan`**| `laporan_pengaduans`| `id` (bigint) | `box_sampah_id`, `user_id`, `catatan` | Bigint PK Auto-increment, FK `box_sampah_id`, FK `user_id` | - `boxSampah()`: belongsTo `BoxSampah`<br>- `user()`: belongsTo `User` |
| **`Ticket`** | `tickets` | `id` (bigint) | `nomor_tiket`, `tanggal`, `judul`, `deskripsi`, `status`, `user_id`, `closed_by`, `progress_by` | Bigint PK Auto-increment, auto-generated ticket code string | - `user()`: belongsTo `User`<br>- `uploadDocTicket()`: hasMany `UploadDocTicket`<br>- `uploadDocTrouble()`: hasMany `UploadDocTrouble` |
| **`UploadDocTicket`** | `upload_doc_tickets`| `id` (bigint) | `file_upload`, `ticket_id`, `user_id` | Bigint PK Auto-increment, FK `ticket_id`, FK `user_id` | - `ticket()`: belongsTo `Ticket`<br>- `user()`: belongsTo `User` |
| **`UploadDocTrouble`**| `upload_doc_troubles`| `id` (bigint) | `file_upload`, `ticket_id`, `user_id` | Bigint PK Auto-increment, FK `ticket_id`, FK `user_id` | - `ticket()`: belongsTo `Ticket`<br>- `user()`: belongsTo `User` |
| **`sensorLog`** | `sensor_logs` | `id` (bigint) | `sensor_name`, `value`, `status` | Bigint PK Auto-increment, `value` float, `status` boolean | Physical ultrasonic bin logs |
| **`sensorSelenoid`** | `sensor_selenoids` | `id` (bigint) | `sensor_name`, `status` | Bigint PK Auto-increment, `status` boolean | Physical solenoid switches |
| **`NotificationMail`** | `notification_mails`| `id` (bigint) | `email` | Bigint PK Auto-increment, email string | Email notification target list |
| **`RiwayatSetor`** | `riwayat_setors` | `id` (bigint) | `timestamps` | Bigint PK Auto-increment | Legacy helper table |

---

## 4. V1 Core Application Flows (Sequence Diagrams)

### Flow A: V1 Waste Deposit & Balance Management Flow

This sequence details how a citizen submits a daily waste deposit and how an admin validates it to credit their cash balance (`Tabungan`).

```mermaid
sequenceDiagram
    autonumber
    actor Nasabah as Nasabah (User)
    actor Admin as Admin Bank Sampah
    participant Controller as BankSampahController
    participant DB as MySQL Database

    Nasabah->>Controller: GET /v1/bank_sampahs/create
    Controller->>DB: Fetch active JenisSampah (nama, harga, gramasi)
    DB-->>Controller: Return waste categories
    Controller-->>Nasabah: Render deposit form with pricing

    Nasabah->>Controller: POST /v1/bank_sampahs (qty per jenis_sampah_id)
    loop For each item with qty > 0
        Controller->>DB: INSERT INTO bank_sampahs (user_id, jenis_sampah_id, qty, status = 'Pending')
    end
    DB-->>Controller: Records saved
    Controller-->>Nasabah: Redirect to index with success alert

    Admin->>Controller: GET /v1/bank_sampahs (filter pending)
    Controller->>DB: Fetch users with pending BankSampah entries
    DB-->>Controller: Return pending request list
    Controller-->>Admin: Display pending requests table

    Admin->>Controller: PUT /v1/bank-sampah/update-status/{user_id} (status: 'approved' / 'gagal')
    alt Status: Approved
        loop For all user pending items
            Controller->>DB: UPDATE bank_sampahs SET status = 'approved' WHERE user_id AND status = 'Pending'
            Controller->>DB: Multiply qty * harga to compute subtotal
        end
        Controller->>DB: Query last Tabungan record for user
        Controller->>DB: INSERT INTO tabungans (bank_sampah_id, user_id, debit = total, sisa_saldo = prev_saldo + total, status = 'approved')
    else Status: Rejected / Gagal
        Controller->>DB: UPDATE bank_sampahs SET status = 'gagal' WHERE user_id AND status = 'Pending'
    end
    DB-->>Controller: Commit transaction
    Controller-->>Admin: Redirect back with success message
```

---

### Flow B: V1 Cash Withdrawal / Balance Cash-Out Flow

This sequence describes how a citizen requests a cash withdraw (kredit) from their accumulated savings balance.

```mermaid
sequenceDiagram
    autonumber
    actor Nasabah as Nasabah (User)
    actor Admin as Admin Bank Sampah
    participant Controller as TransaksiController
    participant DB as MySQL Database

    Nasabah->>Controller: POST /v1/transaksi/update (kredit_amount)
    Controller->>DB: Fetch user's last approved Tabungan (current sisa_saldo)
    
    alt Requested kredit > current sisa_saldo
        Controller-->>Nasabah: Validation Error ("Saldo tidak mencukupi")
    else Balance is sufficient
        Controller->>DB: INSERT INTO tabungans (user_id, bank_sampah_id, kredit = requested, sisa_saldo = current_saldo, status = 'pending')
        DB-->>Controller: Withdrawal request created
        Controller-->>Nasabah: Redirect to transaction index with pending badge
    end

    Admin->>Controller: GET /v1/admin/tabungan
    Controller->>DB: SELECT * FROM tabungans WHERE kredit > 0 AND status = 'pending'
    DB-->>Controller: Return pending cash-out list
    Controller-->>Admin: Display pending withdrawal table

    Admin->>Controller: PATCH /v1/transaksi/{id}/approve
    Controller->>DB: Find pending Tabungan record by ID
    Controller->>DB: Query latest approved debit balance for user
    Controller->>DB: Calculate new sisa_saldo = latest_debit - kredit
    
    alt New sisa_saldo < 0
        Controller-->>Admin: Return error ("Insufficient funds")
    else Balance OK
        Controller->>DB: UPDATE tabungans SET status = 'approved', debit = latest_debit, sisa_saldo = new_sisa_saldo WHERE id = $id
        DB-->>Controller: Commit update
        Controller-->>Admin: Redirect with success confirmation
    end
```

---

### Flow C: V1 E-Commerce Marketplace & Product Ordering Flow

This sequence describes how a citizen places an order for recycled products and how an admin manages fulfillment.

```mermaid
sequenceDiagram
    autonumber
    actor Nasabah as Nasabah (User)
    actor Admin as Admin Bank Sampah
    participant ListCtrl as ListproductController
    participant OrderCtrl as OrderController
    participant DB as MySQL Database

    Nasabah->>ListCtrl: GET /v1/products-list
    ListCtrl->>DB: SELECT * FROM products
    DB-->>ListCtrl: Return product catalog
    ListCtrl-->>Nasabah: Render product catalog grid

    Nasabah->>OrderCtrl: POST /v1/orders (product_id, qty, description)
    OrderCtrl->>DB: SELECT price FROM products WHERE id = $product_id
    DB-->>OrderCtrl: Return product price
    OrderCtrl->>OrderCtrl: Compute total_price = qty * price
    OrderCtrl->>DB: INSERT INTO orders (product_id, user_id, qty, total_price, description, status = 'pending', date = current_date)
    DB-->>OrderCtrl: Order created
    OrderCtrl-->>Nasabah: Redirect to My Orders list

    Admin->>OrderCtrl: GET /v1/orders
    OrderCtrl->>DB: SELECT * FROM orders WITH (user, product)
    DB-->>OrderCtrl: Return orders list
    OrderCtrl-->>Admin: Render admin orders table

    Admin->>OrderCtrl: POST /v1/orders/{order}/update-status (status: 'proses' / 'selesai' / 'batal')
    OrderCtrl->>DB: UPDATE orders SET status = new_status WHERE id = $order_id
    DB-->>OrderCtrl: Order updated
    OrderCtrl-->>Admin: Redirect back with status updated
```

---

### Flow D: V1 IT Support Ticket & Automated Email Dispatch

This flow describes submitting an IT support ticket, uploading diagnostic files, and triggering automated SMTP mail alerts.

```mermaid
sequenceDiagram
    autonumber
    actor User as User (Staff / Citizen)
    actor IT as IT Administrator
    participant TicketCtrl as TicketController
    participant DB as MySQL Database
    participant Mail as Mail Service (TicketAddedMail)

    User->>TicketCtrl: POST /v1/tickets (tanggal, judul, deskripsi, doc_troubles[])
    TicketCtrl->>DB: BEGIN TRANSACTION
    TicketCtrl->>DB: Generate code TICKET-000X-USERNAME-DATE
    TicketCtrl->>DB: INSERT INTO tickets (nomor_tiket, user_id, judul, deskripsi, status = 'pending')
    
    loop For each attached file
        TicketCtrl->>DB: Upload file to public/doc_troubles/ & INSERT INTO upload_doc_troubles (ticket_id, user_id, file_upload)
    end

    TicketCtrl->>DB: SELECT email FROM notification_mails
    DB-->>TicketCtrl: Return registered email targets

    loop For each recipient email
        TicketCtrl->>Mail: Send TicketAddedMail(ticketDetails)
    end
    
    TicketCtrl->>DB: COMMIT TRANSACTION
    TicketCtrl-->>User: Redirect to tickets list with success message

    IT->>TicketCtrl: PATCH /v1/tickets/{id}/update-status (status: 'proses' / 'selesai')
    TicketCtrl->>DB: UPDATE tickets SET status = new_status, progress_by = current_user / closed_by = current_user WHERE id = $id
    DB-->>TicketCtrl: Record updated
    TicketCtrl-->>IT: Redirect back with status update
```

---

### Flow E: V1 Smart Bin Capacity Logging & Solenoid Control Switch

This sequence describes IoT ultrasonic bin fill-level logging and real-time solenoid relay control via Node.js WebSockets.

```mermaid
sequenceDiagram
    autonumber
    actor Sensor as IoT Ultrasonic Hardware
    actor Admin as System Operator
    participant MonCtrl as MonitoringController
    participant DB as MySQL Database
    participant Socket as Node.js WebSocket Server

    Sensor->>MonCtrl: POST /api/sensor/log (sensor_name, value, status)
    MonCtrl->>DB: INSERT INTO sensor_logs (sensor_name, value, status)
    DB-->>MonCtrl: Log stored
    MonCtrl-->>Sensor: HTTP 200 OK Response

    Admin->>MonCtrl: GET /v1/monitoring/sensor
    MonCtrl->>DB: SELECT * FROM sensor_logs ORDER BY created_at DESC LIMIT 50
    DB-->>MonCtrl: Return capacity logs
    MonCtrl-->>Admin: Render 4-bin Fill Level Dashboard (Ultrasonic cm metrics)

    Admin->>MonCtrl: GET /v1/control/selenoid
    MonCtrl->>DB: SELECT * FROM sensor_selenoids
    DB-->>MonCtrl: Return active solenoids list
    MonCtrl-->>Admin: Render Solenoid Toggle Switches UI

    Admin->>Socket: Socket.emit('selenoid', { topic: 'bin_1_lock', status: true })
    Socket->>Sensor: Transmit MQTT/WebSocket Payload (Relay ON)
    Sensor-->>Socket: Acknowledge Relay Status
    Socket-->>Admin: Update Switch State UI (Real-time Feedback)
```

---

## 5. V1 Controller Execution & Method Mapping Matrix

Below is a complete matrix mapping all V1 controllers to routed endpoints, middleware permissions, and database operations.

```
+------------------------------+-------------------------------------+-----------------------------+------------------------------------+
| Controller Class             | Endpoint Route Prefix               | Middleware / Role           | Key Responsibilities & Methods     |
+------------------------------+-------------------------------------+-----------------------------+------------------------------------+
| AuthController               | /v1/users, /login, /register        | web, role:Super Admin/Admin | login(), register(), listUsers(),  |
|                              |                                     |                             | createUser(), storeUser(), edit()  |
| BankSampahController         | /v1/bank_sampahs                    | auth:web, role:Admin        | index(), create(), store(),        |
|                              |                                     |                             | detail(), updateStatus()           |
| TransaksiController          | /v1/transaksi, /v1/admin/tabungan   | auth:web, role:Admin        | index(), updateKredit(),           |
|                              |                                     |                             | adminIndex(), approvedKredit()     |
| JenisSampahController        | /v1/jenis_sampahs                   | auth:web, role:Admin        | Waste category pricing CRUD        |
| ProductController            | /v1/data-products                   | auth:web, role:Admin        | Admin product catalog management   |
| ListproductController        | /v1/products-list                   | auth:web                    | Citizen product catalog view       |
| OrderController              | /v1/orders, /v1/my-orders           | auth:web                    | index(), store(), update status    |
| TicketController             | /v1/tickets                         | auth:web                    | store(), uploadDocTrouble(),       |
|                              |                                     |                             | updateStatus(), deleteDoc()        |
| BoxSampahController          | /v1/box-sampahs                     | auth:web                    | Smart bin coordinates CRUD         |
| LaporanPengaduanController   | /v1/laporan-pengaduans              | auth:web                    | store(), indexNasabah(), showAdmin |
| MonitoringController         | /v1/monitoring/sensor               | auth:web                    | index(), selenoidControl()         |
| NotificationMailController   | /v1/notification-mails              | auth:web                    | Target recipient emails CRUD       |
| RiwayatSetorController       | /v1/riwayat-setor/{month?}          | auth:web                    | index(), monthly PDF summary generator |
| DashboardController          | /v1/dashboard, /v1/maps             | auth:web                    | index(), maps(), search()          |
+------------------------------+-------------------------------------+-----------------------------+------------------------------------+
```

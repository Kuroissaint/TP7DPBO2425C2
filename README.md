# 🧪 Potion Shop — RPG Themed Online Store

Website ini mengusung tema **Toko Potion** seperti yang biasa ada di dalam game RPG.  
Produk yang dijual berupa **Potion** dengan berbagai efek seperti pemulihan HP, peningkatan kekuatan, hingga buff status karakter lainnya.  
Selain itu, terdapat sistem **Voucher** untuk memberikan diskon, serta **Transaction** untuk mencatat setiap pembelian yang dilakukan pemain.

---

## 🗄️ Database Structure

Struktur basis data terdiri dari tiga tabel utama yang saling berelasi:

<img width="531" height="358" alt="Database Diagram" src="https://github.com/user-attachments/assets/b96dda8e-0abc-4747-b6d3-9d1480dfa235" />

---

### ⚗️ 1. Product

Menyimpan data seluruh potion yang tersedia di toko.

| Atribut | Tipe Data | Keterangan |
|----------|------------|------------|
| **ID** | `INT(11)` | Primary Key, identitas unik tiap produk |
| **Name** | `VARCHAR(255)` | Nama potion |
| **Effect** | `VARCHAR(100)` | Deskripsi efek potion (misal: "Heal HP +50") |
| **Price** | `INT(20)` | Harga potion dalam gold |
| **Stock** | `INT(11)` | Jumlah stok yang tersedia *(default: 0)* |

🧩 **Relasi:** Satu `Product` dapat muncul di banyak `Transaction`.

---

### 🎟️ 2. Voucher

Menyimpan data voucher diskon yang dapat digunakan pemain saat membeli potion.

| Atribut | Tipe Data | Keterangan |
|----------|------------|------------|
| **ID** | `INT(11)` | Primary Key, identitas unik tiap voucher |
| **Name** | `VARCHAR(100)` | Nama voucher |
| **Description** | `VARCHAR(100)` | Penjelasan singkat voucher |
| **Discount** | `INT(2)` | Persentase potongan harga (contoh: 20 untuk diskon 20%) |

💡 **Relasi:** Satu `Voucher` dapat digunakan pada banyak `Transaction`.

---

### 💰 3. Transaction

Mencatat setiap pembelian yang dilakukan pengguna.

| Atribut | Tipe Data | Keterangan |
|----------|------------|------------|
| **ID** | `INT(11)` | Primary Key, identitas unik transaksi |
| **product_id** | `INT(11)` | Foreign Key mengacu ke `Product.ID` |
| **voucher_id** | `INT(11)` | Foreign Key mengacu ke `Voucher.ID` |
| **quantity** | `INT(11)` | Jumlah potion yang dibeli |
| **buying_date** | `DATETIME` | Waktu transaksi dilakukan |
| **total_price** | `INT(11)` | Total harga yang dibayar setelah diskon |

🧾 **Relasi:**  
- Setiap `Transaction` berhubungan dengan satu `Product` dan (opsional) satu `Voucher`.

---

## 🧱 Hubungan Antar Tabel

- **Product → Transaction** : One-to-Many  
  Satu produk bisa muncul di banyak transaksi.
- **Voucher → Transaction** : One-to-Many  
  Satu voucher bisa digunakan di beberapa transaksi.

---



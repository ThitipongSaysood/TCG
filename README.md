# CARD ZONE — The Ultimate TCG Marketplace

แพลตฟอร์มซื้อขายซองการ์ด · เปิด Live สด · ประมูล PSA สำหรับนักสะสม TCG
(Pokémon · ONE PIECE · Dragon Ball · Digimon · Yu-Gi-Oh! ฯลฯ)

> สถานะ: **Scaffold v0.1** — โครงสร้าง Laravel + UI mockup + Auth พื้นฐาน
> ดูแผนดีไซน์ที่ [design.md](design.md) · สคีมา DB ที่ [database.md](database.md)

---

## Tech Stack

| Layer | เลือกใช้ |
|---|---|
| Framework | **Laravel 11** (PHP 8.4) |
| Templating | Blade |
| Database | MySQL/MariaDB · DB `siamcard` (remote production) |
| Frontend | Vanilla CSS/JS — Glassmorphism, mobile-first |
| Auth | REST API · Laravel Sanctum (token) + Socialite — รองรับ Email / LINE / Google |

---

## โครงสร้างโปรเจค

```
TCG/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/AuthController.php       # login / register / logout
│   │   └── PageController.php            # mockup pages
│   └── Models/User.php                   # display_name, phone, membership_tier ...
├── database/migrations/                  # 0001 users · 2026_05_23_* domain tables
├── public/
│   ├── assets/css/style.css              # design tokens + components
│   ├── assets/js/main.js                 # navbar / drawer / gallery / countdown
│   └── assets/images/                    # การ์ดจริง 15 ใบ (One Piece + Pokémon)
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── partials/{navbar,drawer,tabbar,footer}.blade.php
│   ├── auth/{login,register}.blade.php
│   ├── home.blade.php
│   ├── products/{index,show}.blade.php
│   ├── auctions/{index,show}.blade.php
│   ├── live/index.blade.php
│   ├── cart/index.blade.php · checkout/index.blade.php
│   ├── collection/index.blade.php · orders/index.blade.php
│   ├── profile/show.blade.php · psa/index.blade.php
│   └── tracking/show.blade.php
├── routes/web.php
├── design.md · database.md
└── composer.json
```

---

## Setup

```bash
# ติดตั้ง dependencies
composer install

# คัดลอก .env แล้วสร้าง APP_KEY
cp .env.example .env
php artisan key:generate

# (ตัวเลือก) ใช้ MySQL — แก้ค่า DB_* ใน .env
# DB_CONNECTION=mysql
# DB_DATABASE=tcg
# DB_USERNAME=root
# DB_PASSWORD=

# Default (.env ที่ออกพร้อม scaffold) ใช้ sqlite — ไฟล์อยู่ที่ database/database.sqlite
php artisan migrate

# เริ่มเซิร์ฟเวอร์
php artisan serve
# เปิด http://127.0.0.1:8000
```

---

## Routes หลัก

| URL | ชื่อ Route | หน้า |
|---|---|---|
| `/` | `home` | หน้าแรก — Live, Booster, Auction Hot |
| `/products` · `/products/{id}` | `products.index/show` | Booster Pack |
| `/auctions` · `/auctions/{id}` | `auctions.index/show` | ประมูล |
| `/live` | `live.index` | Live Opening Queue |
| `/login` · `/register` · `/logout` | `login/register/logout` | Auth |
| `/cart` · `/checkout` | `cart.index/checkout.index` | (auth) ตะกร้า + ชำระเงิน |
| `/my-collection` · `/my-orders` | `collection.index/orders.index` | (auth) Collection · Orders |
| `/profile` · `/psa-submission` · `/tracking/{id}` | — | (auth) โปรไฟล์ · PSA · Tracking |

---

## Database

ดูสคีมาเต็มที่ [database.md](database.md) — แยกเป็น 8 หมวด:
1. ผู้ใช้: `users` · `wallets` · `wallet_transactions` · `addresses`
2. แคตตาล็อก: `games` · `sets` · `shops` · `products` · `product_serials` (Absolute Tracking)
3. คำสั่งซื้อ: `orders` · `order_items` · `shipments`
4. Live: `live_sessions` · `live_queues`
5. ประมูล: `auctions` · `bids`
6. คลัง: `collection_items` · `wishlists`
7. PSA / Buy-Back: `psa_submissions` · `psa_items` · `buyback_listings` · `buyback_requests`
8. ระบบ: `membership_tiers` · `notifications` · `audit_logs`

---

## Roadmap ถัดไป

- [ ] เชื่อม controllers กับ Eloquent (ตอนนี้แสดง mockup ล้วน)
- [ ] Seeder ข้อมูลตัวอย่าง (games / sets / shops / products)
- [x] LINE / Google Login (Socialite) — REST API พร้อมใช้งาน
- [ ] PromptPay QR + Webhook ยืนยันการชำระ
- [ ] Real-time bidding & live queue (Laravel Reverb / WebSockets)
- [ ] Filament panel สำหรับ Admin / Seller Dashboard
- [ ] PSA submission workflow + sync เกรดผลกลับ collection

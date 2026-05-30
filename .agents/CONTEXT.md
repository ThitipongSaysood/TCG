# CONTEXT — CARD ZONE (The Ultimate TCG Marketplace)

> ไฟล์นี้คือ **จุดเริ่มต้น** ของโปรเจค — อ่าน 2 นาทีแล้วเข้าใจภาพรวมทั้งหมด
> เหมาะสำหรับ developer ใหม่, AI assistant, หรือใครก็ตามที่เพิ่งเปิดโปรเจค

---

## 1. นี่คือโปรเจคอะไร?

**CARD ZONE** = แพลตฟอร์มซื้อขายซองการ์ดสะสม (Trading Card Game / TCG)
ครอบคลุม Pokémon, ONE PIECE, Dragon Ball, Digimon, Yu-Gi-Oh! และอื่น ๆ

จุดขายหลัก 4 อย่าง:
1. **ขายซอง Booster Pack** ทาง Front Website ปกติ (Ship Home)
2. **เปิดซอง Live สด** — ผู้ซื้อจองคิว ดูร้านเปิดซองให้บน Facebook/YouTube
3. **ประมูลการ์ด** แบบล็อกเครดิตกัน bid เล่น (Anti-Spam Shield)
4. **ส่งเกรด PSA** + Buy-Back รับซื้อคืน

**กลุ่มเป้าหมาย:** นักสะสม TCG ไทย · เน้น mobile-first · UI premium dark theme + ทอง

---

## 2. สถานะปัจจุบัน

- **Version:** Scaffold v0.1
- **ทำเสร็จแล้ว:** Laravel 13 · UI Blade 15 หน้า · Auth REST API (Sanctum + Socialite: Email/LINE/Google) · DB migrations
- **ยังไม่ได้ทำ:** เชื่อม PageController กับ Eloquent, Seeder, PromptPay QR, real-time bid/live, Admin/Seller panel
- **Run:** `php artisan serve` → http://127.0.0.1:8000

ดู roadmap เต็มที่ [README.md](../README.md#roadmap-ถัดไป)

---

## 3. Tech Stack

| Layer | เลือกใช้ |
|-------|---------|
| Framework | **Laravel 11** (PHP 8.4) |
| Templating | Blade |
| Database | MySQL/MariaDB · DB `siamcard` (remote: `shop.siamcardmarket.com`) |
| Frontend | Vanilla CSS/JS · Glassmorphism · Mobile-first |
| Build | Vite |
| Auth | REST API · Sanctum token + Socialite (Email / LINE / Google) |
| Deploy | `php artisan serve` (dev) — production: any PHP host |

---

## 4. แผนที่เอกสาร (อ่านตามลำดับนี้)

| ลำดับ | ไฟล์ | เนื้อหา | เมื่อไหร่ควรอ่าน |
|------|------|---------|------------------|
| 1 | **CONTEXT.md** (ไฟล์นี้) | ภาพรวม 2 นาที | เริ่มต้นทุกครั้ง |
| 2 | [README.md](../README.md) | Setup · tech stack · routes หลัก · roadmap | จะรันโปรเจคจริง |
| 3 | [workflow.md](../workflow.md) | การทำงานของเว็บทั้งหมด · 8 user journey · status lifecycle | อยากเข้าใจ business flow |
| 4 | [design.md](../design.md) | UI/UX · color tokens · components · 15 หน้า | จะแก้/เพิ่ม UI |
| 5 | [database.md](../database.md) | Schema 8 หมวด · ER diagram · indexes | จะเขียน query / migration |
| 6 | [AGENTS.md](AGENTS.md) | กฎสำหรับ AI assistant + project rules ที่ต้องระวัง | AI session ใหม่ |
| 7 | [active.md](active.md) | งานที่กำลังทำอยู่ตอนนี้ | ต่องานจาก session ก่อน |

---

## 5. โครงสร้างโปรเจคโดยย่อ

```
TCG/
├── README.md · workflow.md · design.md · database.md
├── .agents/
│   └── CONTEXT.md · AGENTS.md · active.md · topics/ · sessions/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/AuthController.php        ← web login/register/logout (session)
│   │   ├── Api/AuthController.php         ← REST API auth (Sanctum token)
│   │   └── PageController.php             ← 15 Blade pages
│   └── Models/User.php · Wallet.php · WalletTransaction.php
├── database/migrations/                    ← users + 6 domain migrations
├── public/assets/
│   ├── css/style.css                       ← design tokens + components
│   ├── js/main.js                          ← navbar/drawer/gallery/countdown
│   └── images/                             ← การ์ดจริง (op-* = One Piece, pkm-* = Pokémon)
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── partials/{navbar,drawer,tabbar,footer}.blade.php
│   ├── auth/{login,register}.blade.php
│   └── (home + 12 หน้า domain)
└── routes/web.php · routes/api.php         ← web routes + REST API
```

---

## 6. โดเมนหลัก (Domain Concepts) ที่ต้องรู้

| Concept | ความหมาย |
|---------|---------|
| **Serial Code** | รหัสประจำซองแต่ละซอง รูปแบบ `[GAME]-[SET]-[CARTON]-[BOX]-[PACK]` เช่น `OP-OP09-C02-B11-P07` — Track ทุกซองได้ตลอดทาง |
| **Status Lifecycle** | `available → reserved → sold → queue_live → opened → delivered` (แสดงผ่าน `.htrack` stepper) |
| **Membership Tier** | Bronze → Silver → Gold → Platinum · อัพอัตโนมัติตาม `total_spent` + `auction_wins` |
| **Anti-Spam Shield** | ต้องล็อกเครดิตจาก wallet ก่อนถึง bid ได้ · ถูกแซง = คืนอัตโนมัติ |
| **Priority Queue** | Gold/Platinum tier ลัดคิวเปิดซอง Live ได้ |
| **GP Rate** | ค่าธรรมเนียมที่ shop ต้องจ่าย (`shops.gp_rate %`) |
| **fulfill_type** | `ship_home` (ส่งบ้าน) หรือ `open_live` (เปิดในไลฟ์) ตอน checkout |

ดูรายละเอียดเต็มที่ [workflow.md §7](../workflow.md) และ [database.md](../database.md)

---

## 7. คำสั่งที่ใช้บ่อย

```bash
# Setup ครั้งแรก
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate

# พัฒนา
php artisan serve            # → http://127.0.0.1:8000
npm run dev                  # Vite hot reload

# Test
php artisan test             # ทุก feature test
```

---

## 8. ข้อระวังสำคัญ (จาก [AGENTS.md](AGENTS.md))

- ❗ **อย่ารวม `container` + `section` บน `<main>`** — `.section{padding:40px 0}` แบบ shorthand จะลบ `padding:0 16px` ของ container ทำให้ขอบ mobile หาย
- ❗ **อย่าเติม `overflow-x:auto` กับ `.htrack`** — ทำให้เกิด scrollbar bug
- ❗ **อย่าใส่ gradient placeholder คืน** — ใช้รูปการ์ดจริงใน `public/assets/images/`
- ❗ **Sanctum config:** `'guard' => []` (ไม่ fallback web session) + middleware ไม่มี `statefulApi()` — pure Bearer token API

---

## 9. ลิงก์ภายนอก

| ทรัพยากร | URL |
|----------|-----|
| Git repo | https://github.com/ThitipongSaysood/TCG.git |
| Branch หลัก | `main` |
| Dev URL | http://127.0.0.1:8000 (รัน `php artisan serve`) |

---

**TL;DR:** Laravel 11 marketplace สำหรับขายซองการ์ด + เปิด Live + ประมูล + PSA · ยังเป็น mockup
อ่าน [workflow.md](../workflow.md) เพื่อเข้าใจ flow, [database.md](../database.md) เพื่อเข้าใจ schema, [design.md](../design.md) เพื่อเข้าใจ UI

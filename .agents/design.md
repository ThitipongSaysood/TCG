# Agent Design Notes — CARD ZONE

> สำเนาของ root [`design.md`](../design.md) ที่ฝัง context อยู่ในโฟลเดอร์ AI
> โดยตรง เพื่อให้ session ใหม่อ่านได้ทันทีจาก `.agents/` ก่อนหน้าที่จะ
> navigate ไป root ของโปรเจค ถ้า root design.md เปลี่ยน ให้ sync มาด้วย

## 0. How AI should use this doc

- **ก่อนแตะ UI** — เปิดดู §2 (Color Tokens) และ §6 (Components) ก่อน อย่ามโน
  hex หรือ class ใหม่ ใช้ token ที่มีอยู่
- **Edit Blade, not docs/** — แก้ที่ `resources/views/` แล้วรัน
  `php artisan static:build` ให้ docs/ ใหม่ออกเอง
- **Asset paths in views** — ใช้ `{{ asset('assets/...') }}` เสมอ build script
  ตัด host ทิ้งเพื่อให้ทำงานใต้ `/TCG/` บน Pages
- **Route links** — ใช้ `{{ route('name', params) }}` — build script เขียนเป็น
  `.html` ให้ตอน export
- **CSS อยู่ไฟล์เดียว** — `public/assets/css/style.css` ห้าม add Tailwind/SCSS
  เว้นแต่ user สั่ง
- **Mobile-first** — ทดสอบที่ 375px (iPhone) ก่อน desktop ถ้ามี layout bug
  เช็คก่อนว่าเกี่ยวกับ `.section` ทับ `.container` padding ไหม (ดู §11 Lessons)

---

## 1. Design Direction

| หลักการ | รายละเอียด |
|---------|-----------|
| **Mood** | Cinematic dark navy, premium, futuristic — อ้างอิงภาพ TCG ตั้งต้น |
| **Inspiration** | แดชบอร์ด TCG จอ navy เข้ม + แสงโค้งสีฟ้า-ขาว + ปุ่มทอง |
| **Accent** | ทอง/โฮโลแกรม (การ์ดหายาก) + ฟ้า-cyan (แสง, CTA รอง) |
| **Style** | Glassmorphism — frosted glass, ขอบเรืองแสง, gloss highlight |
| **Layout** | Mobile-first, 100% responsive, การ์ดเป็น grid |
| **Personality** | เชื่อถือได้ (Trust) · สะดวก (Convenience) · ผูกพัน (Engagement) |

---

## 2. Color Tokens

กำหนดเป็น CSS Custom Properties ใน `public/assets/css/style.css` (`:root`)

### Background — deep cinematic navy
| Token | HEX | การใช้งาน |
|-------|-----|-----------|
| `--bg-900` | `#060912` | พื้นหลังหลักของหน้า |
| `--bg-800` | `#0B111F` | section รอง / drawer / footer |
| `--bg-700` | `#111A2D` | พื้นฐานการ์ด |
| `--bg-600` | `#1A2438` | input / panel ทึบ |

### Brand / Accent — steel-blue + gold
| Token | HEX | การใช้งาน |
|-------|-----|-----------|
| `--primary` | `#4F74E8` | น้ำเงินเหล็กหลัก — ปุ่ม, ลิงก์ |
| `--primary-bright` | `#7FA0FF` | น้ำเงินสว่าง — hover, eyebrow |
| `--secondary` | `#3FC6E8` | cyan — แสง, accent รอง |
| `--gold` | `#E9CC86` | ทอง — ราคา, CTA หลัก (ปุ่ม Bidding), tier |
| `--grad-gold` | `linear-gradient(120deg,#F4E0A6,#E9CC86,#C9A861)` | ปุ่มทองหลัก |
| `--holo` | `linear-gradient(135deg,#E9CC86,#7FA0FF,#3FC6E8)` | โฮโล — heading + การ์ด Rare |

### Glass tokens
| Token | ค่า |
|-------|-----|
| `--glass-bg` | `rgba(120,160,220,.06)` — กระจกฟ้าจาง |
| `--glass-border` | `rgba(150,185,235,.16)` |
| `--glass-blur` | `blur(18px) saturate(150%)` |

### State
| Token | HEX | การใช้งาน |
|-------|-----|-----------|
| `--success` | `#34D399` | สำเร็จ / Available |
| `--warning` | `#FBBF24` | รอดำเนินการ |
| `--danger` | `#F87171` | ผิดพลาด / Sold |
| `--live` | `#FF4D6D` | จุดสถานะ Live |

### Text
| Token | HEX |
|-------|-----|
| `--text-100` | `#F4F3FF` (หัวข้อ) |
| `--text-300` | `#B8B5D8` (เนื้อความ) |
| `--text-500` | `#6E6B92` (รอง / caption) |
| `--border` | `rgba(255,255,255,.08)` |

---

## 3. Typography

- **Font**: `Noto Sans Thai` (เนื้อหาไทย) + `Sora` / `Inter` (อังกฤษ + ตัวเลข) — โหลดผ่าน Google Fonts
- ภาษาไทย+อังกฤษผสมในหน้าเดียวกัน (heading อังกฤษ, เนื้อหาไทย)

| Scale | ขนาด (desktop) | ขนาด (mobile) | น้ำหนัก |
|-------|-----|-----|-----|
| `h1` / hero | 48px | 30px | 800 |
| `h2` / section | 32px | 24px | 700 |
| `h3` / card title | 20px | 18px | 600 |
| `body` | 16px | 15px | 400 |
| `caption` | 13px | 12px | 400 |
| ราคา (price) | 22px | 18px | 700 / `--gold` |

---

## 4. Spacing & Radius

- **Spacing scale**: 4 / 8 / 12 / 16 / 24 / 32 / 48 / 64 px
- **Radius**: `--r-sm` 8px · `--r-md` 14px · `--r-lg` 20px · `--r-pill` 999px
- **Container**: max-width `1240px`, padding ข้าง 16px (mobile) / 24px (desktop)

---

## 5. Responsive Breakpoints

| ชื่อ | ขนาด | คอลัมน์ grid การ์ด |
|------|------|------|
| Mobile | `< 640px` | 2 |
| Tablet | `640–1024px` | 3 |
| Desktop | `> 1024px` | 4–5 |

- Navbar: desktop เป็นแถบเต็ม, mobile เป็น hamburger + drawer
- Bottom Tab Bar แสดงเฉพาะ mobile (Home / Auction / Live / Collection / Profile)

---

## 6. Components

### Card (สินค้า / การ์ด)
- พื้น `--bg-700`, radius `--r-md`, border `--border`
- `.card-img` aspect 4:5, `overflow:hidden` — รูปการ์ดจริงวางด้วย `<img>`
  (`position:absolute; inset:0; object-fit:cover`) badge มุมซ้อนบน (`z-index:2`)
- ใต้รูป: ชื่อการ์ด + ราคา ทอง + ปุ่ม
- hover: ยกขึ้น `translateY(-4px)` + เงาม่วง glow

### Button
| ชนิด | สไตล์ |
|------|------|
| `.btn-primary` | gradient ม่วง→น้ำเงิน, ตัวอักษรขาว |
| `.btn-gold` | gradient ทอง, ตัวอักษรเข้ม — ใช้กับ "ซื้อเลย/ประมูล" |
| `.btn-ghost` | โปร่ง, border ม่วง |
| `.btn-line` | เขียว LINE `#06C755` |

### Badge / Pill
- `Live` (แดงเต้น), `Rare/SR/SAR` (ทอง), สถานะ order (success/warning)

### Glass Panel
- `background: rgba(255,255,255,.04)` + `backdrop-filter: blur(12px)` + border บาง

### Status Tracker (stepper)
- **แนวตั้ง** (`.tracker`) — ใช้ในหน้า Tracking, PSA · วงกลมไอคอน + เส้นเชื่อมแนวดิ่ง
- **แนวนอน** (`.htrack`) — ใช้แสดง Serial lifecycle · 4 ขั้นเรียงเต็มความกว้าง
  (`flex:1`, ไม่มี scroll), เส้นเชื่อมระหว่างวงกลม — ขั้นที่ผ่านแล้วเป็นสีน้ำเงิน,
  ขั้นปัจจุบันขอบทอง + glow
- สถานะ: Available → Reserved → Sold → Queue Live → Opened → Delivered

---

## 7. รายการหน้า (15 หน้า Front-end / Blade)

| # | Route | View | หน้า |
|---|---|---|---|
| 1 | `/` | `home.blade.php` | Home — Live banner, หมวดเกม, Booster ล่าสุด, Auction Hot |
| 2 | `/login` | `auth/login.blade.php` | Login — LINE / Facebook / Email |
| 3 | `/register` | `auth/register.blade.php` | สมัครสมาชิก |
| 4 | `/products` | `products/index.blade.php` | แสดงสินค้า (Booster Pack) + filter |
| 5 | `/products/{id}` | `products/show.blade.php` | รายละเอียดสินค้า + Serial example |
| 6 | `/cart` | `cart/index.blade.php` | ตะกร้าสินค้า (auth) |
| 7 | `/checkout` | `checkout/index.blade.php` | ชำระเงิน — PromptPay QR / Wallet (auth) |
| 8 | `/live` | `live/index.blade.php` | Live Opening Queue |
| 9 | `/auctions` | `auctions/index.blade.php` | รายการประมูล |
| 10 | `/auctions/{id}` | `auctions/show.blade.php` | รายละเอียดประมูล + bid history |
| 11 | `/profile` | `profile/show.blade.php` | โปรไฟล์ / Wallet / Tier (auth) |
| 12 | `/my-orders` | `orders/index.blade.php` | คำสั่งซื้อของฉัน (auth) |
| 13 | `/my-collection` | `collection/index.blade.php` | คลังการ์ดของฉัน (auth) |
| 14 | `/psa-submission` | `psa/index.blade.php` | ส่งการ์ดเกรด PSA (auth) |
| 15 | `/tracking/{id}` | `tracking/show.blade.php` | ติดตามพัสดุ (auth) |

ทุกหน้า `@extends('layouts.app')` ซึ่งรวม partials: `navbar` · `drawer` · `tabbar` · `footer`

---

## 8. โครงสร้างไฟล์ (Laravel 11)

```
TCG/
├── design.md · database.md · README.md
├── app/
│   ├── Console/Commands/BuildStatic.php   (artisan static:build → docs/)
│   ├── Http/Controllers/
│   │   ├── Auth/AuthController.php        (login / register / logout)
│   │   └── PageController.php             (15 หน้า)
│   └── Models/User.php
├── database/migrations/                   (0001 users + 6 domain migrations)
├── public/
│   └── assets/{css,js,images}/            (style.css · main.js · 15 รูปการ์ด)
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── partials/{navbar,drawer,tabbar,footer}.blade.php
│   ├── auth/{login,register}.blade.php
│   └── home + 12 หน้า domain (products, auctions, live, cart, ...)
├── routes/web.php
├── .github/workflows/pages.yml            (auto-deploy mockup → GitHub Pages)
└── .agents/                                (AI context — AGENTS.md, sessions, ...)
```

## 9. Iconography & Imagery
- ไอคอน: inline SVG (เบา ปรับสีตาม token ได้)
- รูปการ์ด: ใช้ไฟล์ภาพจริงใน `public/assets/images/` (การ์ด One Piece + Pokémon)
  ตั้งชื่อแบบ `[เกม]-[ตัวละคร]-[เซ็ต].webp` เช่น `op-luffy-op13.webp`,
  `pkm-pikachu-ex-gold.webp` — วางผ่าน `<img>` ใน `.card-img`
- เอฟเฟกต์โฮโล: gradient เคลื่อนไหวบน heading และขอบการ์ด Rare

---

## 10. Static Mockup Deploy

ใช้ `php artisan static:build` เรนเดอร์ Blade ทั้ง 15 หน้าเป็น `.html` ใน `docs/`
แล้ว GitHub Actions ([.github/workflows/pages.yml](../.github/workflows/pages.yml))
deploy ขึ้น Pages ทุก push ไป `main`

- Build command **ยัด demo user (PANYA, Gold)** ไว้ใน Auth ก่อน render — หน้า static เลยโชว์ navbar แบบล็อกอินอยู่
- URL ปัจจุบัน: **https://thitipongsaysood.github.io/TCG/**
- Internal links + asset paths ถูก rewrite ให้เป็น relative path (ทำงานใต้ `/TCG/` ได้)

---

## 11. Lessons — บั๊กที่เคยเจอ (อย่าให้หลุดอีก)

- **Mobile margin หาย** — ห้ามใส่คลาส `container` + `section` พร้อมกันบน `<main>`
  เพราะ `.section{padding:40px 0}` (shorthand) ทับ `.container{padding:0 16px}`
  ทำให้ขอบซ้าย-ขวาเป็น 0 → แก้แล้วใน style.css: `.section` ใช้
  `padding-top` / `padding-bottom` แยก
- **Status Tracker scrollbar ขาว** — `.htrack` เดิมมี `overflow-x:auto` +
  `min-width:84px` ที่ล้นกรอบใน aside แคบ → ทำให้เห็น scrollbar เป็นแถบขาวยาว
  ตอนนี้ใช้ `flex:1` + `min-width:0` + ไม่มี overflow แล้ว ห้ามใส่กลับ
- **Pages workflow ซ้อน** — ถ้า user enable Pages ผ่าน UI แล้วเลือก template
  GitHub จะเพิ่ม `.github/workflows/static.yml` ที่ upload `path: '.'` ของ
  repo เปล่าๆ ซ้อนกับ `pages.yml` (concurrency group `pages` ตัวเดียวกัน)
  → 404 เสมอ ลบ static.yml ทิ้งให้เหลือแค่ pages.yml
- **Gallery JS ใน product-detail** — `main.textContent = ...` จะลบ `<img>`
  ภายใน galleryMain ทิ้ง ตอนนี้ logic เช็คก่อนว่ามี `<img>` ลูกไหม ถ้ามี
  ใช้ `mImg.src = t.dataset.img` แทน
- **Mass assignment trap ใน demo user** — `User::class` มี `#[Fillable]` แบบ
  strict ฟิลด์อย่าง `membership_tier` ไม่อยู่ใน list ต้องตั้งด้วย property
  assignment โดยตรง (`$demo->membership_tier = 'gold';`) ไม่ใช่ผ่าน constructor

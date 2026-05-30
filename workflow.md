# Workflow — CARD ZONE (The Ultimate TCG Marketplace)

เอกสารนี้สรุป **การทำงานของเว็บทั้งหมด** ตั้งแต่ผู้ใช้เปิดหน้าแรกจนถึง
จบกระบวนการซื้อ / เปิดซอง Live / ประมูล / ส่ง PSA
ใช้เป็นแผนที่หลักเชื่อมโยง [design.md](design.md) (UI) + [database.md](database.md) (Schema) + โค้ดจริง

> **กลุ่มเป้าหมาย:** นักสะสม TCG (Pokémon · ONE PIECE · Dragon Ball · Digimon · Yu-Gi-Oh!)
> **สถานะปัจจุบัน:** Scaffold v0.1 — UI mockup + Auth พื้นฐาน · ยังไม่มี business logic จริง

---

## 1. ภาพรวมระบบ (System Map)

```
┌────────────────────────────────────────────────────────┐
│                    CARD ZONE                            │
├────────────────────────────────────────────────────────┤
│ Front Website  →  Seller Dashboard  →  Admin System    │
└────────────────────────────────────────────────────────┘
        │
        ├── 1. Catalog        (ดูซอง / การ์ด / ร้านค้า)
        ├── 2. Auth           (สมาชิก / Wallet / Tier)
        ├── 3. Cart+Checkout  (ตะกร้า → PromptPay QR / Wallet)
        ├── 4. Live Opening   (จองคิว → เปิดซองสด → ได้การ์ด)
        ├── 5. Auction        (ประมูลแบบล็อกเครดิต)
        ├── 6. Collection     (คลังการ์ดส่วนตัว + ส่งเกรด PSA)
        ├── 7. Buy-Back       (รับซื้อคืน)
        └── 8. Tracking       (ติดตามพัสดุ + Status Tracker)
```

แต่ละโมดูลผูกกับ **Serial Code** (`OP-OP09-C02-B11-P07`) เพื่อ Track ทุกซอง
ตั้งแต่ `available → reserved → sold → queue_live → opened → delivered`
(ดู [database.md §3.5 `product_serials`](database.md))

---

## 2. หน้าเว็บทั้งหมด (15 หน้า + Auth)

| # | URL | View | สิทธิ์ | สรุปการทำงาน |
|---|-----|------|--------|--------------|
| 1 | `/` | [home.blade.php](resources/views/home.blade.php) | public | Live banner · หมวดเกม · Booster ใหม่ · Auction Hot |
| 2 | `/login` | [auth/login.blade.php](resources/views/auth/login.blade.php) | guest | Email / LINE / Google |
| 3 | `/register` | [auth/register.blade.php](resources/views/auth/register.blade.php) | guest | สมัครสมาชิก |
| 4 | `/products` | [products/index.blade.php](resources/views/products/index.blade.php) | public | รายการ Booster Pack + filter เกม/เซ็ต/ราคา |
| 5 | `/products/{id}` | [products/show.blade.php](resources/views/products/show.blade.php) | public | รายละเอียดสินค้า + Serial example |
| 6 | `/cart` | [cart/index.blade.php](resources/views/cart/index.blade.php) | auth | ตะกร้าสินค้า |
| 7 | `/checkout` | [checkout/index.blade.php](resources/views/checkout/index.blade.php) | auth | PromptPay QR / Wallet · เลือก `ship_home` หรือ `open_live` |
| 8 | `/live` | [live/index.blade.php](resources/views/live/index.blade.php) | public | คิวเปิดซอง Live + stream embed |
| 9 | `/auctions` | [auctions/index.blade.php](resources/views/auctions/index.blade.php) | public | รายการประมูลทั้งหมด |
| 10 | `/auctions/{id}` | [auctions/show.blade.php](resources/views/auctions/show.blade.php) | public | bid history · Auto Bid · Buy Now |
| 11 | `/profile` | [profile/show.blade.php](resources/views/profile/show.blade.php) | auth | Wallet · Tier · ที่อยู่ |
| 12 | `/my-orders` | [orders/index.blade.php](resources/views/orders/index.blade.php) | auth | คำสั่งซื้อ + สถานะ |
| 13 | `/my-collection` | [collection/index.blade.php](resources/views/collection/index.blade.php) | auth | คลังการ์ดส่วนตัว |
| 14 | `/psa-submission` | [psa/index.blade.php](resources/views/psa/index.blade.php) | auth | ส่งการ์ดเกรด PSA |
| 15 | `/tracking/{id}` | [tracking/show.blade.php](resources/views/tracking/show.blade.php) | auth | ติดตามพัสดุ + Serial lifecycle |

Routes ทั้งหมดอยู่ใน [routes/web.php](routes/web.php) · Controller หลักคือ
[PageController.php](app/Http/Controllers/PageController.php)
และ [Auth/AuthController.php](app/Http/Controllers/Auth/AuthController.php)

ทุกหน้า `@extends('layouts.app')` ซึ่งรวม partials:
[navbar](resources/views/partials/navbar.blade.php) ·
[drawer](resources/views/partials/drawer.blade.php) ·
[tabbar](resources/views/partials/tabbar.blade.php) ·
[footer](resources/views/partials/footer.blade.php)

---

## 3. User Journey หลัก (8 Flow)

### 3.1 Flow A — สมัครสมาชิก & Login

```
Guest → /register (กรอก email/phone/รหัสผ่าน)
     → POST /register → AuthController@register
     → สร้าง users + wallets (balance=0, locked=0)
     → Auto login → redirect /
```

หรือ Login เดิม:
```
Guest → /login → POST /login → AuthController@login → /
```

**DB ที่เกี่ยวข้อง:** `users` + `wallets` (สร้างคู่กัน 1-to-1)
รองรับ social login (LINE / Google) ผ่าน `login_provider` + `provider_uid` — ดู [API §13](#13-api-เข้าสู่ระบบ-rest)

---

### 3.2 Flow B — ซื้อ Booster Pack (Ship Home)

```
1. /products              เลือกซอง → filter เกม/เซ็ต/ราคา
2. /products/{id}         ดูรายละเอียด + Serial example
3. [+ ใส่ตะกร้า]          → /cart  (ต้อง auth)
4. /checkout              เลือกที่อยู่ + วิธีจ่าย
                           - fulfill_type = ship_home
                           - payment = promptpay_qr | wallet
5. ชำระเงิน                → orders.status = pending_payment → paid
6. ระบบ assign serial      → product_serials.status = reserved → sold
                            owner_user_id = user.id
7. ร้านแพ็ก                 → status = packed → shipped
8. ขนส่ง                   → shipments.status timeline
9. รับของ                  → status = delivered → completed
```

**Status Tracker (ดู [design.md §6](design.md)):**
`Available → Reserved → Sold → (skip Queue Live) → Delivered`

**DB:** `orders` · `order_items` · `product_serials` · `shipments` · `wallet_transactions`

---

### 3.3 Flow C — ซื้อแล้วเปิด Live (Open in Live Stream)

ทางเลือกของ Flow B เมื่อ checkout เลือก `fulfill_type = open_live`:

```
1-5. เหมือน Flow B (ซื้อ + จ่าย)
6.  ระบบ assign serial      → status = queue_live
7.  ร้านเปิดสตรีม           → live_sessions (Facebook/YouTube)
8.  ระบบสร้าง live_queues   → queue_no ตามลำดับ
                            → Gold/Platinum tier ได้ is_priority = true (ลัดคิว)
9.  ถึงคิวลูกค้า            → live_queues.status = locked → opening
10. ร้านเปิดซองสด            → result_cards_json บันทึกการ์ดที่ได้
                            → product_serials.status = opened
                            → collection_items สร้างใหม่ (source = 'opening')
11. ส่งการ์ดให้ลูกค้า        → shipments → delivered
```

**ฟีเจอร์พิเศษ:** Gold/Platinum Tier มี `priority_queue=true` ลัดคิวจาก [database.md §8.1](database.md)

---

### 3.4 Flow D — ประมูล (Auction + Anti-Spam Shield)

```
1.  /auctions                       เห็นรายการประมูลที่ open
2.  /auctions/{id}                  ดู current_price + bid history
3.  [Place Bid amount]              → ต้อง auth
4.  ระบบล็อกเครดิตจาก wallet         → wallet.balance ลด, locked_balance เพิ่ม
                                    → wallet_transactions (type=bid_lock)
                                    → bids (status=active, locked_txn_id)
5.  มีคนแซง                          → bids.status = outbid
                                    → Auto Refund: ปลดล็อกเครดิตกลับ wallet
                                    → wallet_transactions (type=bid_refund)
6.  Auto Bid (ถ้าตั้งไว้)            → ระบบ bid ให้อัตโนมัติตาม min_increment
7.  Buy Now (ถ้ามี buy_now_price)    → ปิดประมูลทันที
8.  end_at ถึง                       → auctions.status = closed
                                    → ผู้ชนะ: bids.status = won → settled
                                    → collection_items (source='auction')
                                    → notifications (event=auction_won)
```

**Anti-Spam Shield = ต้องล็อกเครดิตก่อนถึง bid ได้** — กันบิดเล่น
ดูฟิลด์ใน [database.md §6 `auctions/bids`](database.md)

---

### 3.5 Flow E — Wallet & Top-up

```
- Top-up:   /profile → กรอกจำนวน → PromptPay QR
           → wallet_transactions (type=topup, promptpay_ref, status=pending → success)
           → wallets.balance เพิ่ม

- Purchase: หัก wallets.balance → wallet_transactions (type=purchase)

- Bid Lock: หัก balance → เพิ่ม locked_balance → (type=bid_lock)

- Payout:   ร้านค้าถอน → (type=payout)

- Cashback: Gold/Platinum tier → (type=cashback) ตาม cashback_pct
```

ทุก transaction มี `ref_type` + `ref_id` (เช่น `order/123`, `auction/45`)
ทำให้ track ได้ทุกบาท

---

### 3.6 Flow F — Collection & PSA Grading

```
1.  /my-collection                ดูการ์ดทั้งหมด (จาก opening / auction / purchase)
                                  + est_value ปัจจุบัน

2.  เลือกการ์ด → /psa-submission   ส่งเกรด PSA
                                  service_level: economy (20-25d) / regular (10-15d) / express (5-7d)
3.  สร้าง psa_submissions          status = preparing
    + psa_items (ผูก collection_items)
4.  ส่งให้ PSA                      status = sent_to_psa → grading
5.  PSA คืนผล                       grade_result (1-10)
                                  → status = completed
                                  → ถ้าคะแนนสูง สามารถสร้าง products type=graded_card ขายต่อ
6.  notifications (event=psa_status) แจ้งทุกขั้น
```

**DB:** `collection_items` · `psa_submissions` · `psa_items` · `products(type=graded_card, psa_grade)`

---

### 3.7 Flow G — Buy-Back (รับซื้อคืน)

```
1. ร้านสร้าง buyback_listings    ระบุ product_id + buy_price (open)
2. /my-collection → ดูเสนอราคา
3. ลูกค้ากด "ขายคืน"             → buyback_requests (status=pending)
4. ร้านอนุมัติ                    → status=accepted
                                  → เครดิตเข้า wallets (type=buyback)
                                  → status=paid
                                  → product_serials โอน owner_user_id กลับร้าน
```

---

### 3.8 Flow H — Membership Tier (สะสมขึ้นระดับ)

| Tier | min_spent | min_wins | สิทธิ์ |
|------|-----------|----------|------|
| Bronze | 0 | 0 | พื้นฐาน |
| Silver | ตาม config | | ส่วนลดค่าธรรมเนียม |
| Gold | สูงขึ้น | สูงขึ้น | Priority Queue ใน Live + Cashback |
| Platinum | สูงสุด | สูงสุด | สิทธิประโยชน์ทั้งหมด + cashback สูงสุด |

ค่า threshold เก็บใน `membership_tiers` ([database.md §8.1](database.md))
อัพ tier อัตโนมัติเมื่อ `users.total_spent` หรือ `auction_wins` ผ่านเกณฑ์

---

## 4. Status Lifecycle ของ Serial (หัวใจของระบบ)

ทุกซองมี **Absolute Tracking** ผ่าน `product_serials.status`:

```
available  →  reserved  →  sold  →  queue_live  →  opened  →  delivered
   (พร้อมขาย)   (อยู่ในตะกร้า)  (จ่ายแล้ว)   (รอเปิด Live)  (เปิดแล้ว)   (ส่งถึงมือ)
```

แสดงผลด้วย **Horizontal Tracker `.htrack`** ใน [design.md §6](design.md):
- ขั้นผ่านแล้ว → สีน้ำเงิน
- ขั้นปัจจุบัน → ขอบทอง + glow
- ขั้นถัดไป → สีเทาจาง

ใช้ในหน้า [/tracking/{id}](resources/views/tracking/show.blade.php) และ partial ใน [/my-orders](resources/views/orders/index.blade.php)

---

## 5. Notification Events

`notifications.event` ที่ระบบยิงอัตโนมัติ (ช่อง: LINE / email / in_app):

| Event | จุดยิง | ผู้รับ |
|-------|--------|--------|
| `payment_success` | orders.status = paid | ผู้ซื้อ |
| `queue_live` | ถึงคิวเปิดซองในไม่กี่นาที | ผู้ซื้อ |
| `auction_won` | auction settled, มีผู้ชนะ | ผู้ชนะ |
| `auction_outbid` | มีคนแซง bid | ผู้แพ้ bid |
| `psa_status` | psa_submissions.status เปลี่ยน | ผู้ส่ง |
| `shipment_update` | shipments.status เปลี่ยน | ผู้ซื้อ |
| `buyback_offer` | ร้านสร้าง listing ตรงกับ collection | เจ้าของการ์ด |

ดู [database.md §8.2](database.md)

---

## 6. บทบาท (Roles) & สิทธิ์

`users.role` มี 3 ค่า:

### 6.1 `member` (ผู้ซื้อ/นักสะสม)
- เข้าถึงหน้า Front ทั้งหมด
- มี wallet ส่วนตัว · collection · ส่ง PSA · ประมูล

### 6.2 `seller` (ร้านค้าพาร์ทเนอร์) — *ยังไม่ implement*
- เปิด `shops` (มี `gp_rate` = ค่า GP %)
- จัดการ products, serials, live_sessions, auctions
- สร้าง buyback_listings
- ถอนเงิน (payout)

### 6.3 `admin` — *ยังไม่ implement*
- คุมสถานะ shops (`active/suspended`)
- ดู audit_logs (encrypted IP) — Ultimate Security
- กำหนด membership_tiers thresholds

---

## 7. ฟีเจอร์เด่นเชิงเทคนิค

| Feature | ที่มา | สรุป |
|---------|------|------|
| **Absolute Tracking** | `product_serials.serial_code` | track ทุกซองจากโกดัง → มือลูกค้า |
| **Anti-Spam Shield** | `wallets.locked_balance` | ล็อกเครดิตก่อน bid → กันบิดเล่น |
| **Auto Refund** | `bids.status=outbid` trigger | ถูกแซง = คืนเครดิตอัตโนมัติ |
| **Auto Bid** | `bids.is_auto_bid` | bid ให้ตาม min_increment |
| **Priority Queue** | `live_queues.is_priority` | Gold/Platinum tier ลัดคิว |
| **Smart Bidding** | `auctions.buy_now_price` | ซื้อเลยไม่ต้องรอจบประมูล |
| **Ultimate Security** | `audit_logs` (encrypted IP) | log ทุกการกระทำของ admin |

---

## 8. Tech Architecture

```
┌──────────────────────────────────────────────────┐
│ Browser (mobile-first, responsive)               │
│  └─ Blade views + Vanilla CSS/JS (Glassmorphism) │
└──────────────────────────────────────────────────┘
              │ HTTPS
              ▼
┌──────────────────────────────────────────────────┐
│ Laravel 11 (PHP 8.4)                             │
│  ├─ routes/web.php   (15 หน้า + auth)            │
│  ├─ PageController   (mockup view)               │
│  ├─ AuthController   (session-based)             │
│  └─ Eloquent Models  (User · เตรียม 20+ models)  │
└──────────────────────────────────────────────────┘
              │
              ▼
┌──────────────────────────────────────────────────┐
│ Database (MySQL/MariaDB · siamcard)              │
│  └─ 6 domain migrations + users/cache/jobs       │
└──────────────────────────────────────────────────┘

External (วางแผน):
  - PromptPay Webhook  (ยืนยันการชำระ)
  - Laravel Reverb / WebSockets (real-time bid + live queue)
  - Filament Panel (Admin / Seller Dashboard)

External (พร้อมใช้แล้ว):
  - LINE / Google Login (Socialite) — REST API + session-based
```

ดู [README.md](README.md) สำหรับ tech stack เต็ม

---

## 10. แผนพัฒนาต่อไป (Roadmap)

จาก [README.md](README.md):

- [ ] เชื่อม controllers กับ Eloquent (ตอนนี้แสดง mockup ล้วน)
- [ ] Seeder ข้อมูลตัวอย่าง (games / sets / shops / products)
- [x] LINE / Google Login (Socialite) — REST API พร้อมใช้งาน
- [ ] PromptPay QR + Webhook ยืนยันการชำระ
- [ ] Real-time bidding & live queue (Laravel Reverb / WebSockets)
- [ ] Filament panel สำหรับ Admin / Seller Dashboard
- [ ] PSA submission workflow + sync เกรดผลกลับ collection
- [ ] Buy-Back flow ครบลูป (listing → request → payout)
- [ ] Tier auto-promotion job (cron) อัพ tier ตาม total_spent / auction_wins

---

## 11. เอกสารที่เกี่ยวข้อง

| ไฟล์ | เนื้อหา |
|------|---------|
| [README.md](README.md) | Setup · tech stack · roadmap |
| [design.md](design.md) | UI/UX · color tokens · components · 15 หน้า |
| [database.md](database.md) | Schema 8 หมวด · ER diagram · indexes |
| **workflow.md** (ไฟล์นี้) | การทำงานของเว็บทั้งหมด · user journey · status lifecycle |
| [.agents/AGENTS.md](.agents/AGENTS.md) | AI context สำหรับการพัฒนาต่อ |

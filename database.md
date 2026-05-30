# Database Schema — CARD ZONE (The Ultimate TCG Marketplace)

ออกแบบฐานข้อมูลรองรับ 3 ระบบ: Front Website / Seller Dashboard / Admin System
DB engine: **MySQL/MariaDB** — ทุกตารางมี `created_at`, `updated_at`

> **Single DB (since 2026-05-30):** ใช้ **`siamcard`** เป็น DB เดียว (host: `shop.siamcardmarket.com`)
> ทุก tables — auth + business — อยู่ใน DB เดียวกัน

---

## 0. Implementation Status

### 🟢 DB `siamcard`

**Implemented (auth/identity):**

| ตาราง | หมวด |
|------|------|
| `member` | ผู้ใช้ (แทน `users` ของ Laravel default) |
| `wallets` | กระเป๋าเงิน · FK → `member` |
| `wallet_transactions` | รายการเดินบัญชี |
| `addresses` | ที่อยู่จัดส่ง · FK → `member` |
| `personal_access_tokens` | Sanctum API tokens |
| `password_reset_tokens` | reset password |

**Migrations:** [`database/migrations/siamcard/`](database/migrations/siamcard/) (auto-loaded via [AppServiceProvider](app/Providers/AppServiceProvider.php))

### 📝 Planned

| หมวด | ตาราง |
|------|------|
| Catalog | `games`, `sets`, `shops`, `products`, `product_serials` |
| Order | `orders`, `order_items`, `shipments` |
| Auction | `auctions`, `bids` |
| Live | `live_sessions`, `live_queues` |
| Collection | `collection_items`, `wishlists` |
| PSA | `psa_submissions`, `psa_items` |
| Buy-Back | `buyback_listings`, `buyback_requests` |
| ระบบ | `membership_tiers`, `notifications`, `audit_logs` |

### ⚠️ Schema Drift (spec vs reality)

| จุด | จริง | spec | แนวทาง |
|-----|------|------|--------|
| User table name | `member` | `users` | spec ใช้ `users`, code ใช้ `member` |
| `member.email` | nullable + UNIQUE | UNIQUE NOT NULL | spec ปรับเป็น nullable (รองรับ social login) |

---

## 1. ภาพรวมความสัมพันธ์ (ER Overview)

```
users ──< wallets ──< wallet_transactions
  │  └──< addresses
  │  └──< collection_items
  │  └──< wishlists
  │  └──< orders ──< order_items
  │  └──< psa_submissions ──< psa_items
  │  └──< bids
shops ──< products ──< product_serials
  │  └──< live_sessions ──< live_queues
  │  └──< buyback_listings
products ──< auctions ──< bids
games ──< sets ──< products
orders ──< shipments
```

---

## 2. ตารางหลัก

### 2.1 users — สมาชิก
| คอลัมน์ | ชนิด | หมายเหตุ |
|---------|------|----------|
| id | BIGINT PK AI | |
| display_name | VARCHAR(80) | |
| email | VARCHAR(160) UNIQUE | NULL ได้ (รองรับ social login ที่ยังไม่ผูก email) |
| phone | VARCHAR(20) | |
| password_hash | VARCHAR(255) | NULL ได้ถ้า login social |
| login_provider | ENUM('email','line','google') | |
| provider_uid | VARCHAR(120) | id จาก LINE/Google |
| avatar_url | VARCHAR(255) | |
| membership_tier | ENUM('bronze','silver','gold','platinum') | default 'bronze' |
| total_spent | DECIMAL(12,2) | ยอดซื้อสะสม (คิด tier) |
| auction_wins | INT | จำนวนครั้งชนะประมูล (คิด tier) |
| role | ENUM('member','seller','admin') | default 'member' |
| status | ENUM('active','suspended') | |

### 2.2 wallets — กระเป๋าเงิน
| คอลัมน์ | ชนิด | หมายเหตุ |
|---------|------|----------|
| id | BIGINT PK | |
| user_id | BIGINT FK→users | UNIQUE |
| balance | DECIMAL(12,2) | ยอดใช้ได้ |
| locked_balance | DECIMAL(12,2) | ยอดล็อกระหว่างประมูล (Anti-Spam Shield) |

### 2.3 wallet_transactions — รายการเดินบัญชี
| คอลัมน์ | ชนิด | หมายเหตุ |
|---------|------|----------|
| id | BIGINT PK | |
| wallet_id | BIGINT FK→wallets | |
| type | ENUM('topup','purchase','bid_lock','bid_refund','payout','cashback','buyback') | |
| amount | DECIMAL(12,2) | +/- |
| ref_type | VARCHAR(40) | order/auction/psa |
| ref_id | BIGINT | |
| promptpay_ref | VARCHAR(60) | ใช้เมื่อ topup ผ่าน QR |
| status | ENUM('pending','success','failed') | |

### 2.4 addresses — ที่อยู่จัดส่ง
| id PK · user_id FK · recipient · phone · line1 · district · province · postcode · is_default BOOL |

---

## 3. แคตตาล็อกการ์ด

### 3.1 games — จักรวาลการ์ด
| id PK · code VARCHAR(8) UNIQUE (เช่น OP, PKM) · name (Pokémon, ONE PIECE...) · icon_url |

### 3.2 sets — เซ็ต
| id PK · game_id FK · code VARCHAR(20) (เช่น OP09) · name VARCHAR(120) · release_date |

### 3.3 shops — ร้านค้าพาร์ทเนอร์
| คอลัมน์ | ชนิด | หมายเหตุ |
|---------|------|----------|
| id PK · owner_user_id FK→users | | |
| name · slug · logo_url · description | | |
| gp_rate | DECIMAL(4,2) | ค่า GP เช่น 10.00 (%) |
| status | ENUM('active','suspended') | Admin คุม |

### 3.4 products — สินค้า (Booster Pack / การ์ด)
| คอลัมน์ | ชนิด | หมายเหตุ |
|---------|------|----------|
| id | BIGINT PK | |
| shop_id | BIGINT FK→shops | |
| game_id / set_id | BIGINT FK | |
| name | VARCHAR(160) | เช่น Pokemon 151 Booster Pack |
| type | ENUM('booster_pack','single_card','box','graded_card') | |
| rarity | ENUM('common','rare','sr','sar','alt','sec') | NULL ได้ |
| price | DECIMAL(10,2) | |
| stock | INT | คงเหลือ (sync จาก serials) |
| cover_url | VARCHAR(255) | |
| psa_grade | TINYINT | ใช้กับ graded_card (เช่น 10) |
| status | ENUM('active','hidden','sold_out') | |

### 3.5 product_serials — เลข Serial รายซอง (Absolute Tracking)
| คอลัมน์ | ชนิด | หมายเหตุ |
|---------|------|----------|
| id | BIGINT PK | |
| product_id | BIGINT FK→products | |
| serial_code | VARCHAR(40) UNIQUE | รูปแบบ `[GAME]-[SET]-[CARTON]-[BOX]-[PACK]` เช่น OP-OP09-C02-B11-P07 |
| carton_no / box_no / pack_no | VARCHAR(8) | |
| status | ENUM('available','reserved','sold','queue_live','opened','delivered') | Status Tracker |
| owner_user_id | BIGINT FK→users | NULL จนกว่าจะถูกซื้อ |

---

## 4. คำสั่งซื้อ & ขนส่ง

### 4.1 orders
| คอลัมน์ | ชนิด | หมายเหตุ |
|---------|------|----------|
| id PK · order_no VARCHAR(24) UNIQUE | | เช่น OD20240501001 |
| user_id FK · shop_id FK · address_id FK | | |
| subtotal · shipping_fee · total | DECIMAL(10,2) | |
| fulfill_type | ENUM('ship_home','open_live') | รับที่บ้าน / เปิด LIVE |
| payment_method | ENUM('promptpay_qr','wallet') | |
| status | ENUM('pending_payment','paid','queue_live','packed','shipped','completed','cancelled') | |

### 4.2 order_items
| id PK · order_id FK · product_id FK · serial_id FK→product_serials · qty · unit_price |

### 4.3 shipments — พัสดุ
| คอลัมน์ | ชนิด | หมายเหตุ |
|---------|------|----------|
| id PK · order_id FK | | |
| carrier | ENUM('flash','jt','thaipost','dhl') | |
| tracking_no | VARCHAR(40) | |
| status | ENUM('preparing','picked_up','in_transit','out_for_delivery','delivered') | |
| timeline_json | JSON | log เวลาแต่ละสถานะ |

---

## 5. Live เปิดซอง

### 5.1 live_sessions
| id PK · shop_id FK · title · platform ENUM('facebook','youtube') · stream_url · scheduled_at · status ENUM('scheduled','live','ended') |

### 5.2 live_queues — คิวเปิดซอง
| คอลัมน์ | ชนิด | หมายเหตุ |
|---------|------|----------|
| id PK · live_session_id FK · order_item_id FK · user_id FK | | |
| queue_no | INT | ลำดับคิว |
| serial_id | BIGINT FK→product_serials | ซองที่จะเปิด |
| status | ENUM('waiting','locked','opening','done') | Turn Phase |
| result_cards_json | JSON | การ์ดที่เปิดได้ + rarity (sync เข้า collection) |
| is_priority | BOOL | สิทธิ์ลัดคิวจาก tier |

---

## 6. ประมูล

### 6.1 auctions
| คอลัมน์ | ชนิด | หมายเหตุ |
|---------|------|----------|
| id PK · shop_id FK · product_id FK | | |
| start_price · min_increment · buy_now_price | DECIMAL(10,2) | Smart Bidding |
| current_price | DECIMAL(10,2) | |
| current_winner_id | BIGINT FK→users | |
| start_at / end_at | DATETIME | |
| status | ENUM('scheduled','open','closed','settled','cancelled') | |

### 6.2 bids
| คอลัมน์ | ชนิด | หมายเหตุ |
|---------|------|----------|
| id PK · auction_id FK · user_id FK | | |
| amount | DECIMAL(10,2) | |
| is_auto_bid | BOOL | Auto Bid |
| locked_txn_id | BIGINT FK→wallet_transactions | เครดิตที่ล็อกไว้ · ⚠️ ยังไม่ implement — ต้องเพิ่มตอน implement Wallet Lock |
| status | ENUM('active','outbid','won','refunded') | Auto Refund |

---

## 7. คอลเลกชัน & บริการเสริม

### 7.1 collection_items — คลังการ์ดส่วนตัว
| id PK · user_id FK · product_id FK · serial_id FK · source ENUM('opening','auction','purchase') · est_value DECIMAL(10,2) · acquired_at |

### 7.2 wishlists
| id PK · user_id FK · product_id FK · created_at |

### 7.3 psa_submissions — ส่งเกรด PSA
| คอลัมน์ | ชนิด | หมายเหตุ |
|---------|------|----------|
| id PK · user_id FK | | |
| service_level | ENUM('economy','regular','express') | 20-25 / 10-15 / 5-7 วัน |
| note · qty | | |
| status | ENUM('preparing','sent_to_psa','grading','completed') | |

### 7.4 psa_items
| id PK · submission_id FK · collection_item_id FK · grade_result TINYINT |

### 7.5 buyback_listings — รับซื้อคืน (Buy-Back)
| id PK · shop_id FK · product_id FK · buy_price DECIMAL(10,2) · status ENUM('open','closed') |

### 7.6 buyback_requests
| id PK · buyback_listing_id FK · user_id FK · collection_item_id FK · offer_price · status ENUM('pending','accepted','rejected','paid') |

---

## 8. ระบบ & แจ้งเตือน

### 8.1 membership_tiers (ตารางอ้างอิง / config)
| tier · min_spent · min_wins · fee_discount_pct · priority_queue BOOL · cashback_pct |

### 8.2 notifications
| id PK · user_id FK · channel ENUM('line','email','in_app') · event VARCHAR(40) · payload_json · is_read BOOL |
| Trigger events: payment_success / queue_live / auction_won / psa_status / shipment_update |

### 8.3 audit_logs (Admin — Ultimate Security)
| id PK · actor_user_id FK · action · target_type · target_id · ip · created_at (encrypted) |

---

## 9. ดัชนีสำคัญ (Indexes)
- `product_serials.serial_code` UNIQUE — ค้นหา/สแกน serial
- `orders.order_no` UNIQUE · `orders(user_id, status)`
- `bids(auction_id, amount DESC)` — หา bid สูงสุด
- `live_queues(live_session_id, queue_no)`
- `wallet_transactions(wallet_id, created_at)`
- `collection_items(user_id)` · `notifications(user_id, is_read)`

# Active Task

_Last updated: 2026-05-30 (after caed_zone removal + remote DB switch)_

## Current goal

Phase 1 (Roadmap step 2) — สร้าง Eloquent Models สำหรับ business data
(Game, Set, Shop, Product, ProductSerial, Order, OrderItem, Auction, Bid)
+ เชื่อม PageController ให้ `/products`, `/auctions`, `/live` ดึงข้อมูลจริง

## What just happened

- 15:00 ลบ DB `caed_zone` ออกจากโปรเจค — ใช้ DB `siamcard` ตัวเดียวบน production (`shop.siamcardmarket.com`)
- ลบ: connection 'caed_zone' จาก config/database.php, DB_CAED_* จาก .env,
  `database/migrations/caed_zone/`, `database/caed_zone.sql`
- ทุก business tables (catalog/orders/auctions) จะสร้างใน `siamcard` ทั้งหมด
- ดู [sessions/2026-05-30-1450-split-db-siamcard-caed_zone.md](sessions/2026-05-30-1450-split-db-siamcard-caed_zone.md) สำหรับ split-db
- 25 tests ยังผ่านครบ

## Blockers

- **Remote MySQL ยัง connect ไม่ได้** — `shop.siamcardmarket.com:3306` timeout จาก IP `184.22.137.82`
  → ต้องเปิด Remote MySQL ใน cPanel (Databases → Remote MySQL → add IP)
- **GOOGLE_CLIENT_ID ยังว่าง** ใน `.env`
- **Demo users password = NULL** — login ผ่าน email/password ของ panya@/john@ ไม่ได้
  จนกว่าจะ set ผ่าน tinker

## Next step

1. (User) เปิด Remote MySQL ที่ cPanel + add IP `184.22.137.82`
2. ตรวจ schema remote — มี table `member` ไหม? ถ้ายังไม่มี run `php artisan migrate`
3. (User) ตั้ง GOOGLE_CLIENT_ID + SECRET ใน `.env` → test ปุ่ม Google
4. สร้าง Eloquent Models + migrations สำหรับ business tables (Game, Set, Shop, Product, ...)
5. เชื่อม `PageController@products`, `productShow`, `auctions`, `auctionShow`, `live`
6. แก้ Blade views ให้รับ `$products`, `$auctions` collection

## Reminder

- ใช้ `/brainstorming` skill ก่อนเริ่ม feature ใหม่ (per `.agents/topics/skills-playbook.md`)
- ใช้ `/test-driven-development` — เขียน test ก่อน production code
- ใช้ `/verification-before-completion` — รัน `php artisan test` ก่อนบอกเสร็จ
- ⚠️ Dev machine connect ตรงไป **production DB** — ทุก migrate/seed กระทบลูกค้าจริง · ระวังมาก

# Active Task

_Last updated: 2026-05-23_

## Current goal

Static mockup deploy บน GitHub Pages — แสดงให้ลูกค้าดู UI/UX ของ CARD ZONE

## What just happened

- Scaffold Laravel 11 ครบ (14 หน้า Blade · migrations ตาม database.md · auth พื้นฐาน · static:build command · workflow deploy ไป Pages)
- เจอ conflict ระหว่าง `pages.yml` (build docs/) กับ `static.yml` (default GitHub generate ตอน enable Pages — upload repo root) → ลบ static.yml ทิ้ง commit 89e78b7
- ทำ skill `/agents-init` ที่ `~/.claude/skills/agents-init/` แล้วรันใน repo นี้

## Blockers

- (รอ verify) workflow รอบใหม่หลังลบ static.yml ใช้ ~1-2 นาที — ถ้ายัง 404 ต้องดูว่า docs/ artifact ไปถูกที่ไหน

## Next step

1. รอ workflow รอบใหม่เสร็จ → curl `https://thitipongsaysood.github.io/TCG/` ดู
2. ถ้า OK ส่งลิงก์ให้ลูกค้า
3. ขั้นถัดไป (เลือกได้): seeder ตัวอย่าง, LINE/FB Login, PromptPay, real-time bidding (Reverb), Filament admin — ดู Roadmap ใน README.md

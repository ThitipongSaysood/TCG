# AGENTS.md — TCG

> Read this first. It explains how the `.agents/` directory works and how
> AI assistants should record progress so the next session can resume.

## Project

- **Name**: TCG (CARD ZONE — The Ultimate TCG Marketplace)
- **Type**: Laravel · Node.js (Vite)
- **Git remote**: https://github.com/ThitipongSaysood/TCG.git
- **Branch**: main
- **Bootstrapped**: 2026-05-23

## Rules for AI assistants

1. **Before starting work** — read [`active.md`](active.md) for the current
   goal, blockers, and next step. If empty, ask the user what they want to do.
2. **While working** — keep `active.md` up to date when the situation changes
   (new blocker, decision made, scope shift). One short sentence per update.
3. **When ending a work session** — append a checkpoint at
   `sessions/YYYY-MM-DD-HHMM-<slug>.md` with:
   - Goal of the session
   - What was actually done (files touched, decisions)
   - State at end (passing? blocked? half-done?)
   - Next step for whoever picks this up
4. **Cross-task knowledge** (architecture notes, API quirks, gotchas) goes in
   `topics/<slug>.md` — not in session checkpoints.
5. **Private / scratch / sensitive notes** go in `private/` — this subfolder
   is `.gitignore`d and never pushed.
6. **Re-generate** `index/repo-tree.md` if the directory structure changes
   significantly.

## Project rules (CARD ZONE specifics)

- **Stack reference**: see root [`README.md`](../README.md), [`design.md`](../design.md)
  (UI tokens, components), [`database.md`](../database.md) (DB schema with 8 sections)
- **Static mockup**: `php artisan static:build` renders all Blade pages to `docs/`
  (gitignored). GitHub Pages workflow deploys on push to main. Customer-facing
  demo URL → `https://thitipongsaysood.github.io/TCG/`
- **Demo auth state**: `BuildStatic` command fakes a logged-in user (PANYA,
  Gold tier) so the navbar shows the avatar chip instead of the login button
- **Card images**: real card art lives in `public/assets/images/` —
  `op-*` = One Piece, `pkm-*` = Pokémon. Don't reintroduce gradient placeholders
- **Mobile margin bug**: don't combine `container` + `section` on `<main>` —
  shorthand `.section{padding:40px 0}` kills container's `padding:0 16px`.
  Keep `.section` to top/bottom-only padding
- **Status Tracker**: `.htrack` is a connected stepper (no scroll). Don't
  re-add `overflow-x:auto` — it caused a visible scrollbar bug
- **Routes**: see [`routes/web.php`](../routes/web.php). Public: home, products,
  auctions, live. Auth-only: cart, checkout, collection, orders, profile, psa, tracking

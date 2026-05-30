@extends('layouts.app')

@section('title', 'Live Opening — CARD ZONE')

@section('content')
<main class="container">
  <div class="crumb"><a href="{{ route('home') }}">หน้าแรก</a> › <span style="color:var(--text-300)">Live Opening Queue</span></div>
  <div class="section-head"><h2>🔴 Live Opening Queue</h2><span class="badge badge-live"><span class="dot"></span>กำลังถ่ายทอดสด</span></div>

  <div class="split-3">
    <!-- stream -->
    <div class="col">
      <div class="live-screen">
        <div class="play"><svg width="24" height="24" viewBox="0 0 24 24" fill="#fff"><path d="M8 5l11 7-11 7z"/></svg></div>
        <span class="badge badge-live corner" style="top:12px;left:12px"><span class="dot"></span>LIVE · ร้าน CardZone Shop</span>
        <span class="badge badge-info corner-r" style="top:12px;right:12px">👁 1,204</span>
        <div class="overlay-tag">
          <div class="serial" style="border:none;padding:0;background:none">OP-OP09-C02-B11-P07</div>
          <div style="color:var(--text-100);font-weight:600;font-size:13px">กำลังเปิดให้: คุณบอย (Boy)</div>
        </div>
      </div>

      <!-- turn phases -->
      <div class="panel">
        <h3 style="font-size:15px;margin-bottom:12px">Turn Phase — ขั้นตอนเปิดซอง</h3>
        <div class="grid" style="grid-template-columns:1fr;gap:10px">
          <div class="opt"><span style="font-size:20px">🔒</span><span><b style="color:var(--text-100)">Phase 1: Lock Queue</b><br><small class="muted">ลูกค้ายืนยันการเปิด · ระบบจัดคิวอัตโนมัติ 1 นาที/ซอง</small></span></div>
          <div class="opt selected"><span style="font-size:20px">📹</span><span><b style="color:var(--text-100)">Phase 2: Live Stream</b><br><small class="muted">แสดงชื่อลูกค้า + Serial บนจอแบบเรียลไทม์</small></span></div>
          <div class="opt"><span style="font-size:20px">☁️</span><span><b style="color:var(--text-100)">Phase 3: Result Sync</b><br><small class="muted">อัปเดตการ์ดเข้า Collection ของลูกค้าทันที</small></span></div>
        </div>
      </div>

      <!-- my results -->
      <div class="panel">
        <div class="between"><h3 style="font-size:15px">ผลการเปิดซองของคุณ</h3><a href="{{ route('collection.index') }}" style="font-size:13px;color:var(--primary-bright)">ดูใน Collection</a></div>
        <div class="grid grid-cards mt-8">
          <div class="card"><div class="card-img holo" style="aspect-ratio:3/4"><img src="{{ asset('content/pkm-pikachu-ex-th.webp') }}" alt="Pikachu AR"><span class="badge badge-rare corner">SAR</span></div><div class="card-body"><div class="name">Pikachu AR</div></div></div>
          <div class="card"><div class="card-img holo" style="aspect-ratio:3/4"><img src="{{ asset('content/pkm-mewtwo-ex.webp') }}" alt="Mewtwo SR"><span class="badge badge-rare corner">SR</span></div><div class="card-body"><div class="name">Mewtwo SR</div></div></div>
          <div class="card"><div class="card-img holo" style="aspect-ratio:3/4"><img src="{{ asset('content/pkm-greninja-ex.webp') }}" alt="Trainer SR"><span class="badge badge-rare corner">SR</span></div><div class="card-body"><div class="name">Trainer SR</div></div></div>
        </div>
      </div>
    </div>

    <!-- queue sidebar -->
    <aside class="panel" style="align-self:start">
      <h3 style="font-size:16px;margin-bottom:4px">คิวผู้เปิดซอง</h3>
      <p class="muted" style="font-size:12px;margin-bottom:14px">ระบบ Auto-Queue · 1 นาที/ซอง</p>

      <div class="opt selected" style="margin-bottom:8px">
        <span class="av" style="width:34px;height:34px;border-radius:50%;background:var(--grad-gold);display:grid;place-items:center;color:#241a05;font-weight:700">#023</span>
        <span><b style="color:var(--text-100)">คุณ PANYA</b> <span class="badge badge-live" style="font-size:9px">กำลังเปิด</span><br><small class="muted">เวลา 12:23 น. · OP-OP09-C02-B11-P07</small></span>
      </div>
      <div class="opt" style="margin-bottom:8px"><span class="av" style="width:34px;height:34px;border-radius:50%;background:var(--bg-600);display:grid;place-items:center;color:var(--text-300);font-weight:700;font-size:12px">#024</span><span><b style="color:var(--text-100)">คุณ NUT</b><br><small class="muted">คิวถัดไป</small></span></div>
      <div class="opt" style="margin-bottom:8px"><span class="av" style="width:34px;height:34px;border-radius:50%;background:var(--bg-600);display:grid;place-items:center;color:var(--text-300);font-weight:700;font-size:12px">#025</span><span><b style="color:var(--text-100)">คุณ AEN</b><br><small class="muted">รออีก ~2 นาที</small></span></div>
      <div class="opt" style="margin-bottom:8px"><span class="av" style="width:34px;height:34px;border-radius:50%;background:var(--bg-600);display:grid;place-items:center;color:var(--text-300);font-weight:700;font-size:12px">#026</span><span><b style="color:var(--text-100)">คุณ MIND</b><br><small class="muted">รออีก ~3 นาที</small></span></div>

      <div class="divider"></div>
      <div class="glass" style="padding:12px;text-align:center">
        <small class="muted">สิทธิ์ Gold Member</small>
        <div class="text-gold" style="font-weight:700">⚡ Priority Queue — ลัดคิวได้</div>
      </div>
      <button class="btn btn-primary btn-block mt-16" data-toast="ยืนยันเข้าคิวเปิดซองแล้ว">ยืนยันเข้าคิวเปิดซอง</button>
    </aside>
  </div>

  <!-- other live rooms -->
  <section class="section">
    <div class="section-head"><h2>ห้อง Live อื่นๆ</h2></div>
    <div class="grid grid-cards">
      <div class="card"><div class="card-img holo"><img src="{{ asset('content/pkm-pikachu-ex-gold.webp') }}" alt="ร้าน B"><span class="badge badge-live corner"><span class="dot"></span>LIVE</span></div><div class="card-body"><div class="name">Pokemon 151 ลุ้น SAR</div><div class="meta">👁 880</div></div></div>
      <div class="card"><div class="card-img holo"><img src="{{ asset('content/op-luffy-gear4-op05.webp') }}" alt="ร้าน C"><span class="badge badge-live corner"><span class="dot"></span>LIVE</span></div><div class="card-body"><div class="name">Dragon Ball FB02</div><div class="meta">👁 642</div></div></div>
      <div class="card"><div class="card-img" style="background:linear-gradient(135deg,#2a1b4d,#13284d)">16:00 น.</div><div class="card-body"><div class="name">รอบ Live ถัดไป</div><div class="meta">ตั้งเตือน LINE</div></div></div>
      <div class="card"><div class="card-img" style="background:linear-gradient(135deg,#2a1b4d,#13284d)">19:00 น.</div><div class="card-body"><div class="name">รอบ Live ค่ำ</div><div class="meta">ตั้งเตือน LINE</div></div></div>
    </div>
  </section>
</main>
@endsection

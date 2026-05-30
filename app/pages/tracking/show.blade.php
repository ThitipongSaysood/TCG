@extends('layouts.app')

@section('title', 'ติดตามพัสดุ — CARD ZONE')

@section('content')
<main class="container">
  <div class="crumb"><a href="{{ route('orders.index') }}">คำสั่งซื้อ</a> › <span style="color:var(--text-300)">ติดตามพัสดุ</span></div>
  <div class="section-head"><h2>ติดตามพัสดุ</h2></div>

  <div class="split">
    <!-- tracking -->
    <div class="col">
      <div class="glass" style="padding:22px">
        <div class="between wrap">
          <div>
            <small class="muted">เลขพัสดุ</small>
            <div class="serial" style="font-size:14px;margin-top:4px">📦 FLASH1234S6789TH</div>
          </div>
          <span class="badge badge-info" style="font-size:13px">⚡ Flash Express</span>
        </div>
        <div class="divider"></div>
        <p class="muted" style="font-size:13px">คำสั่งซื้อ #OD20240430021 · Dragon Ball Fusion World FB02 ×3</p>
      </div>

      <div class="panel">
        <h3 style="font-size:16px;margin-bottom:16px">สถานะการจัดส่ง</h3>
        <div class="tracker">
          <div class="step done"><div class="dot">✓</div><div><h4>รับออเดอร์แล้ว</h4><small>20/05/2026 14:20</small></div></div>
          <div class="step done"><div class="dot">✓</div><div><h4>ระหว่างขนส่ง</h4><small>20/05/2026 18:35 · ออกจากศูนย์คัดแยก</small></div></div>
          <div class="step done"><div class="dot">✓</div><div><h4>พัสดุถึงสาขาปลายทาง</h4><small>21/05/2026 08:40</small></div></div>
          <div class="step current"><div class="dot">4</div><div><h4>กำลังจัดส่ง</h4><small>22/05/2026 10:15 · พนักงานกำลังนำส่ง</small></div></div>
          <div class="step"><div class="dot">5</div><div><h4>จัดส่งสำเร็จ</h4><small>คาดว่าวันนี้ก่อน 17:00 น.</small></div></div>
        </div>
      </div>

      <div class="glass" style="padding:16px;display:flex;gap:12px;align-items:center">
        <span style="font-size:24px">💬</span>
        <div class="grow"><b style="color:var(--text-100)">แจ้งเตือนผ่าน LINE Notify</b><p class="muted" style="font-size:12px">ระบบจะแจ้งทุกครั้งที่สถานะเปลี่ยน — ตรวจสอบในระบบได้โดยตรง ไม่ต้องสลับแอป</p></div>
        <span class="badge badge-success">เปิดอยู่</span>
      </div>
    </div>

    <!-- shipping detail -->
    <aside class="col">
      <div class="panel">
        <h3 style="font-size:15px;margin-bottom:10px">ที่อยู่ผู้รับ</h3>
        <div style="color:var(--text-100)">นาย พัฒนา จันทร์ดี</div>
        <p class="muted" style="font-size:13px">123/45 หมู่บ้านการ์ดโซน ถ.สีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500</p>
        <p class="muted" style="font-size:13px">โทร 081-234-5678</p>
      </div>

      <div class="panel">
        <h3 style="font-size:15px;margin-bottom:10px">ผู้ให้บริการขนส่ง</h3>
        <div class="col" style="gap:8px">
          <div class="opt selected">⚡ <span class="grow" style="color:var(--text-100)">Flash Express</span> <span class="badge badge-success">ใช้งาน</span></div>
          <div class="opt">🚚 <span class="grow">J&amp;T Express</span></div>
          <div class="opt">📮 <span class="grow">ไปรษณีย์ไทย</span></div>
          <div class="opt">✈️ <span class="grow">DHL</span></div>
        </div>
      </div>

      <div class="panel">
        <h3 style="font-size:15px;margin-bottom:8px">Status Tracker · Serial</h3>
        <div class="htrack">
          <div class="hstep done"><div class="hd">✓</div><span>Sold</span></div>
          <div class="hstep done"><div class="hd">✓</div><span>Packed</span></div>
          <div class="hstep current"><div class="hd">●</div><span>Shipped</span></div>
          <div class="hstep"><div class="hd">○</div><span>Delivered</span></div>
        </div>
      </div>

      <a href="{{ route('orders.index') }}" class="btn btn-ghost btn-block">← กลับไปที่คำสั่งซื้อ</a>
    </aside>
  </div>
</main>
@endsection

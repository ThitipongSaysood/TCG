@extends('layouts.app')

@section('title', 'ชำระเงิน — CARD ZONE')

@section('content')
<main class="container">
  <div class="crumb"><a href="{{ route('cart.index') }}">ตะกร้า</a> › <span style="color:var(--text-300)">ชำระเงิน</span></div>
  <div class="section-head"><h2>ชำระเงิน</h2></div>

  <div class="split">
    <!-- left: address + method -->
    <div class="col">
      <div class="panel">
        <div class="between"><h3 style="font-size:16px">ที่อยู่จัดส่ง</h3><a href="#" style="font-size:13px;color:var(--primary-bright)">เปลี่ยนที่อยู่</a></div>
        <div class="mt-8" style="color:var(--text-100)">นาย พัฒนา จันทร์ดี · 081-234-5678</div>
        <p class="muted">123/45 หมู่บ้านการ์ดโซน ถ.สีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500</p>
      </div>

      <div class="panel">
        <h3 style="font-size:16px;margin-bottom:12px">วิธีการชำระเงิน</h3>
        <div data-opt-group class="col">
          <label class="opt selected"><input type="radio" name="pay" checked>
            <span><b style="color:var(--text-100)">PromptPay QR</b><br><small class="muted">สแกนจ่ายผ่านธนาคาร · ระบบ Auto Verify ยืนยันทันที</small></span></label>
          <label class="opt"><input type="radio" name="pay">
            <span><b style="color:var(--text-100)">Wallet Credit</b><br><small class="muted">ยอดคงเหลือ ฿12,500 · ใช้จ่ายได้ทันทีไม่ต้องรออนุมัติ</small></span></label>
        </div>
      </div>

      <div class="panel">
        <h3 style="font-size:16px;margin-bottom:10px">รายการสินค้า</h3>
        <div class="between" style="padding:6px 0"><span>Pokemon 151 Booster Pack ×2</span><span>฿500</span></div>
        <div class="between" style="padding:6px 0"><span>One Piece OP09 Booster Pack ×1</span><span>฿180</span></div>
      </div>
    </div>

    <!-- right: QR + summary -->
    <aside class="col">
      <div class="glass" style="padding:22px;text-align:center">
        <span class="eyebrow">PromptPay</span>
        <h3 style="margin:6px 0 14px">สแกน QR เพื่อชำระเงิน</h3>
        <div style="width:200px;height:200px;margin:0 auto;background:#fff;border-radius:var(--r-md);display:grid;place-items:center;padding:14px">
          <svg viewBox="0 0 100 100" width="170" height="170" fill="#0B0A1A">
            <rect x="0" y="0" width="28" height="28"/><rect x="8" y="8" width="12" height="12" fill="#fff"/>
            <rect x="72" y="0" width="28" height="28"/><rect x="80" y="8" width="12" height="12" fill="#fff"/>
            <rect x="0" y="72" width="28" height="28"/><rect x="8" y="80" width="12" height="12" fill="#fff"/>
            <rect x="36" y="4" width="8" height="8"/><rect x="52" y="4" width="8" height="8"/>
            <rect x="40" y="20" width="8" height="8"/><rect x="60" y="36" width="8" height="8"/>
            <rect x="36" y="44" width="8" height="8"/><rect x="20" y="40" width="8" height="8"/>
            <rect x="44" y="60" width="8" height="8"/><rect x="68" y="60" width="8" height="8"/>
            <rect x="84" y="44" width="8" height="8"/><rect x="76" y="76" width="8" height="8"/>
            <rect x="56" y="76" width="8" height="8"/><rect x="40" y="84" width="8" height="8"/>
          </svg>
        </div>
        <p class="muted mt-16" style="font-size:13px">ยอดชำระ</p>
        <div class="price" style="font-size:30px">฿730.00</div>
        <p class="muted mt-8" style="font-size:12px">⏳ สแกนแล้วชำระภายใน 15:00 นาที</p>
      </div>

      <div class="panel">
        <div class="between" style="padding:4px 0"><span class="muted">ยอดรวมสินค้า</span><span>฿680</span></div>
        <div class="between" style="padding:4px 0"><span class="muted">ค่าจัดส่ง</span><span>฿50</span></div>
        <div class="divider"></div>
        <div class="between"><b style="color:var(--text-100)">รวมทั้งหมด</b><span class="price">฿730</span></div>
        <a href="{{ route('orders.index') }}" class="btn btn-gold btn-block btn-lg mt-16" data-toast="ยืนยันการชำระเงินแล้ว">ดำเนินการชำระเงินแล้ว</a>
      </div>
    </aside>
  </div>
</main>
@endsection

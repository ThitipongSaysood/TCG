@extends('layouts.app')

@section('title', 'ตะกร้าสินค้า — CARD ZONE')

@section('content')
<main class="container">
  <div class="crumb"><a href="{{ route('home') }}">หน้าแรก</a> › <span style="color:var(--text-300)">ตะกร้าสินค้า</span></div>
  <div class="section-head"><h2>ตะกร้าสินค้า</h2><span class="muted">2 รายการ</span></div>

  <div class="split-3">
    <div class="col">
      <!-- item -->
      <div class="panel">
        <div class="flex">
          <div class="card-img" style="width:84px;border-radius:var(--r-sm);aspect-ratio:3/4;font-size:11px;flex:none"><img src="{{ asset('content/pkm-pikachu-ex-rainbow.webp') }}" alt="Pokemon 151"></div>
          <div class="grow">
            <div class="between"><b style="color:var(--text-100)">Pokemon 151 Booster Pack</b>
              <button class="icon-btn" style="width:30px;height:30px" data-toast="ลบสินค้าแล้ว"><svg viewBox="0 0 24 24" fill="none"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2"/></svg></button></div>
            <p class="muted" style="font-size:12px">ร้าน CardZone Shop · รับสินค้ากลับบ้าน</p>
            <div class="between mt-8">
              <div class="qty"><button data-step="-">−</button><span>2</span><button data-step="+">+</button></div>
              <span class="price">฿500</span>
            </div>
          </div>
        </div>
      </div>
      <!-- item -->
      <div class="panel">
        <div class="flex">
          <div class="card-img" style="width:84px;border-radius:var(--r-sm);aspect-ratio:3/4;font-size:11px;flex:none"><img src="{{ asset('content/op-luffy-op13.webp') }}" alt="One Piece"></div>
          <div class="grow">
            <div class="between"><b style="color:var(--text-100)">One Piece OP09 Booster Pack</b>
              <button class="icon-btn" style="width:30px;height:30px" data-toast="ลบสินค้าแล้ว"><svg viewBox="0 0 24 24" fill="none"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2"/></svg></button></div>
            <p class="muted" style="font-size:12px">ร้าน Grand Line · <span class="text-gold">เปิด LIVE</span></p>
            <div class="between mt-8">
              <div class="qty"><button data-step="-">−</button><span>1</span><button data-step="+">+</button></div>
              <span class="price">฿180</span>
            </div>
          </div>
        </div>
      </div>
      <a href="{{ route('products.index') }}" class="btn btn-ghost">+ เลือกซื้อสินค้าเพิ่ม</a>
    </div>

    <!-- summary -->
    <aside class="panel" style="align-self:start">
      <h3 style="font-size:16px;margin-bottom:14px">สรุปคำสั่งซื้อ</h3>
      <div class="field"><label>โค้ดส่วนลด</label>
        <div class="flex"><input class="input" placeholder="กรอกโค้ดส่วนลด"><button class="btn btn-ghost" data-toast="ใช้โค้ดสำเร็จ">ใช้โค้ด</button></div>
      </div>
      <div class="divider"></div>
      <div class="between" style="padding:4px 0"><span class="muted">ยอดรวมสินค้า</span><span>฿680</span></div>
      <div class="between" style="padding:4px 0"><span class="muted">ค่าจัดส่ง</span><span>฿50</span></div>
      <div class="between" style="padding:4px 0"><span class="muted">ส่วนลด Gold Member</span><span class="text-gold">−฿0</span></div>
      <div class="divider"></div>
      <div class="between"><b style="color:var(--text-100)">รวมทั้งหมด</b><span class="price" style="font-size:22px">฿730</span></div>
      <a href="{{ route('checkout.index') }}" class="btn btn-gold btn-block btn-lg mt-16">ดำเนินการชำระเงิน</a>
      <p class="muted mt-8" style="font-size:12px;text-align:center">🔒 ชำระเงินปลอดภัยผ่านระบบ CARD ZONE</p>
    </aside>
  </div>
</main>
@endsection

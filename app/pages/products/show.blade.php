@extends('layouts.app')

@section('title', 'รายละเอียดสินค้า — CARD ZONE')

@section('content')
<main class="container">
  <div class="crumb"><a href="{{ route('home') }}">หน้าแรก</a> › <a href="{{ route('products.index') }}">Booster Pack</a> › <span style="color:var(--text-300)">Pokemon 151</span></div>

  <div class="split">
    <!-- gallery -->
    <div>
      <div class="card-img holo" id="galleryMain" style="border-radius:var(--r-lg);aspect-ratio:4/5;font-size:22px"><img src="{{ asset('content/pkm-pikachu-ex-rainbow.webp') }}" alt="Pokemon 151 Booster Pack"></div>
      <div class="grid" data-gallery style="grid-template-columns:repeat(4,1fr);margin-top:12px">
        <div class="gallery-thumb active" data-label="Pokemon 151 Booster Pack" data-img="assets/images/pkm-pikachu-ex-rainbow.webp">หน้า</div>
        <div class="gallery-thumb" data-label="ด้านหลังซอง" data-img="assets/images/pkm-pikachu-ex-gold.webp">หลัง</div>
        <div class="gallery-thumb" data-label="ตัวอย่างการ์ดในเซ็ต" data-img="assets/images/pkm-pikachu-ex-th.webp">การ์ด</div>
        <div class="gallery-thumb" data-label="Serial Barcode" data-img="assets/images/pkm-greninja-ex.webp">Serial</div>
      </div>
    </div>

    <!-- info -->
    <div>
      <div class="tag-list" style="margin-bottom:10px">
        <span class="badge badge-info">Pokémon</span>
        <span class="badge badge-rare">อัตรา Rare สูง</span>
        <span class="badge badge-success">พร้อมส่ง</span>
      </div>
      <h1 style="font-size:26px">Pokemon 151 Booster Pack</h1>
      <p class="muted" style="margin:6px 0 14px">ร้าน CardZone Shop · ⭐ 4.9 (2,140 รีวิว)</p>
      <div class="price" style="font-size:30px">฿250</div>
      <p class="muted">คงเหลือ <b style="color:var(--text-100)">128 ซอง</b></p>

      <div class="panel mt-16" style="padding:14px">
        <div class="between"><span class="muted" style="font-size:13px">ตัวอย่าง Serial Number</span><span class="badge badge-rare">Absolute Tracking</span></div>
        <div class="serial mt-8" style="font-size:14px">🔖 PKM-151-C01-B03-P18</div>
        <p class="muted mt-8" style="font-size:12px">ทุกซองมี "เลขบัตรประชาชน" ของตัวเอง — รูปแบบ [GAME]-[SET]-[CARTON]-[BOX]-[PACK] ป้องกันการสลับซอง 100%</p>
      </div>

      <div class="field mt-16"><label>เลือกวิธีรับสินค้า</label>
        <div data-opt-group class="col">
          <label class="opt selected"><input type="radio" name="fulfill" checked>
            <span><b style="color:var(--text-100)">รับสินค้ากลับบ้าน</b><br><small class="muted">จัดส่งซองปิดผนึก พร้อม Serial</small></span></label>
          <label class="opt"><input type="radio" name="fulfill">
            <span><b style="color:var(--text-100)">เปิด LIVE</b><br><small class="muted">เข้าคิวเปิดสด · ช่องทาง YouTube Live · คาดว่าคิว 12:31 น.</small></span></label>
        </div>
      </div>

      <div class="flex center mt-16">
        <span class="muted">จำนวน</span>
        <div class="qty"><button data-step="-">−</button><span>1</span><button data-step="+">+</button></div>
      </div>

      <div class="flex mt-16">
        <a href="{{ route('cart.index') }}" class="btn btn-ghost grow" data-toast="เพิ่มลงตะกร้าแล้ว">เพิ่มลงตะกร้า</a>
        <a href="{{ route('cart.index') }}" class="btn btn-gold grow">ซื้อเลย</a>
      </div>

      <div class="panel mt-16">
        <h3 style="font-size:15px;margin-bottom:8px">รายละเอียดสินค้า</h3>
        <table class="table">
          <tr><td class="muted">ชื่อชุด</td><td>Pokemon 151 (SV2a)</td></tr>
          <tr><td class="muted">การ์ดในชุด</td><td>165 ใบ</td></tr>
          <tr><td class="muted">อัตรา Rare</td><td>ลุ้น SR / SAR / Master Ball Mirror</td></tr>
          <tr><td class="muted">ภาษา</td><td>ญี่ปุ่น</td></tr>
          <tr><td class="muted">การ์ดต่อซอง</td><td>7 ใบ</td></tr>
        </table>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="section-head"><h2>สินค้าที่เกี่ยวข้อง</h2><a href="{{ route('products.index') }}">ดูทั้งหมด</a></div>
    <div class="grid grid-cards">
      <a class="card" href="{{ route('products.show', 1) }}"><div class="card-img holo"><img src="{{ asset('content/pkm-pikachu-ex-th.webp') }}" alt="Pokemon VSTAR"></div><div class="card-body"><div class="name">Pokemon VSTAR Universe</div><div class="between mt-8"><span class="price"><span class="baht">฿</span>250</span></div></div></a>
      <a class="card" href="{{ route('products.show', 1) }}"><div class="card-img"><img src="{{ asset('content/op-luffy-op13.webp') }}" alt="One Piece OP09"></div><div class="card-body"><div class="name">One Piece OP09 Booster</div><div class="between mt-8"><span class="price"><span class="baht">฿</span>180</span></div></div></a>
      <a class="card" href="{{ route('products.show', 1) }}"><div class="card-img"><img src="{{ asset('content/op-luffy-gear4-op05.webp') }}" alt="Dragon Ball FB01"></div><div class="card-body"><div class="name">Dragon Ball FB01</div><div class="between mt-8"><span class="price"><span class="baht">฿</span>220</span></div></div></a>
      <a class="card" href="{{ route('products.show', 1) }}"><div class="card-img"><img src="{{ asset('content/op-zoro-op06.webp') }}" alt="Digimon EX07"></div><div class="card-body"><div class="name">Digimon EX07</div><div class="between mt-8"><span class="price"><span class="baht">฿</span>150</span></div></div></a>
    </div>
  </section>
</main>
@endsection

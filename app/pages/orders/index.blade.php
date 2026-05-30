@extends('layouts.app')

@section('title', 'คำสั่งซื้อ — CARD ZONE')

@section('content')
<main class="container">
  <div class="crumb"><a href="{{ route('profile.show') }}">โปรไฟล์</a> › <span style="color:var(--text-300)">คำสั่งซื้อของฉัน</span></div>
  <div class="section-head"><h2>คำสั่งซื้อของฉัน</h2></div>

  <div class="tabs" data-tabs style="margin-bottom:16px">
    <button class="active">ทั้งหมด</button>
    <button>รอชำระเงิน</button>
    <button>กำลังจัดส่ง</button>
    <button>เปิด Live</button>
    <button>เสร็จสิ้น</button>
  </div>

  <div class="col">
    <!-- order -->
    <div class="panel">
      <div class="between wrap">
        <div><b style="color:var(--text-100)">#OD20240501001</b> <span class="muted" style="font-size:12px">· 22/05/2026</span></div>
        <span class="badge badge-warning">รอชำระเงิน</span>
      </div>
      <div class="divider"></div>
      <div class="flex center">
        <div class="card-img" style="width:60px;aspect-ratio:3/4;border-radius:var(--r-sm);font-size:10px;flex:none"><img src="{{ asset('content/pkm-pikachu-ex-rainbow.webp') }}" alt="Pokemon 151"></div>
        <div class="grow"><div style="color:var(--text-100)">Pokemon 151 Booster Pack ×2, One Piece OP09 ×1</div><small class="muted">ร้าน CardZone Shop · รับสินค้ากลับบ้าน</small></div>
        <div style="text-align:right"><div class="price">฿730</div></div>
      </div>
      <div class="flex mt-16"><a href="{{ route('checkout.index') }}" class="btn btn-gold btn-sm">ชำระเงิน</a><button class="btn btn-ghost btn-sm" data-toast="ยกเลิกคำสั่งซื้อแล้ว">ยกเลิก</button></div>
    </div>

    <!-- order -->
    <div class="panel">
      <div class="between wrap">
        <div><b style="color:var(--text-100)">#OD20240430021</b> <span class="muted" style="font-size:12px">· 20/05/2026</span></div>
        <span class="badge badge-info">กำลังจัดส่ง</span>
      </div>
      <div class="divider"></div>
      <div class="flex center">
        <div class="card-img holo" style="width:60px;aspect-ratio:3/4;border-radius:var(--r-sm);font-size:10px;flex:none"><img src="{{ asset('content/op-luffy-gear5-op05.webp') }}" alt="DBFW"></div>
        <div class="grow"><div style="color:var(--text-100)">Dragon Ball Fusion World FB02 ×3</div><small class="muted">ร้าน Capsule Co. · Flash Express</small></div>
        <div style="text-align:right"><div class="price">฿680</div></div>
      </div>
      <div class="flex mt-16"><a href="{{ route('tracking.show', 1) }}" class="btn btn-primary btn-sm">ติดตามพัสดุ</a></div>
    </div>

    <!-- order -->
    <div class="panel">
      <div class="between wrap">
        <div><b style="color:var(--text-100)">#OD20240428015</b> <span class="muted" style="font-size:12px">· 18/05/2026</span></div>
        <span class="badge badge-live"><span class="dot"></span>เข้าคิว Live</span>
      </div>
      <div class="divider"></div>
      <div class="flex center">
        <div class="card-img holo" style="width:60px;aspect-ratio:3/4;border-radius:var(--r-sm);font-size:10px;flex:none"><img src="{{ asset('content/op-luffy-op13.webp') }}" alt="OP09"></div>
        <div class="grow"><div style="color:var(--text-100)">One Piece OP09 Booster Pack ×2</div><small class="muted">ร้าน Grand Line · คิว #024</small></div>
        <div style="text-align:right"><div class="price">฿360</div></div>
      </div>
      <div class="flex mt-16"><a href="{{ route('live.index') }}" class="btn btn-primary btn-sm">ดูคิว Live</a></div>
    </div>

    <!-- order -->
    <div class="panel">
      <div class="between wrap">
        <div><b style="color:var(--text-100)">#OD20240425008</b> <span class="muted" style="font-size:12px">· 12/05/2026</span></div>
        <span class="badge badge-success">เสร็จสิ้น</span>
      </div>
      <div class="divider"></div>
      <div class="flex center">
        <div class="card-img" style="width:60px;aspect-ratio:3/4;border-radius:var(--r-sm);font-size:10px;flex:none"><img src="{{ asset('content/op-zoro-op06.webp') }}" alt="Digimon"></div>
        <div class="grow"><div style="color:var(--text-100)">Digimon Card Game EX07 ×3</div><small class="muted">ร้าน Digi World · จัดส่งสำเร็จ</small></div>
        <div style="text-align:right"><div class="price">฿450</div></div>
      </div>
      <div class="flex mt-16"><button class="btn btn-ghost btn-sm" data-toast="กำลังสั่งซื้อซ้ำ">สั่งซื้ออีกครั้ง</button><button class="btn btn-ghost btn-sm" data-toast="ขอบคุณสำหรับรีวิว">ให้คะแนน</button></div>
    </div>
  </div>
</main>
@endsection

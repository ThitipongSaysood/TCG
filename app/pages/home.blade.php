@extends('layouts.app')

@section('title', 'หน้าแรก — CARD ZONE')

@section('content')
<main class="container section">

  <!-- HERO -->
  <section class="hero">
    <span class="badge badge-live"><span class="dot"></span>LIVE OPENING วันนี้ 12:00 - 15:00 น.</span>
    <h1>The Ultimate <span class="holo-text">TCG Marketplace</span></h1>
    <p>ซื้อซองการ์ด · เปิด Live สด · ประมูลปลอดภัย ครบจบในที่เดียว
       รองรับ Pokémon, ONE PIECE, Yu-Gi-Oh!, Digimon และอีกมากมาย</p>
    <div class="flex wrap">
      <a href="{{ route('products.index') }}" class="btn btn-gold btn-lg">เลือกซื้อซองการ์ด</a>
      <a href="{{ route('live.index') }}" class="btn btn-ghost btn-lg">ดู Live ตอนนี้</a>
    </div>
    <div class="hero-stats">
      <div class="s"><b>27K+</b><span>การ์ดในระบบ</span></div>
      <div class="s"><b>20K+</b><span>การประมูล</span></div>
      <div class="s"><b>7K+</b><span>ร้านพาร์ทเนอร์</span></div>
      <div class="s"><b>40K+</b><span>นักสะสม</span></div>
    </div>
  </section>

  <!-- CATEGORIES -->
  <section class="section" style="padding-top:34px">
    <div class="section-head"><h2>เลือกตามจักรวาลการ์ด</h2></div>
    <div class="cats">
      <div class="cat"><div class="ico">⚡</div><span>Pokémon</span></div>
      <div class="cat"><div class="ico">🏴‍☠️</div><span>ONE PIECE</span></div>
      <div class="cat"><div class="ico">🐉</div><span>Dragon Ball</span></div>
      <div class="cat"><div class="ico">👾</div><span>Digimon</span></div>
      <div class="cat"><div class="ico">🃏</div><span>Yu-Gi-Oh!</span></div>
      <div class="cat"><div class="ico">⚔️</div><span>Vanguard</span></div>
    </div>
  </section>

  <!-- LIVE NOW -->
  <section class="section" style="padding-top:6px">
    <div class="section-head"><h2>🔴 Live Opening Now</h2><a href="{{ route('live.index') }}">ดูทั้งหมด</a></div>
    <div class="grid grid-cards">
      <div class="card" onclick="location.href='{{ route('live.index') }}'">
        <div class="card-img holo">
          <img src="{{ asset('content/op-luffy-op09.webp') }}" alt="ONE PIECE OP09 Luffy">
          <span class="badge badge-live corner"><span class="dot"></span>LIVE</span>
        </div>
        <div class="card-body"><div class="name">เปิดซอง ONE PIECE OP09 รอบบ่าย</div><div class="meta">👁 1,204 คนกำลังดู</div></div>
      </div>
      <div class="card" onclick="location.href='{{ route('live.index') }}'">
        <div class="card-img holo">
          <img src="{{ asset('content/pkm-pikachu-ex-gold.webp') }}" alt="Pokemon Pikachu ex">
          <span class="badge badge-live corner"><span class="dot"></span>LIVE</span>
        </div>
        <div class="card-body"><div class="name">เปิดซอง Pokemon 151 ลุ้น SAR</div><div class="meta">👁 880 คนกำลังดู</div></div>
      </div>
      <div class="card" onclick="location.href='{{ route('live.index') }}'">
        <div class="card-img holo">
          <img src="{{ asset('content/op-luffy-gear4-op05.webp') }}" alt="ONE PIECE Luffy Gear 4">
          <span class="badge badge-live corner"><span class="dot"></span>LIVE</span>
        </div>
        <div class="card-body"><div class="name">เปิดซอง Dragon Ball FB02</div><div class="meta">👁 642 คนกำลังดู</div></div>
      </div>
      <div class="card" onclick="location.href='{{ route('auctions.index') }}'">
        <div class="card-img" style="background:linear-gradient(135deg,#2a1b4d,#13284d)">
          เร็วๆ นี้
        </div>
        <div class="card-body"><div class="name">รอบ Live ถัดไป 16:00 น.</div><div class="meta">ตั้งเตือนผ่าน LINE</div></div>
      </div>
    </div>
  </section>

  <!-- BOOSTER LATEST -->
  <section class="section" style="padding-top:6px">
    <div class="section-head"><h2>Booster Pack ล่าสุด</h2><a href="{{ route('products.index') }}">ดูทั้งหมด</a></div>
    <div class="grid grid-cards">
      <div class="card" onclick="location.href='{{ route('products.show', 1) }}'">
        <div class="card-img"><img src="{{ asset('content/pkm-pikachu-ex-rainbow.webp') }}" alt="Pokemon 151"><span class="badge badge-rare corner-r">NEW</span></div>
        <div class="card-body"><div class="name">Pokemon 151 Booster Pack</div><div class="meta">คงเหลือ 128 ซอง</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>250</span><span class="btn btn-primary btn-sm">ซื้อ</span></div></div>
      </div>
      <div class="card" onclick="location.href='{{ route('products.show', 1) }}'">
        <div class="card-img"><img src="{{ asset('content/op-luffy-op13.webp') }}" alt="One Piece OP09"></div>
        <div class="card-body"><div class="name">One Piece OP09 Booster Pack</div><div class="meta">คงเหลือ 64 ซอง</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>180</span><span class="btn btn-primary btn-sm">ซื้อ</span></div></div>
      </div>
      <div class="card" onclick="location.href='{{ route('products.show', 1) }}'">
        <div class="card-img"><img src="{{ asset('content/op-luffy-gear4-op05.webp') }}" alt="Dragon Ball FB01"></div>
        <div class="card-body"><div class="name">Dragon Ball Fusion World FB01</div><div class="meta">คงเหลือ 92 ซอง</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>220</span><span class="btn btn-primary btn-sm">ซื้อ</span></div></div>
      </div>
      <div class="card" onclick="location.href='{{ route('products.show', 1) }}'">
        <div class="card-img"><img src="{{ asset('content/op-zoro-op06.webp') }}" alt="Digimon EX07"></div>
        <div class="card-body"><div class="name">Digimon Card Game EX07</div><div class="meta">คงเหลือ 40 ซอง</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>150</span><span class="btn btn-primary btn-sm">ซื้อ</span></div></div>
      </div>
    </div>
  </section>

  <!-- AUCTION HOT -->
  <section class="section" style="padding-top:6px">
    <div class="section-head"><h2>🔥 Auction Hot</h2><a href="{{ route('auctions.index') }}">ดูทั้งหมด</a></div>
    <div class="grid grid-cards">
      <div class="card" onclick="location.href='{{ route('auctions.show', 1) }}'">
        <div class="card-img holo"><img src="{{ asset('content/pkm-pikachu-ex-gold.webp') }}" alt="Pikachu ex Gold"><span class="badge badge-rare corner">PSA 10</span></div>
        <div class="card-body"><div class="name">Pikachu ex Gold PSA 10</div>
          <div class="meta">ราคาปัจจุบัน</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>12,500</span>
            <span class="badge badge-warning">⏱ <span data-countdown="02:31:55"></span></span></div></div>
      </div>
      <div class="card" onclick="location.href='{{ route('auctions.show', 1) }}'">
        <div class="card-img holo"><img src="{{ asset('content/op-luffy-purple.webp') }}" alt="Luffy ALT ART"><span class="badge badge-rare corner">ALT ART</span></div>
        <div class="card-body"><div class="name">Luffy ALT ART · OP05</div>
          <div class="meta">ราคาปัจจุบัน</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>5,500</span>
            <span class="badge badge-warning">⏱ <span data-countdown="03:12:20"></span></span></div></div>
      </div>
      <div class="card" onclick="location.href='{{ route('auctions.show', 1) }}'">
        <div class="card-img holo"><img src="{{ asset('content/op-luffy-gear5-op05.webp') }}" alt="Luffy Gear 5"><span class="badge badge-rare corner">SCR</span></div>
        <div class="card-body"><div class="name">Luffy Gear 5 SCR · OP05</div>
          <div class="meta">ราคาปัจจุบัน</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>2,800</span>
            <span class="badge badge-warning">⏱ <span data-countdown="04:22:10"></span></span></div></div>
      </div>
      <div class="card" onclick="location.href='{{ route('auctions.show', 1) }}'">
        <div class="card-img holo"><img src="{{ asset('content/pkm-pikachu.webp') }}" alt="Pikachu PSA 9"><span class="badge badge-rare corner">PSA 9</span></div>
        <div class="card-body"><div class="name">Pikachu PSA 9 · Promo</div>
          <div class="meta">ราคาปัจจุบัน</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>2,800</span>
            <span class="badge badge-warning">⏱ <span data-countdown="04:22:10"></span></span></div></div>
      </div>
    </div>
  </section>

  <!-- WHY US -->
  <section class="section" style="padding-top:6px">
    <div class="section-head"><h2>ทำไมต้อง CARD ZONE</h2></div>
    <div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr))">
      <div class="panel"><div class="cat-ico" style="font-size:26px">🛡️</div>
        <h3 class="mt-8">Serial Tracking 100%</h3>
        <p class="muted">ทุกซองมีเลข Serial ของตัวเอง ป้องกันการสลับซองได้เด็ดขาด</p></div>
      <div class="panel"><div style="font-size:26px">🔒</div>
        <h3 class="mt-8">Zero Fake Bids</h3>
        <p class="muted">ล็อก Wallet Credit ก่อนประมูล ไม่มี Bid ปลอม ไม่มีทิ้งประมูล</p></div>
      <div class="panel"><div style="font-size:26px">📺</div>
        <h3 class="mt-8">Auto-Queue Live</h3>
        <p class="muted">เปิดซองสดผ่านสตรีม ผลเข้าคลังการ์ดอัตโนมัติทันที</p></div>
      <div class="panel"><div style="font-size:26px">💎</div>
        <h3 class="mt-8">PSA & Buy-Back</h3>
        <p class="muted">ส่งเกรด PSA และรับซื้อคืนผ่านระบบ ไม่ต้องหาที่ขายเอง</p></div>
    </div>
  </section>

</main>
@endsection

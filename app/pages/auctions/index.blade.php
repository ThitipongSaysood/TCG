@extends('layouts.app')

@section('title', 'ประมูล — CARD ZONE')

@section('content')
<main class="container">
  <div class="crumb"><a href="{{ route('home') }}">หน้าแรก</a> › <span style="color:var(--text-300)">ประมูลการ์ด</span></div>
  <div class="section-head"><h2>ประมูลการ์ด</h2><span class="muted">112 รายการเปิดประมูล</span></div>

  <div class="glass" style="padding:14px 18px;margin-bottom:18px">
    <div class="between">
      <div><b style="color:var(--text-100)">🛡️ Zero Fake Bids</b><p class="muted" style="font-size:12px">ระบบล็อก Wallet Credit ก่อนทุกการ Bid · ไม่มี Bid ปลอม ไม่มีทิ้งประมูล</p></div>
      <a href="{{ route('profile.show') }}" class="btn btn-ghost btn-sm hide-xs">เติมเครดิต</a>
    </div>
  </div>

  <div class="tabs" data-tabs style="margin-bottom:16px">
    <button class="active">ทั้งหมด</button>
    <button>กำลังประมูล</button>
    <button>ใกล้ปิด</button>
    <button>จบแล้ว</button>
  </div>

  <div class="grid grid-cards">
    <a class="card" href="{{ route('auctions.show', 1) }}"><div class="card-img holo"><img src="{{ asset('content/pkm-pikachu-ex-gold.webp') }}" alt="Pikachu ex Gold"><span class="badge badge-rare corner">PSA 10</span><span class="badge badge-live corner-r"><span class="dot"></span>LIVE</span></div>
      <div class="card-body"><div class="name">Pikachu ex Gold PSA 10</div><div class="meta">บิดปัจจุบัน</div>
      <div class="between mt-8"><span class="price"><span class="baht">฿</span>12,500</span></div>
      <div class="badge badge-warning mt-8">⏱ <span data-countdown="02:31:55"></span></div>
      <button class="btn btn-gold btn-sm btn-block mt-8">ร่วมประมูล</button></div></a>

    <a class="card" href="{{ route('auctions.show', 1) }}"><div class="card-img holo"><img src="{{ asset('content/op-luffy-purple.webp') }}" alt="Luffy ALT ART"><span class="badge badge-rare corner">ALT ART</span></div>
      <div class="card-body"><div class="name">Luffy ALT ART · OP05</div><div class="meta">บิดปัจจุบัน</div>
      <div class="between mt-8"><span class="price"><span class="baht">฿</span>5,500</span></div>
      <div class="badge badge-warning mt-8">⏱ <span data-countdown="03:12:20"></span></div>
      <button class="btn btn-gold btn-sm btn-block mt-8">ร่วมประมูล</button></div></a>

    <a class="card" href="{{ route('auctions.show', 1) }}"><div class="card-img holo"><img src="{{ asset('content/op-luffy-gear5-op05.webp') }}" alt="Luffy Gear 5"><span class="badge badge-rare corner">SCR</span></div>
      <div class="card-body"><div class="name">Luffy Gear 5 SCR · OP05</div><div class="meta">บิดปัจจุบัน</div>
      <div class="between mt-8"><span class="price"><span class="baht">฿</span>2,800</span></div>
      <div class="badge badge-warning mt-8">⏱ <span data-countdown="04:22:10"></span></div>
      <button class="btn btn-gold btn-sm btn-block mt-8">ร่วมประมูล</button></div></a>

    <a class="card" href="{{ route('auctions.show', 1) }}"><div class="card-img holo"><img src="{{ asset('content/pkm-pikachu.webp') }}" alt="Pikachu PSA 9"><span class="badge badge-rare corner">PSA 9</span></div>
      <div class="card-body"><div class="name">Pikachu PSA 9 · Promo</div><div class="meta">บิดปัจจุบัน</div>
      <div class="between mt-8"><span class="price"><span class="baht">฿</span>2,800</span></div>
      <div class="badge badge-warning mt-8">⏱ <span data-countdown="04:48:33"></span></div>
      <button class="btn btn-gold btn-sm btn-block mt-8">ร่วมประมูล</button></div></a>

    <a class="card" href="{{ route('auctions.show', 1) }}"><div class="card-img holo"><img src="{{ asset('content/pkm-mewtwo-ex.webp') }}" alt="Mewtwo SAR"><span class="badge badge-rare corner">SAR</span></div>
      <div class="card-body"><div class="name">Mewtwo SAR · 151</div><div class="meta">บิดปัจจุบัน</div>
      <div class="between mt-8"><span class="price"><span class="baht">฿</span>8,200</span></div>
      <div class="badge badge-warning mt-8">⏱ <span data-countdown="01:05:00"></span></div>
      <button class="btn btn-gold btn-sm btn-block mt-8">ร่วมประมูล</button></div></a>

    <a class="card" href="{{ route('auctions.show', 1) }}"><div class="card-img holo"><img src="{{ asset('content/op-zoro-op06.webp') }}" alt="Zoro SEC"><span class="badge badge-rare corner">SEC</span></div>
      <div class="card-body"><div class="name">Zoro SEC · OP06</div><div class="meta">บิดปัจจุบัน</div>
      <div class="between mt-8"><span class="price"><span class="baht">฿</span>4,100</span></div>
      <div class="badge badge-warning mt-8">⏱ <span data-countdown="05:30:00"></span></div>
      <button class="btn btn-gold btn-sm btn-block mt-8">ร่วมประมูล</button></div></a>

    <a class="card" href="{{ route('auctions.show', 1) }}"><div class="card-img"><img src="{{ asset('content/op-zoro-op01.webp') }}" alt="Zoro SR"><span class="badge badge-danger corner">จบแล้ว</span></div>
      <div class="card-body"><div class="name">Zoro SR · ปิดประมูล</div><div class="meta">ราคาปิด</div>
      <div class="between mt-8"><span class="price"><span class="baht">฿</span>3,300</span></div>
      <div class="badge badge-success mt-8">✓ ผู้ชนะ: User_K</div></div></a>

    <a class="card" href="{{ route('auctions.show', 1) }}"><div class="card-img holo"><img src="{{ asset('content/pkm-greninja-ex.webp') }}" alt="Greninja ex UR"><span class="badge badge-rare corner">UR</span></div>
      <div class="card-body"><div class="name">Greninja ex UR · SAR</div><div class="meta">บิดปัจจุบัน</div>
      <div class="between mt-8"><span class="price"><span class="baht">฿</span>6,900</span></div>
      <div class="badge badge-warning mt-8">⏱ <span data-countdown="07:15:42"></span></div>
      <button class="btn btn-gold btn-sm btn-block mt-8">ร่วมประมูล</button></div></a>
  </div>
</main>
@endsection

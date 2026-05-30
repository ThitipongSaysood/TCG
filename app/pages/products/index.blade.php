@extends('layouts.app')

@section('title', 'Booster Pack — CARD ZONE')

@section('content')
<main class="container">
  <div class="crumb"><a href="{{ route('home') }}">หน้าแรก</a> › <span style="color:var(--text-300)">Booster Pack</span></div>
  <div class="section-head"><h2>Booster Pack ทั้งหมด</h2><span class="muted">พบ 248 รายการ</span></div>

  <div class="split-3">
    <!-- main grid -->
    <div>
      <div class="tabs" data-tabs style="margin-bottom:16px">
        <button class="active">ทั้งหมด</button>
        <button>มาใหม่</button>
        <button>ขายดี</button>
        <button>ใกล้หมด</button>
        <button>ราคาประหยัด</button>
      </div>
      <div class="grid grid-cards">
        <a class="card" href="{{ route('products.show', 1) }}"><div class="card-img"><img src="{{ asset('content/pkm-pikachu-ex-rainbow.webp') }}" alt="Pokemon 151"><span class="badge badge-rare corner-r">NEW</span></div>
          <div class="card-body"><div class="name">Pokemon 151 Booster Pack</div><div class="meta">ร้าน CardZone Shop · เหลือ 128</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>250</span><span class="btn btn-primary btn-sm">ซื้อ</span></div></div></a>
        <a class="card" href="{{ route('products.show', 1) }}"><div class="card-img"><img src="{{ asset('content/op-luffy-op13.webp') }}" alt="One Piece OP09"></div>
          <div class="card-body"><div class="name">One Piece OP09 Booster Pack</div><div class="meta">ร้าน Grand Line · เหลือ 64</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>180</span><span class="btn btn-primary btn-sm">ซื้อ</span></div></div></a>
        <a class="card" href="{{ route('products.show', 1) }}"><div class="card-img"><img src="{{ asset('content/op-luffy-gear4-op05.webp') }}" alt="Dragon Ball FB01"></div>
          <div class="card-body"><div class="name">Dragon Ball Fusion World FB01</div><div class="meta">ร้าน Capsule Co. · เหลือ 92</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>220</span><span class="btn btn-primary btn-sm">ซื้อ</span></div></div></a>
        <a class="card" href="{{ route('products.show', 1) }}"><div class="card-img"><img src="{{ asset('content/op-zoro-op06.webp') }}" alt="Digimon EX07"></div>
          <div class="card-body"><div class="name">Digimon Card Game EX07</div><div class="meta">ร้าน Digi World · เหลือ 40</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>150</span><span class="btn btn-primary btn-sm">ซื้อ</span></div></div></a>
        <a class="card" href="{{ route('products.show', 1) }}"><div class="card-img holo"><img src="{{ asset('content/pkm-pikachu-ex-th.webp') }}" alt="Pokemon VSTAR"></div>
          <div class="card-body"><div class="name">Pokemon VSTAR Universe</div><div class="meta">ร้าน CardZone Shop · เหลือ 70</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>250</span><span class="btn btn-primary btn-sm">ซื้อ</span></div></div></a>
        <a class="card" href="{{ route('products.show', 1) }}"><div class="card-img"><img src="{{ asset('content/op-luffy-op09.webp') }}" alt="One Piece OP08"></div>
          <div class="card-body"><div class="name">One Piece OP08 Booster Pack</div><div class="meta">ร้าน Grand Line · เหลือ 12</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>180</span><span class="btn btn-primary btn-sm">ซื้อ</span></div></div></a>
        <a class="card" href="{{ route('products.show', 1) }}"><div class="card-img"><img src="{{ asset('content/op-zoro-op01.webp') }}" alt="Dragon Ball FB02"></div>
          <div class="card-body"><div class="name">Dragon Ball Fusion World FB02</div><div class="meta">ร้าน Capsule Co. · เหลือ 88</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>250</span><span class="btn btn-primary btn-sm">ซื้อ</span></div></div></a>
        <a class="card" href="{{ route('products.show', 1) }}"><div class="card-img"><img src="{{ asset('content/pkm-gengar-ex.webp') }}" alt="Yu-Gi-Oh! AGOV"></div>
          <div class="card-body"><div class="name">Yu-Gi-Oh! Age of Overlord</div><div class="meta">ร้าน Duel Master · เหลือ 55</div>
          <div class="between mt-8"><span class="price"><span class="baht">฿</span>140</span><span class="btn btn-primary btn-sm">ซื้อ</span></div></div></a>
      </div>
    </div>

    <!-- filter sidebar -->
    <aside class="panel" style="align-self:start">
      <h3 style="font-size:16px;margin-bottom:14px">ตัวกรอง</h3>
      <div class="field"><label>ประเภทเกม</label>
        <label class="checkbox" style="margin:6px 0"><input type="checkbox" checked>Pokémon</label>
        <label class="checkbox" style="margin:6px 0"><input type="checkbox">One Piece</label>
        <label class="checkbox" style="margin:6px 0"><input type="checkbox">Dragon Ball</label>
        <label class="checkbox" style="margin:6px 0"><input type="checkbox">Digimon</label>
        <label class="checkbox" style="margin:6px 0"><input type="checkbox">Yu-Gi-Oh!</label>
      </div>
      <div class="divider"></div>
      <div class="field"><label>ช่วงราคา (บาท)</label>
        <div class="flex"><input class="input" type="number" placeholder="ต่ำสุด"><input class="input" type="number" placeholder="สูงสุด"></div>
      </div>
      <div class="field"><label>เรียงลำดับ</label>
        <select class="select"><option>ล่าสุด</option><option>ราคาน้อย → มาก</option><option>ราคามาก → น้อย</option><option>ขายดี</option></select>
      </div>
      <button class="btn btn-primary btn-block mt-8">ค้นหา</button>
      <button class="btn btn-ghost btn-block mt-8" style="margin-top:8px">ล้างตัวกรอง</button>
    </aside>
  </div>
</main>
@endsection

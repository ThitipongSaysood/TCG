@extends('layouts.app')

@section('title', 'Collection ของฉัน — CARD ZONE')

@section('content')
<main class="container">
  <div class="crumb"><a href="{{ route('profile.show') }}">โปรไฟล์</a> › <span style="color:var(--text-300)">Card Collection</span></div>

  <!-- portfolio hero -->
  <div class="glass" style="padding:24px;margin-bottom:18px">
    <span class="eyebrow">Personal Collection · Portfolio</span>
    <div class="between wrap mt-8">
      <div>
        <p class="muted" style="font-size:13px">มูลค่ารวมการ์ดที่ครอบครอง</p>
        <h1 class="holo-text" style="font-size:38px;font-family:'Sora',sans-serif">฿88,000,000</h1>
      </div>
      <div class="flex wrap">
        <div class="panel" style="text-align:center;min-width:110px"><div class="price" style="font-size:22px">156</div><small class="muted">การ์ดทั้งหมด</small></div>
        <div class="panel" style="text-align:center;min-width:110px"><div class="price" style="font-size:22px">42</div><small class="muted">ระดับ Rare+</small></div>
        <div class="panel" style="text-align:center;min-width:110px"><div class="price" style="font-size:22px">89</div><small class="muted">ครั้งเปิดซอง</small></div>
      </div>
    </div>
  </div>

  <div class="split">
    <div>
      <div class="tabs" data-tabs style="margin-bottom:16px">
        <button class="active">ทั้งหมด</button>
        <button>จากการเปิดซอง</button>
        <button>จากประมูล</button>
        <button>จากการซื้อ</button>
      </div>
      <div class="grid grid-cards">
        <div class="card"><div class="card-img holo"><img src="{{ asset('content/pkm-pikachu-ex-th.webp') }}" alt="Pikachu AR"><span class="badge badge-rare corner">SAR</span></div><div class="card-body"><div class="name">Pikachu AR</div><div class="between mt-8"><span class="price" style="font-size:15px">฿12,500</span><span class="badge badge-info">เปิดซอง</span></div></div></div>
        <div class="card"><div class="card-img holo"><img src="{{ asset('content/pkm-mewtwo-ex.webp') }}" alt="Mewtwo SR"><span class="badge badge-rare corner">SR</span></div><div class="card-body"><div class="name">Mewtwo SR</div><div class="between mt-8"><span class="price" style="font-size:15px">฿5,500</span><span class="badge badge-info">เปิดซอง</span></div></div></div>
        <div class="card"><div class="card-img holo"><img src="{{ asset('content/op-luffy-op13.webp') }}" alt="Luffy SEC"><span class="badge badge-rare corner">SEC</span></div><div class="card-body"><div class="name">Luffy SEC</div><div class="between mt-8"><span class="price" style="font-size:15px">฿8,200</span><span class="badge badge-success">ประมูล</span></div></div></div>
        <div class="card"><div class="card-img holo"><img src="{{ asset('content/op-luffy-gear5-op05.webp') }}" alt="Luffy Gear 5"><span class="badge badge-rare corner">SCR</span></div><div class="card-body"><div class="name">Luffy Gear 5 SCR</div><div class="between mt-8"><span class="price" style="font-size:15px">฿2,800</span><span class="badge badge-success">ประมูล</span></div></div></div>
        <div class="card"><div class="card-img holo"><img src="{{ asset('content/pkm-gengar-ex.webp') }}" alt="Gengar ex"><span class="badge badge-rare corner">UR</span></div><div class="card-body"><div class="name">Gengar ex UR</div><div class="between mt-8"><span class="price" style="font-size:15px">฿6,900</span><span class="badge badge-info">เปิดซอง</span></div></div></div>
        <div class="card"><div class="card-img holo"><img src="{{ asset('content/op-zoro-op01.webp') }}" alt="Zoro SR"><span class="badge badge-rare corner">SR</span></div><div class="card-body"><div class="name">Zoro SR</div><div class="between mt-8"><span class="price" style="font-size:15px">฿3,300</span><span class="badge badge-warning">ซื้อ</span></div></div></div>
        <div class="card"><div class="card-img holo"><img src="{{ asset('content/pkm-mewtwo-ex.webp') }}" alt="Mewtwo AR"><span class="badge badge-rare corner">AR</span></div><div class="card-body"><div class="name">Mewtwo AR</div><div class="between mt-8"><span class="price" style="font-size:15px">฿4,100</span><span class="badge badge-info">เปิดซอง</span></div></div></div>
        <div class="card"><div class="card-img holo"><img src="{{ asset('content/op-zoro-op06.webp') }}" alt="Zoro SAR"><span class="badge badge-rare corner">SAR</span></div><div class="card-body"><div class="name">Zoro SAR</div><div class="between mt-8"><span class="price" style="font-size:15px">฿7,400</span><span class="badge badge-success">ประมูล</span></div></div></div>
      </div>
    </div>

    <!-- side: stats + wishlist -->
    <aside class="col">
      <div class="panel">
        <h3 style="font-size:15px;margin-bottom:10px">Rare Stats · สถิติการ์ดหายาก</h3>
        <div class="col" style="gap:10px">
          <div><div class="between" style="font-size:13px"><span>SAR</span><span class="text-gold">12 ใบ</span></div><div style="height:7px;background:var(--bg-600);border-radius:999px;margin-top:4px"><div style="width:30%;height:100%;background:var(--grad-gold);border-radius:999px"></div></div></div>
          <div><div class="between" style="font-size:13px"><span>SR</span><span class="text-gold">18 ใบ</span></div><div style="height:7px;background:var(--bg-600);border-radius:999px;margin-top:4px"><div style="width:48%;height:100%;background:var(--grad-primary);border-radius:999px"></div></div></div>
          <div><div class="between" style="font-size:13px"><span>Rare</span><span class="text-gold">12 ใบ</span></div><div style="height:7px;background:var(--bg-600);border-radius:999px;margin-top:4px"><div style="width:30%;height:100%;background:linear-gradient(135deg,#3B82F6,#E24DF5);border-radius:999px"></div></div></div>
        </div>
      </div>

      <div class="panel">
        <div class="between"><h3 style="font-size:15px">❤️ Wishlist</h3><a href="{{ route('products.index') }}" style="font-size:13px;color:var(--primary-bright)">เพิ่ม</a></div>
        <div class="col mt-8" style="gap:8px">
          <div class="opt"><div class="card-img holo" style="width:34px;aspect-ratio:3/4;border-radius:6px;font-size:8px;flex:none"><img src="{{ asset('content/pkm-pikachu-ex-gold.webp') }}" alt="Charizard SAR"></div><span class="grow" style="color:var(--text-100)">Charizard SAR · 151</span></div>
          <div class="opt"><div class="card-img holo" style="width:34px;aspect-ratio:3/4;border-radius:6px;font-size:8px;flex:none"><img src="{{ asset('content/op-luffy-purple.webp') }}" alt="Ace ALT ART"></div><span class="grow" style="color:var(--text-100)">Ace ALT ART · OP</span></div>
          <div class="opt"><div class="card-img holo" style="width:34px;aspect-ratio:3/4;border-radius:6px;font-size:8px;flex:none"><img src="{{ asset('content/op-luffy-gear4-op05.webp') }}" alt="Gohan SCR"></div><span class="grow" style="color:var(--text-100)">Gohan SCR · DBFW</span></div>
        </div>
      </div>

      <div class="panel">
        <h3 style="font-size:15px;margin-bottom:8px">Opening History</h3>
        <table class="table">
          <tr><td>OP-OP09-C02-B11-P07</td><td><span class="badge badge-rare">SAR</span></td></tr>
          <tr><td>PKM-151-C01-B03-P18</td><td><span class="badge badge-rare">SR</span></td></tr>
          <tr><td>DB-FB02-C03-B05-P02</td><td><span class="badge badge-info">Rare</span></td></tr>
        </table>
      </div>
    </aside>
  </div>
</main>
@endsection

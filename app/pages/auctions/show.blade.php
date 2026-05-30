@extends('layouts.app')

@section('title', 'รายละเอียดประมูล — CARD ZONE')

@section('content')
<main class="container">
  <div class="crumb"><a href="{{ route('auctions.index') }}">ประมูลการ์ด</a> › <span style="color:var(--text-300)">Charizard PSA 10</span></div>

  <div class="split">
    <!-- card image -->
    <div>
      <div class="card-img holo" style="border-radius:var(--r-lg);aspect-ratio:4/5;font-size:22px">
        <img src="{{ asset('content/pkm-pikachu-ex-gold.webp') }}" alt="Pikachu ex Gold PSA 10">
        <span class="badge badge-rare corner">PSA 10 GEM MINT</span>
      </div>
      <div class="grid" style="grid-template-columns:repeat(4,1fr);margin-top:12px">
        <div class="gallery-thumb active">หน้า</div>
        <div class="gallery-thumb">หลัง</div>
        <div class="gallery-thumb">มุม</div>
        <div class="gallery-thumb">PSA</div>
      </div>

      <div class="panel mt-16">
        <h3 style="font-size:15px;margin-bottom:8px">รายละเอียดการ์ด</h3>
        <table class="table">
          <tr><td class="muted">ชื่อการ์ด</td><td>Charizard ex · SV2a 151</td></tr>
          <tr><td class="muted">เกรด</td><td>PSA 10 (Gem Mint)</td></tr>
          <tr><td class="muted">ผู้ขาย</td><td>CardZone Shop ⭐ 4.9</td></tr>
          <tr><td class="muted">เริ่มประมูล</td><td>22/05/2026 10:00</td></tr>
          <tr><td class="muted">ปิดประมูล</td><td>22/05/2026 15:00</td></tr>
        </table>
      </div>
    </div>

    <!-- bidding panel -->
    <div class="col">
      <div class="glass" style="padding:22px">
        <div class="tag-list" style="margin-bottom:8px">
          <span class="badge badge-rare">PSA 10</span><span class="badge badge-live"><span class="dot"></span>กำลังประมูล</span>
        </div>
        <h1 style="font-size:24px">Charizard PSA 10</h1>

        <div class="row" style="margin:16px 0">
          <div class="panel grow" style="text-align:center;padding:14px">
            <small class="muted">ราคาปัจจุบัน</small>
            <div class="price" style="font-size:26px">฿12,500</div>
          </div>
          <div class="panel grow" style="text-align:center;padding:14px">
            <small class="muted">ราคาซื้อทันที</small>
            <div class="price" style="font-size:26px">฿12,700</div>
          </div>
        </div>

        <div class="panel" style="text-align:center;padding:12px;background:rgba(251,191,36,.08)">
          <small class="muted">เวลาที่เหลือ</small>
          <div class="text-gold" style="font-size:24px;font-weight:800;font-family:'Sora',sans-serif" data-countdown="02:31:55"></div>
        </div>

        <div class="field mt-16"><label>ใส่ราคาประมูล (ขั้นต่ำ +฿200)</label>
          <input class="input" type="number" placeholder="12,700" value="12700">
        </div>
        <div class="flex">
          <button class="btn btn-gold grow" data-toast="ระบบล็อกเครดิต ฿12,700 — ประมูลสำเร็จ">ประมูล</button>
          <button class="btn btn-primary grow" data-toast="ซื้อทันทีสำเร็จ">ซื้อทันที</button>
        </div>
        <label class="checkbox mt-16"><input type="checkbox">เปิด Auto Bid อัตโนมัติสูงสุด ฿15,000</label>
        <p class="muted mt-8" style="font-size:12px">🛡️ ระบบล็อก Wallet Credit ก่อนยืนยัน Bid — ผู้แพ้ได้รับ Auto Refund ทันที</p>
      </div>

      <div class="panel">
        <h3 style="font-size:15px;margin-bottom:10px">ประวัติการประมูล</h3>
        <table class="table">
          <thead><tr><th>ผู้ประมูล</th><th>ราคา</th><th>เวลา</th></tr></thead>
          <tbody>
            <tr><td>User_A 🏆</td><td class="text-gold">฿12,500</td><td class="muted">12:28:10</td></tr>
            <tr><td>User_B</td><td>฿12,300</td><td class="muted">12:27:46</td></tr>
            <tr><td>User_C</td><td>฿12,100</td><td class="muted">12:25:33</td></tr>
            <tr><td>User_A</td><td>฿11,800</td><td class="muted">12:22:09</td></tr>
            <tr><td>User_D</td><td>฿11,500</td><td class="muted">12:18:55</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
@endsection

@extends('layouts.app')

@section('title', 'โปรไฟล์ — CARD ZONE')

@section('content')
<main class="container">
  <div class="crumb"><a href="{{ route('home') }}">หน้าแรก</a> › <span style="color:var(--text-300)">โปรไฟล์</span></div>

  <!-- profile header -->
  <div class="glass" style="padding:24px;margin-bottom:18px">
    <div class="flex center wrap">
      <span class="av" style="width:72px;height:72px;border-radius:50%;background:var(--grad-primary);display:grid;place-items:center;color:#fff;font-weight:800;font-size:28px">P</span>
      <div class="grow">
        <h1 style="font-size:22px">PANYA จันทร์ดี</h1>
        <span class="badge badge-rare">🏅 Gold Member</span>
        <p class="muted mt-8" style="font-size:13px">สมาชิกตั้งแต่ ม.ค. 2024 · it.9plus@gmail.com</p>
      </div>
      <div class="panel" style="text-align:center;min-width:170px">
        <small class="muted">ยอดเงิน Wallet</small>
        <div class="price" style="font-size:26px">฿12,500</div>
        <button class="btn btn-gold btn-sm btn-block mt-8" data-toast="เปิด PromptPay QR เติมเครดิต">เติมเครดิต</button>
      </div>
    </div>
  </div>

  <div class="split">
    <!-- menu -->
    <div class="col">
      <div class="panel">
        <h3 style="font-size:16px;margin-bottom:12px">เมนูสมาชิก</h3>
        <a href="{{ route('orders.index') }}" class="opt" style="margin-bottom:8px">📦 <span class="grow" style="color:var(--text-100)">คำสั่งซื้อของฉัน</span> ›</a>
        <a href="{{ route('collection.index') }}" class="opt" style="margin-bottom:8px">🃏 <span class="grow" style="color:var(--text-100)">Card Collection</span> ›</a>
        <a href="{{ route('psa.index') }}" class="opt" style="margin-bottom:8px">💎 <span class="grow" style="color:var(--text-100)">ส่งการ์ดเกรด PSA</span> ›</a>
        <a href="{{ route('tracking.show', 1) }}" class="opt" style="margin-bottom:8px">🚚 <span class="grow" style="color:var(--text-100)">ติดตามพัสดุ</span> ›</a>
        <a href="#" class="opt" style="margin-bottom:8px">📍 <span class="grow" style="color:var(--text-100)">ที่อยู่จัดส่ง</span> ›</a>
        <a href="#" class="opt" style="margin-bottom:8px">⚙️ <span class="grow" style="color:var(--text-100)">ตั้งค่าบัญชี</span> ›</a>
        <a href="{{ route('login') }}" class="opt" style="color:var(--danger)">↩ <span class="grow">ออกจากระบบ</span></a>
      </div>

      <div class="panel">
        <h3 style="font-size:16px;margin-bottom:10px">ประวัติ Wallet</h3>
        <table class="table">
          <tr><td>เติมเครดิต PromptPay</td><td class="text-gold">+฿5,000</td><td class="muted">20/05</td></tr>
          <tr><td>ชนะประมูล Mewtwo SAR</td><td style="color:var(--danger)">−฿8,200</td><td class="muted">18/05</td></tr>
          <tr><td>Auto Refund (แพ้ประมูล)</td><td class="text-gold">+฿3,300</td><td class="muted">17/05</td></tr>
          <tr><td>Cashback Gold Member</td><td class="text-gold">+฿120</td><td class="muted">15/05</td></tr>
        </table>
      </div>
    </div>

    <!-- membership tier -->
    <aside class="col">
      <div class="glass" style="padding:20px">
        <span class="eyebrow">Membership Tier</span>
        <h3 style="margin:6px 0 4px">ระดับ Gold 🏅</h3>
        <p class="muted" style="font-size:13px">อีก ฿7,500 เพื่อเลื่อนเป็น Platinum</p>
        <div style="height:10px;background:var(--bg-600);border-radius:999px;overflow:hidden;margin:12px 0">
          <div style="width:68%;height:100%;background:var(--grad-gold)"></div>
        </div>
        <div class="between" style="font-size:12px"><span class="muted">ยอดสะสม ฿42,500</span><span class="muted">เป้า ฿50,000</span></div>
      </div>

      <div class="panel">
        <h3 style="font-size:15px;margin-bottom:10px">สิทธิพิเศษ Gold</h3>
        <div class="col" style="gap:8px">
          <div class="opt">✅ <span style="color:var(--text-100)">ส่วนลดค่าธรรมเนียม 5%</span></div>
          <div class="opt">⚡ <span style="color:var(--text-100)">Priority Queue ลัดคิว Live</span></div>
          <div class="opt">💰 <span style="color:var(--text-100)">Cashback 1% ทุกการซื้อ</span></div>
          <div class="opt">🎁 <span style="color:var(--text-100)">Coin Reward สะสมแลกของ</span></div>
        </div>
      </div>

      <div class="panel" style="text-align:center">
        <div class="row" style="justify-content:space-around">
          <div><div class="price" style="font-size:22px">28</div><small class="muted">ครั้งที่ชนะประมูล</small></div>
          <div><div class="price" style="font-size:22px">156</div><small class="muted">การ์ดในคลัง</small></div>
        </div>
      </div>
    </aside>
  </div>
</main>
@endsection

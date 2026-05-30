@extends('layouts.app')

@section('title', 'ส่งเกรด PSA — CARD ZONE')

@section('content')
<main class="container">
  <div class="crumb"><a href="{{ route('profile.show') }}">โปรไฟล์</a> › <span style="color:var(--text-300)">ส่งการ์ดเกรด PSA</span></div>
  <div class="section-head"><h2>ส่งการ์ดไปเกรด PSA</h2></div>

  <div class="split">
    <!-- form -->
    <div class="col">
      <div class="panel">
        <h3 style="font-size:16px;margin-bottom:12px">อัปโหลดรูปการ์ด</h3>
        <div style="border:1.5px dashed var(--border);border-radius:var(--r-md);padding:34px;text-align:center;cursor:pointer" data-toast="เลือกรูปการ์ดจากเครื่อง">
          <div style="font-size:34px">＋</div>
          <p class="muted">เพิ่มรูปภาพการ์ด (สูงสุด 8 รูป)</p>
        </div>
        <div class="grid" style="grid-template-columns:repeat(4,1fr);margin-top:12px">
          <div class="gallery-thumb active">Pikachu</div>
          <div class="gallery-thumb">Mewtwo</div>
          <div class="gallery-thumb">Luffy</div>
          <div class="gallery-thumb">Goku</div>
        </div>
      </div>

      <div class="panel">
        <h3 style="font-size:16px;margin-bottom:12px">เลือกระดับบริการ</h3>
        <div data-opt-group class="col">
          <label class="opt selected"><input type="radio" name="svc" checked>
            <span class="grow"><b style="color:var(--text-100)">Economy</b><br><small class="muted">20-25 วันทำการ</small></span><span class="price" style="font-size:16px">฿450</span></label>
          <label class="opt"><input type="radio" name="svc">
            <span class="grow"><b style="color:var(--text-100)">Regular</b><br><small class="muted">10-15 วันทำการ</small></span><span class="price" style="font-size:16px">฿850</span></label>
          <label class="opt"><input type="radio" name="svc">
            <span class="grow"><b style="color:var(--text-100)">Express</b><br><small class="muted">5-7 วันทำการ</small></span><span class="price" style="font-size:16px">฿1,500</span></label>
        </div>
      </div>

      <div class="panel">
        <div class="field"><label>จำนวนการ์ด</label>
          <div class="qty"><button data-step="-">−</button><span>1</span><button data-step="+">+</button></div>
        </div>
        <div class="field"><label>หมายเหตุเพิ่มเติม (ถ้ามี)</label>
          <textarea class="textarea" placeholder="กรอกข้อมูลเพิ่มเติม เช่น ตำหนิ มุมการ์ด..."></textarea>
        </div>
        <button class="btn btn-gold btn-block btn-lg" data-toast="ส่งคำขอเกรด PSA สำเร็จ">ยืนยันการส่ง</button>
      </div>
    </div>

    <!-- status side -->
    <aside class="col">
      <div class="glass" style="padding:20px">
        <span class="eyebrow">Path A · PSA Grading</span>
        <h3 style="margin:6px 0 12px">ติดตามสถานะแบบเรียลไทม์</h3>
        <div class="tracker">
          <div class="step done"><div class="dot">✓</div><div><h4>Preparing</h4><small>เตรียมเอกสาร · 20/05</small></div></div>
          <div class="step current"><div class="dot">2</div><div><h4>Sent to PSA</h4><small>ส่งถึงศูนย์ PSA · 22/05</small></div></div>
          <div class="step"><div class="dot">3</div><div><h4>Grading</h4><small>อยู่ระหว่างประเมินเกรด</small></div></div>
          <div class="step"><div class="dot">4</div><div><h4>Completed</h4><small>รับการ์ดเกรดคืน</small></div></div>
        </div>
      </div>

      <div class="panel">
        <h3 style="font-size:15px;margin-bottom:8px">ประวัติการส่งเกรด</h3>
        <table class="table">
          <tr><td>#PSA-0231</td><td><span class="badge badge-warning">Grading</span></td></tr>
          <tr><td>#PSA-0198</td><td><span class="badge badge-success">PSA 10</span></td></tr>
          <tr><td>#PSA-0185</td><td><span class="badge badge-success">PSA 9</span></td></tr>
        </table>
      </div>

      <div class="glass" style="padding:18px">
        <h3 style="font-size:15px">💰 Path B · Buy-Back</h3>
        <p class="muted mt-8" style="font-size:13px">ไม่อยากเกรด? ส่งรูปประเมิน → ตกลงราคา → รับเงินเข้า Wallet ทันที ไม่ต้องหาที่ขายเอง</p>
        <button class="btn btn-ghost btn-block mt-16" data-toast="เปิดระบบรับซื้อคืน Buy-Back">ขอราคารับซื้อคืน</button>
      </div>
    </aside>
  </div>
</main>
@endsection

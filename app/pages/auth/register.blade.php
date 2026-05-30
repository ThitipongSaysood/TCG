@extends('layouts.app')

@section('title', 'สมัครสมาชิก — CARD ZONE')

@section('content')
<main class="container" style="display:grid;place-items:center;min-height:calc(100vh - 64px);padding:32px 16px">
  <div class="glass" style="padding:32px 26px;width:100%;max-width:460px">
    <div style="text-align:center;margin-bottom:22px">
      <span class="eyebrow">Create account</span>
      <h1 style="font-size:26px;margin-top:6px">สมัครสมาชิก</h1>
      <p class="muted">เริ่มสะสม · ประมูล · เปิด Live การ์ดของคุณ</p>
    </div>

    @if ($errors->any())
      <div class="badge badge-danger" style="display:block;padding:10px;margin-bottom:14px">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="field">
        <label>ชื่อที่แสดง</label>
        <input class="input" type="text" name="display_name" value="{{ old('display_name') }}" placeholder="เช่น Panya" required autofocus>
      </div>
      <div class="field">
        <label>อีเมล</label>
        <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
      </div>
      <div class="field">
        <label>เบอร์โทร</label>
        <input class="input" type="tel" name="phone" value="{{ old('phone') }}" placeholder="0812345678">
      </div>
      <div class="field">
        <label>รหัสผ่าน</label>
        <input class="input" type="password" name="password" placeholder="อย่างน้อย 8 ตัวอักษร" required>
      </div>
      <div class="field">
        <label>ยืนยันรหัสผ่าน</label>
        <input class="input" type="password" name="password_confirmation" required>
      </div>
      <button class="btn btn-primary btn-block btn-lg mt-8" type="submit">สมัครสมาชิก</button>
    </form>

    <p class="muted" style="text-align:center;margin-top:18px;font-size:13px">
      มีบัญชีอยู่แล้ว? <a href="{{ route('login') }}" style="color:var(--primary-bright)">เข้าสู่ระบบ</a>
    </p>
  </div>
</main>
@endsection

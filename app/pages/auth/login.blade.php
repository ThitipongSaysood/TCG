@extends('layouts.app')

@section('title', 'เข้าสู่ระบบ — CARD ZONE')

@section('content')
<main class="container" style="display:grid;place-items:center;min-height:calc(100vh - 64px);padding:32px 16px">
  <div class="glass" style="padding:32px 26px;width:100%;max-width:420px">
    <div style="text-align:center;margin-bottom:22px">
      <span class="eyebrow">Welcome back</span>
      <h1 style="font-size:26px;margin-top:6px">เข้าสู่ระบบ</h1>
      <p class="muted">เข้าสู่โลกของนักสะสม TCG ระดับพรีเมียม</p>
    </div>

    {{-- Social login --}}
    <a class="btn btn-line btn-block" href="{{ route('login.social.redirect', 'line') }}">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C6.5 2 2 5.7 2 10.2c0 4 3.6 7.4 8.4 8 .3.1.8.2.9.5.1.3.1.7 0 1l-.1.9c-.1.3-.3 1 .9.6 1.2-.5 6.4-3.8 8.7-6.5C22.4 13 23 11.7 23 10.2 23 5.7 17.5 2 12 2z"/></svg>
      เข้าสู่ระบบด้วย LINE
    </a>
    <div style="height:10px"></div>
    <a class="btn btn-google btn-block" href="{{ route('login.social.redirect', 'google') }}">
      <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#fff" d="M21.35 11.1H12v3.2h5.35c-.5 2.4-2.6 4.1-5.35 4.1a5.9 5.9 0 110-11.8c1.5 0 2.9.6 4 1.6l2.4-2.3A9.3 9.3 0 0012 2.7a9.3 9.3 0 100 18.6c5.4 0 9-3.8 9-9.2 0-.6 0-1.1-.15-1.6z"/></svg>
      เข้าสู่ระบบด้วย Google
    </a>

    <div class="flex center" style="margin:18px 0">
      <div class="divider grow"></div><span class="muted" style="font-size:12px">หรือ</span><div class="divider grow"></div>
    </div>

    @if ($errors->any())
      <div class="badge badge-danger" style="display:block;padding:10px;margin-bottom:14px">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="field">
        <label>อีเมล</label>
        <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
      </div>
      <div class="field">
        <label>รหัสผ่าน</label>
        <input class="input" type="password" name="password" placeholder="••••••••" required>
      </div>
      <div class="between" style="margin-bottom:16px">
        <label class="checkbox"><input type="checkbox" name="remember">จำฉันไว้</label>
        <a href="#" style="font-size:13px;color:var(--primary-bright)">ลืมรหัสผ่าน?</a>
      </div>
      <button class="btn btn-primary btn-block btn-lg" type="submit">เข้าสู่ระบบ</button>
    </form>

    <p class="muted" style="text-align:center;margin-top:18px;font-size:13px">
      ยังไม่มีบัญชี? <a href="{{ route('register') }}" style="color:var(--primary-bright)">สมัครสมาชิก</a>
    </p>
  </div>
</main>
@endsection

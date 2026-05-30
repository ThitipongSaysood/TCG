<div class="drawer-backdrop" id="drawerBackdrop"></div>
<aside class="drawer" id="drawer">
  <div class="between">
    <span class="brand" style="font-size:16px"><span class="logo"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l5 5v13H6z" stroke="#fff" stroke-width="2"/></svg></span>CARD ZONE</span>
    <button class="icon-btn" data-drawer-close><svg viewBox="0 0 24 24" fill="none"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></button>
  </div>
  <a href="{{ route('home') }}">หน้าแรก</a>
  <a href="{{ route('products.index') }}">Booster Pack</a>
  <a href="{{ route('auctions.index') }}">ประมูลการ์ด</a>
  <a href="{{ route('live.index') }}">Live Opening</a>
  <a href="{{ route('collection.index') }}">Collection ของฉัน</a>
  <a href="{{ route('orders.index') }}">คำสั่งซื้อ</a>
  <a href="{{ route('psa.index') }}">ส่งเกรด PSA</a>
  @auth
    <a href="{{ route('profile.show') }}">โปรไฟล์</a>
    <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf
      <button type="submit" style="all:unset;cursor:pointer;display:block;padding:12px 14px;border-radius:var(--r-sm);color:var(--text-300);width:100%;text-align:left">ออกจากระบบ</button>
    </form>
  @else
    <a href="{{ route('login') }}">เข้าสู่ระบบ</a>
    <a href="{{ route('register') }}">สมัครสมาชิก</a>
  @endauth
</aside>

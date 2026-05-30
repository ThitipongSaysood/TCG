@php $active = $active ?? request()->route()?->getName(); @endphp
<header class="nav">
  <div class="container nav-inner">
    <a href="{{ route('home') }}" class="brand">
      <span class="logo"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l5 5v13H6z" stroke="#fff" stroke-width="2" stroke-linejoin="round"/><path d="M9.5 12.5l2 2 4-4.5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
      CARD ZONE
    </a>
    <nav class="nav-links">
      <a href="{{ route('home') }}" @class(['active' => $active === 'home'])>หน้าแรก</a>
      <a href="{{ route('products.index') }}" @class(['active' => str_starts_with($active ?? '', 'products')])>Booster Pack</a>
      <a href="{{ route('auctions.index') }}" @class(['active' => str_starts_with($active ?? '', 'auctions')])>ประมูล</a>
      <a href="{{ route('live.index') }}" @class(['active' => $active === 'live.index'])>Live</a>
      <a href="{{ route('collection.index') }}" @class(['active' => $active === 'collection.index'])>Collection</a>
    </nav>
    <div class="nav-search">
      <svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      <input type="text" placeholder="ค้นหาการ์ด, ร้านค้า, เซ็ต...">
    </div>
    <div class="nav-actions">
      <a href="{{ route('cart.index') }}" class="icon-btn hide-xs" aria-label="ตะกร้า"><svg viewBox="0 0 24 24" fill="none"><path d="M3 4h2l2.5 12h10L20 7H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="20" r="1.6" fill="currentColor"/><circle cx="17" cy="20" r="1.6" fill="currentColor"/></svg></a>
      @auth
        <a href="{{ route('profile.show') }}" class="avatar-chip hide-xs">
          <span class="av">{{ mb_strtoupper(mb_substr(auth()->user()->display_name ?? auth()->user()->name, 0, 1)) }}</span>
          <span><b style="color:var(--text-100);font-size:13px">{{ auth()->user()->display_name ?? auth()->user()->name }}</b><small>{{ ucfirst(auth()->user()->membership_tier ?? 'Bronze') }} Member</small></span>
        </a>
      @else
        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm hide-xs">เข้าสู่ระบบ</a>
      @endauth
      <button class="icon-btn nav-toggle" data-drawer-open aria-label="เมนู"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></button>
    </div>
  </div>
</header>

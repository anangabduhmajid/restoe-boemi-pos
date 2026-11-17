<div style="display:flex;align-items:center;gap:16px;">
    <img src="{{ asset('images/customer/logo-restoe.png') }}"
        alt="Logo Restoe Boemi"
        width="64"
        height="64"
        style="width:64px;height:64px;border:1px solid #E5D6C3;border-radius:50%;background:#F5EFE6;padding:4px;object-fit:contain;">
    <h1>RESTOE BOEMI</h1>
</div>
<h2>Customer Dashboard</h2>

<p>Selamat datang, {{ auth()->user()->name }}!</p>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
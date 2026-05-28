@extends('layouts.admin')
@section('title','Kelola User')
@section('breadcrumb','Manajemen akun kasir dan admin')
@section('content')
<div class="g2" style="align-items:start">
  <div class="card">
    <div class="card-h"><span class="card-t">Daftar User ({{ $users->count() }})</span></div>
    <div class="tw">
      <table>
        <thead><tr><th>Nama</th><th>Username</th><th>Role</th><th>Aksi</th></tr></thead>
        <tbody>
          @foreach($users as $u)
          <tr>
            <td style="font-weight:500">{{ $u->nama_lengkap }}</td>
            <td style="font-family:monospace;font-size:.8rem;color:var(--muted)">{{ $u->username }}</td>
            <td><span class="badge {{ $u->role=='admin' ? 'bw' : 'bi' }}">{{ $u->role=='admin' ? '👑 Admin' : '🖥️ Kasir' }}</span></td>
            <td>
              @if($u->id !== auth()->id())
              <form method="POST" action="{{ route('admin.users.destroy',$u) }}" onsubmit="return confirm('Hapus user ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-d btn-sm">Hapus</button></form>
              @else<span style="font-size:.75rem;color:var(--muted)">Akun aktif</span>@endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="card">
    <div class="card-h"><span class="card-t">➕ Tambah User Baru</span></div>
    <div class="card-b">
      <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="fg"><label class="fl">Nama Lengkap *</label><input type="text" name="nama_lengkap" class="fc" placeholder="cth: Siti Rahayu" required>@error('nama_lengkap')<div class="fe">{{ $message }}</div>@enderror</div>
        <div class="fg"><label class="fl">Username *</label><input type="text" name="username" class="fc" placeholder="cth: kasir2" required>@error('username')<div class="fe">{{ $message }}</div>@enderror</div>
        <div class="fg"><label class="fl">Password *</label><input type="password" name="password" class="fc" placeholder="Min. 6 karakter" required>@error('password')<div class="fe">{{ $message }}</div>@enderror</div>
        <div class="fg"><label class="fl">Role *</label>
          <select name="role" class="fc" required><option value="kasir">🖥️ Kasir</option><option value="admin">👑 Admin</option></select>
        </div>
        <button type="submit" class="btn btn-p">Simpan User</button>
      </form>
    </div>
  </div>
</div>
@endsection

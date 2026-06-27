@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0"><i class="fas fa-ban text-danger"></i> Blocked Accounts</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Blocked Accounts</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content"><div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    <div class="alert alert-warning" style="font-size:13px">
      <i class="fas fa-info-circle"></i>
      <strong>কেন block হয়?</strong> পরপর ২ বার ভুল password দিলে account automatically block হয়।
      Admin Unblock করলে আবার Login করতে পারবে।
    </div>

    <div class="card shadow-sm">
      <div class="card-header bg-danger text-white d-flex align-items-center">
        <h3 class="card-title mr-auto">
          <i class="fas fa-ban mr-2"></i>
          Blocked Accounts
          <span class="badge badge-light ml-2">{{ $blocked->count() }}</span>
        </h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead class="bg-light">
            <tr>
              <th>#</th>
              <th>নাম</th>
              <th>Account Type</th>
              <th>Block হওয়ার কারণ</th>
              <th>Block হয়েছে</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($blocked as $i => $user)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>
                <div style="font-weight:700">{{ $user->name }}</div>
                <div style="font-size:12px;color:#888">{{ $user->email }}</div>
                <div style="font-size:12px;color:#888">{{ $user->mobile }}</div>
              </td>
              <td>
                @php
                  $badge = ['seller'=>'primary','vendor'=>'success','dropshipper'=>'danger','customer'=>'info'][$user->usertype] ?? 'secondary';
                @endphp
                <span class="badge badge-{{ $badge }}">{{ ucfirst($user->usertype) }}</span>
              </td>
              <td style="font-size:13px;color:#e8001d">
                {{ $user->login_blocked_reason ?? 'ভুল password' }}
              </td>
              <td style="font-size:12px">
                {{ $user->login_blocked_at ? $user->login_blocked_at->diffForHumans() : '' }}
                <div style="color:#aaa">{{ $user->login_blocked_at?->format('d M Y, h:i A') }}</div>
              </td>
              <td>
                <form action="{{ route('sellers.unblock', $user->id) }}" method="POST"
                  onsubmit="return confirm('{{ $user->name }}-এর account unblock করবেন?')">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-unlock mr-1"></i> Unblock করুন
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">
                <i class="fas fa-check-circle fa-3x text-success mb-2"></i><br>
                কোনো blocked account নেই। সব clear ✅
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div></section>
</div>
@endsection

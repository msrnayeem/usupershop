@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h5 class="m-0"><i class="fas fa-wallet text-primary"></i> Withdrawal Payment Methods</h5></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Withdrawal Methods</li></ol></div>
      </div>
    </div>
  </div>
  <section class="content"><div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle"></i> {{ session('success') }}<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>
    @endif

    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white d-flex align-items-center">
        <h3 class="card-title mr-auto"><i class="fas fa-money-bill-wave mr-2"></i>Withdrawal Payment Methods</h3>
        <a href="{{ route('withdrawal.methods.create') }}" class="btn btn-light btn-sm">
          <i class="fas fa-plus"></i> নতুন Method যোগ করুন
        </a>
      </div>
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead class="bg-light">
            <tr><th>Method</th><th>Account Label</th><th>Placeholder</th><th>Instructions</th><th>Status</th><th>Order</th><th>Action</th></tr>
          </thead>
          <tbody>
            @forelse($methods as $m)
            <tr>
              <td>
                <span style="font-size:20px;margin-right:6px">{{ $m->logo_emoji }}</span>
                <strong style="color:{{ $m->logo_color }}">{{ $m->name }}</strong>
              </td>
              <td style="font-size:13px">{{ $m->account_label }}</td>
              <td style="font-size:12px;color:#888">{{ $m->account_placeholder }}</td>
              <td style="font-size:12px;color:#666;max-width:160px">{{ Str::limit($m->instructions, 50) }}</td>
              <td>
                <form action="{{ route('withdrawal.methods.toggle', $m->id) }}" method="POST" style="display:inline">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-xs {{ $m->is_active ? 'btn-success' : 'btn-secondary' }}">
                    {{ $m->is_active ? '✅ Active' : '❌ Inactive' }}
                  </button>
                </form>
              </td>
              <td><span class="badge badge-secondary">{{ $m->sort_order }}</span></td>
              <td>
                <a href="{{ route('withdrawal.methods.edit', $m->id) }}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> Edit</a>
                <form action="{{ route('withdrawal.methods.destroy', $m->id) }}" method="POST" style="display:inline" onsubmit="return confirm('{{ $m->name }} delete করবেন?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-4 text-muted">কোনো payment method নেই। <a href="{{ route('withdrawal.methods.create') }}">প্রথমটি যোগ করুন</a></td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="alert alert-info mt-3" style="font-size:13px">
      <i class="fas fa-info-circle"></i>
      <strong>কীভাবে কাজ করে:</strong> এখানে Active থাকা methods গুলো Seller/Vendor/Dropshipper-এর Wallet Withdrawal form-এ দেখাবে। Inactive করলে সেই method আর দেখাবে না।
    </div>

  </div></section>
</div>
@endsection

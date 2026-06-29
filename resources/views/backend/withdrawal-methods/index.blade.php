@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-wallet" style="color:#6366f1;margin-right:8px;"></i>
                    Withdrawal Payment Methods
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Withdrawal Methods
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('withdrawal.methods.create') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-plus"></i> Add New Method
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" style="border:none;border-radius:8px;background:#f0fdf4;color:#15803d;margin-bottom:20px;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-list-ul" style="color:#6366f1;margin-right:6px;"></i>
                            Payout Channels List
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="8%">Emoji</th>
                                        <th>Method Name</th>
                                        <th>Account Label</th>
                                        <th>Placeholder</th>
                                        <th>User Instructions</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" width="8%">Sort Order</th>
                                        <th class="text-center" width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($methods as $m)
                                        <tr>
                                            <td class="text-center" style="font-size:24px;">{{ $m->logo_emoji }}</td>
                                            <td>
                                                <strong style="color:{{ $m->logo_color ?: '#475569' }};font-size:15px;">{{ $m->name }}</strong>
                                            </td>
                                            <td style="font-size:13px;font-weight:600;color:#334155;">{{ $m->account_label }}</td>
                                            <td style="font-size:12px;color:#64748b;font-family:monospace;">{{ $m->account_placeholder }}</td>
                                            <td style="font-size:12px;color:#475569;max-width:180px;white-space:normal;line-height:1.5;">{{ Str::limit($m->instructions, 55) }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('withdrawal.methods.toggle', $m->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-xs {{ $m->is_active ? 'btn-success' : 'btn-secondary' }}" style="padding:4px 8px;border-radius:6px;font-weight:600;">
                                                        {{ $m->is_active ? 'Active' : 'Inactive' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-light" style="font-size:12px;font-weight:700;background:#f1f5f9;color:#475569;border:1px solid #cbd5e1;padding:3px 8px;border-radius:4px;">{{ $m->sort_order }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div style="display:flex;gap:6px;justify-content:center;">
                                                    <a href="{{ route('withdrawal.methods.edit', $m->id) }}" class="btn btn-xs btn-info" style="border-radius:6px;padding:4px 8px;font-weight:600;">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('withdrawal.methods.destroy', $m->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete payout method: {{ $m->name }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-xs btn-danger" style="border-radius:6px;padding:4px 8px;">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5 text-muted">
                                                <i class="fas fa-money-bill-wave fa-3x mb-2" style="opacity:0.8;"></i>
                                                <p style="font-weight:600;margin-bottom:0;color:#1e293b;">No Withdrawal Methods Configured</p>
                                                <p style="font-size:12px;margin:0;"><a href="{{ route('withdrawal.methods.create') }}" style="color:#6366f1;font-weight:600;">Add payout channel</a> to allow seller balance cashouts.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info border-0 mt-3" style="font-size:13px;background:#f0f9ff;color:#0369a1;border-radius:8px;padding:15px;line-height:1.6;">
                    <i class="fas fa-info-circle mr-1"></i>
                    <strong>Payout Mechanism:</strong> Active payout methods configured here are shown dynamically in the wallet cashout page of sellers, vendors, and dropshippers. Deactivating a method preserves historical data but hides the channel from active request options.
                </div>
            </div>
        </section>
    </div>
@endsection

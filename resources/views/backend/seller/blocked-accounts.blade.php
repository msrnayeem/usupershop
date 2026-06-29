@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-ban text-danger" style="margin-right:8px;"></i>
                    Blocked Accounts
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Blocked Accounts
                </p>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" style="border:none;border-radius:8px;background:#f0fdf4;color:#15803d;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <div class="alert alert-warning border-0" style="font-size:13px;background:#fffbeb;color:#b45309;border-radius:8px;margin-bottom:20px;">
                    <i class="fas fa-info-circle"></i>
                    <strong>Block Behavior:</strong> Accounts are automatically blocked after 2 consecutive incorrect password attempts for security. Unblocking them will restore login access.
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-user-shield" style="color:#ef4444;margin-right:6px;"></i>
                            Blocked Accounts List
                            <span class="badge badge-danger ml-2" style="border-radius:6px;background:#fee2e2;color:#ef4444;">{{ $blocked->count() }}</span>
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">#</th>
                                    <th>User Details</th>
                                    <th class="text-center">Account Type</th>
                                    <th>Reason</th>
                                    <th class="text-center">Blocked On</th>
                                    <th class="text-center" width="12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blocked as $i => $user)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>
                                            <div style="font-weight:700;color:#0f172a;">{{ $user->name }}</div>
                                            <div style="font-size:12px;color:#64748b;"><i class="fas fa-envelope mr-1"></i> {{ $user->email }}</div>
                                            <div style="font-size:12px;color:#64748b;"><i class="fas fa-phone mr-1"></i> {{ $user->mobile }}</div>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $badge = ['seller'=>'primary','vendor'=>'success','dropshipper'=>'danger','customer'=>'info'][$user->usertype] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-{{ $badge }}" style="padding:5px 10px;border-radius:6px;">{{ ucfirst($user->usertype) }}</span>
                                        </td>
                                        <td style="font-size:13px;color:#ef4444;font-weight:600;">
                                            {{ $user->login_blocked_reason ?? 'Incorrect password attempts limit reached' }}
                                        </td>
                                        <td class="text-center" style="font-size:12px;color:#475569;">
                                            <div>{{ $user->login_blocked_at ? $user->login_blocked_at->diffForHumans() : '' }}</div>
                                            <div style="color:#94a3b8;margin-top:2px;">{{ $user->login_blocked_at?->format('d M Y, h:i A') }}</div>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('sellers.unblock', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unblock {{ $user->name }}?')" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm" style="border-radius:6px;font-weight:600;padding:5px 12px;">
                                                    <i class="fas fa-unlock mr-1"></i> Unblock
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-check-circle fa-3x text-success mb-2" style="opacity:0.8;"></i>
                                            <p style="font-weight:600;margin-bottom:0;color:#1e293b;">No Blocked Accounts</p>
                                            <p style="font-size:12px;margin:0;">All user accounts are currently active and in good standing.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

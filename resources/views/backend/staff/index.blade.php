@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-users-cog" style="color:#6366f1;margin-right:8px;"></i>
                    Staff Management
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Staff
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('staff.create') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-plus"></i> Add New Staff
            </a>
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

                {{-- Stats Row --}}
                <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="card shadow-sm border-0" style="border-radius:12px;background:#fff;border:1px solid #e2e8f0 !important;">
                            <div class="card-body d-flex align-items-center" style="padding:18px;">
                                <div style="background:#f1f5f9;color:#6366f1;width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-right:14px;"><i class="fas fa-users"></i></div>
                                <div>
                                    <div style="font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Total Staff</div>
                                    <div style="font-size:20px;font-weight:800;color:#0f172a;margin-top:2px;">{{ $staffList->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="card shadow-sm border-0" style="border-radius:12px;background:#fff;border:1px solid #e2e8f0 !important;">
                            <div class="card-body d-flex align-items-center" style="padding:18px;">
                                <div style="background:#fffbeb;color:#d97706;width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-right:14px;"><i class="fas fa-user-tie"></i></div>
                                <div>
                                    <div style="font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Managers</div>
                                    <div style="font-size:20px;font-weight:800;color:#0f172a;margin-top:2px;">{{ $staffList->where('role','manager')->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="card shadow-sm border-0" style="border-radius:12px;background:#fff;border:1px solid #e2e8f0 !important;">
                            <div class="card-body d-flex align-items-center" style="padding:18px;">
                                <div style="background:#f0f9ff;color:#0284c7;width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-right:14px;"><i class="fas fa-user"></i></div>
                                <div>
                                    <div style="font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Employees</div>
                                    <div style="font-size:20px;font-weight:800;color:#0f172a;margin-top:2px;">{{ $staffList->where('role','employee')->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="card shadow-sm border-0" style="border-radius:12px;background:#fff;border:1px solid #e2e8f0 !important;">
                            <div class="card-body d-flex align-items-center" style="padding:18px;">
                                <div style="background:#f0fdf4;color:#16a34a;width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-right:14px;"><i class="fas fa-user-check"></i></div>
                                <div>
                                    <div style="font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Active Status</div>
                                    <div style="font-size:20px;font-weight:800;color:#0f172a;margin-top:2px;">{{ $staffList->where('is_active',1)->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                            Staff List
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">#</th>
                                    <th>Staff Details</th>
                                    <th class="text-center">Role</th>
                                    <th>Modules Permissions</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Joined Date</th>
                                    <th class="text-center" width="12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($staffList as $i => $s)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>
                                            <div style="font-weight:700;color:#0f172a;">{{ $s->user->name ?? 'N/A' }}</div>
                                            <div style="font-size:12px;color:#64748b;"><i class="fas fa-envelope mr-1"></i> {{ $s->user->email ?? '' }}</div>
                                            <div style="font-size:12px;color:#64748b;"><i class="fas fa-phone mr-1"></i> {{ $s->user->mobile ?? '' }}</div>
                                        </td>
                                        <td class="text-center">
                                            @if($s->role === 'manager')
                                                <span class="badge badge-warning" style="padding:5px 10px;border-radius:6px;"><i class="fas fa-user-tie mr-1"></i> Manager</span>
                                            @else
                                                <span class="badge badge-info" style="padding:5px 10px;border-radius:6px;"><i class="fas fa-user mr-1"></i> Employee</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                                @foreach($s->permissions ?? [] as $perm)
                                                    @if(isset(\App\Models\Staff::MODULES[$perm]))
                                                        <span class="badge badge-light" style="font-size:11px;font-weight:600;background:#f1f5f9;color:#475569;border:1px solid #cbd5e1;padding:3px 8px;border-radius:4px;">
                                                            {{ \App\Models\Staff::MODULES[$perm]['label'] }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('staff.toggle', $s->id) }}" method="POST" style="display:inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-xs {{ $s->is_active ? 'btn-success' : 'btn-secondary' }}" style="padding:4px 8px;border-radius:6px;font-weight:600;">
                                                    {{ $s->is_active ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center" style="font-size:13px;color:#475569;">
                                            {{ $s->created_at ? $s->created_at->format('d M Y') : '' }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('staff.edit', $s->id) }}" class="btn btn-xs btn-info" style="border-radius:6px;padding:4px 8px;font-weight:600;">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('staff.destroy', $s->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete {{ $s->user->name ?? \'\' }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger" style="border-radius:6px;padding:4px 8px;">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fas fa-users fa-3x mb-2" style="opacity:0.8;"></i>
                                            <p style="font-weight:600;margin-bottom:0;color:#1e293b;">No Staff Registered</p>
                                            <p style="font-size:12px;margin:0;"><a href="{{ route('staff.create') }}" style="color:#6366f1;font-weight:600;">Add your first staff member</a> to start delegating.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Permission Info Card --}}
                <div class="card">
                    <div class="card-header" style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                        <span class="card-title" style="font-size:14px;font-weight:700;"><i class="fas fa-shield-alt mr-1" style="color:#6366f1;"></i> Permission System Guidelines</span>
                    </div>
                    <div class="card-body" style="font-size:13px;color:#475569;">
                        <div class="row">
                            <div class="col-md-6">
                                <ul style="padding-left:18px;line-height:2.2;margin-bottom:0;">
                                    <li>🔑 <strong>Main Admin</strong> — Complete system access and management</li>
                                    <li>👔 <strong>Manager</strong> — Full access to explicitly assigned modules</li>
                                    <li>👤 <strong>Employee</strong> — Read/write access to assigned modules</li>
                                    <li>⛔ Main Admin accounts cannot be edited or updated by other staff members</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul style="padding-left:18px;line-height:2.2;margin-bottom:0;">
                                    <li>🚫 Managers cannot view or edit details of other Managers/Employees</li>
                                    <li>🚫 Staff members cannot update their own permissions</li>
                                    <li>✅ Only the Main Administrator has full control over all accounts</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

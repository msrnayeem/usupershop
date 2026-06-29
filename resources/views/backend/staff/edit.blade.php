@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-edit" style="color:#6366f1;margin-right:8px;"></i>
                    Edit Staff Profile
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('staff.index') }}" style="color:#6366f1;text-decoration:none;">Staff</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Edit
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('staff.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-arrow-left"></i> Back to Staff List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" style="border:none;border-radius:8px;background:#fef2f2;color:#b91c1c;">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        @foreach($errors->all() as $err)
                            <div><i class="fas fa-exclamation-circle mr-1"></i> {{ $err }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('staff.update', $staff->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            {{-- Basic Info --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <span class="card-title">
                                        <i class="fas fa-user" style="color:#6366f1;margin-right:6px;"></i>
                                        Basic Information
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Staff Full Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ old('name', $staff->user->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" required>
                                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Role <span class="text-danger">*</span></label>
                                                <select name="role" class="form-control select2 @error('role') is-invalid @enderror" onchange="updateRoleInfo(this.value)" required>
                                                    <option value="">-- Select Role --</option>
                                                    <option value="manager" {{ old('role', $staff->role)=='manager' ? 'selected' : '' }}>Manager</option>
                                                    <option value="employee" {{ old('role', $staff->role)=='employee' ? 'selected' : '' }}>Employee</option>
                                                </select>
                                                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                <div id="roleInfo" style="font-size:13px;color:#64748b;margin-top:6px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
                                                <input type="email" name="email" value="{{ old('email', $staff->user->email ?? '') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com" required>
                                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Phone Number <span class="text-danger">*</span></label>
                                                <input type="text" name="mobile" value="{{ old('mobile', $staff->user->mobile ?? '') }}" class="form-control @error('mobile') is-invalid @enderror" placeholder="01XXXXXXXXX" maxlength="11" required>
                                                @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">New Password <span class="badge badge-light ml-1" style="font-size:11px;border:1px solid #cbd5e1;color:#475569;">Optional</span></label>
                                                <div class="input-group">
                                                    <input type="password" name="new_password" id="pw" class="form-control @error('password') is-invalid @enderror" placeholder="At least 6 characters">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePw('pw')"><i class="fas fa-eye"></i></button>
                                                    </div>
                                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Confirm New Password <span class="badge badge-light ml-1" style="font-size:11px;border:1px solid #cbd5e1;color:#475569;">Optional</span></label>
                                                <div class="input-group">
                                                    <input type="password" name="new_password_confirmation" id="pw2" class="form-control" placeholder="Retype password">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePw('pw2')"><i class="fas fa-eye"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Permissions --}}
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex align-items-center justify-content-between">
                                    <span class="card-title font-weight-bold text-dark">
                                        <i class="fas fa-key" style="color:#d97706;margin-right:6px;"></i>
                                        Module Access Permissions
                                    </span>
                                    <div style="display:flex;gap:8px;">
                                        <button type="button" class="btn btn-xs btn-outline-primary" onclick="selectAll(true)" style="font-weight:600;padding:4px 10px;border-radius:6px;">Select All</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="selectAll(false)" style="font-weight:600;padding:4px 10px;border-radius:6px;">Deselect All</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($errors->has('permissions'))
                                        <div class="alert alert-danger mb-3" style="font-size:13px;border:none;border-radius:8px;background:#fef2f2;color:#b91c1c;">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> {{ $errors->first('permissions') }}
                                        </div>
                                    @endif

                                    <div class="row">
                                        @foreach($modules as $key => $module)
                                            <div class="col-md-6 mb-3">
                                                <div class="permission-card {{ in_array($key, old('permissions', $staff->permissions ?? [])) ? 'selected' : '' }}"
                                                     style="border:1px solid #e2e8f0;border-radius:10px;padding:14px;cursor:pointer;transition:all 0.2s;background:#fff;"
                                                     onclick="togglePerm(this, '{{ $key }}')">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center" style="gap:12px;">
                                                            <div style="font-size:22px;">{{ explode(' ', $module['label'])[0] }}</div>
                                                            <div>
                                                                <div style="font-weight:700;font-size:13px;color:#0f172a;">{{ implode(' ', array_slice(explode(' ', $module['label']), 1)) }}</div>
                                                                <div style="font-size:11px;color:#64748b;font-family:monospace;margin-top:2px;">{{ implode(', ', $module['routes']) }}</div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <input type="checkbox" name="permissions[]" value="{{ $key }}" id="perm_{{ $key }}" {{ in_array($key, old('permissions', $staff->permissions ?? [])) ? 'checked' : '' }} style="transform:scale(1.2);pointer-events:none;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="isActive" name="is_active" value="1" {{ ($staff->is_active ?? 1) ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-bold text-dark" for="isActive" style="cursor:pointer;">Account Active Status</label>
                                </div>
                            </div>

                            <div class="d-flex mb-5" style="gap:12px">
                                <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:12px 30px;border-radius:8px;font-weight:600;">
                                    <i class="fas fa-save mr-2"></i> Save Changes
                                </button>
                                <a href="{{ route('staff.index') }}" class="btn btn-secondary" style="background:#f1f5f9;border:1px solid #cbd5e1;color:#475569;padding:12px 24px;border-radius:8px;font-weight:600;">
                                    <i class="fas fa-arrow-left mr-2"></i> Cancel
                                </a>
                            </div>
                        </div>

                        {{-- Info Panel --}}
                        <div class="col-md-4">
                            <div class="card" style="position:sticky;top:20px;">
                                <div class="card-header" style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                                    <span class="card-title font-weight-bold text-dark"><i class="fas fa-info-circle mr-1" style="color:#6366f1;"></i> Role System Overview</span>
                                </div>
                                <div class="card-body" style="font-size:13px;color:#475569;line-height:1.7;">
                                    <div class="mb-3" style="background:#fffbeb;border-radius:8px;padding:12px;border:1px solid #fef3c7;">
                                        <strong>👔 Manager:</strong>
                                        <ul style="padding-left:16px;margin:5px 0 0;font-size:12px;">
                                            <li>Has full access to assigned backend modules</li>
                                            <li>Cannot modify other Managers or Employees</li>
                                        </ul>
                                    </div>
                                    <div class="mb-3" style="background:#f0f9ff;border-radius:8px;padding:12px;border:1px solid #e0f2fe;">
                                        <strong>👤 Employee:</strong>
                                        <ul style="padding-left:16px;margin:5px 0 0;font-size:12px;">
                                            <li>Limited access to assigned tasks</li>
                                            <li>Cannot perform high-level configuration</li>
                                        </ul>
                                    </div>
                                    <div style="background:#fef2f2;border-radius:8px;padding:12px;border:1px solid #fee2e2;">
                                        <strong>⛔ Security Constraints:</strong>
                                        <ul style="padding-left:16px;margin:5px 0 0;font-size:12px;">
                                            <li>Main Admin is completely isolated</li>
                                            <li>Users cannot self-escalate permissions</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    theme: 'bootstrap4'
                });

                // Style initially selected ones
                $('.permission-card').each(function() {
                    var cb = $(this).find('input[type=checkbox]');
                    if (cb.is(':checked')) {
                        $(this).css({
                            'border-color': '#6366f1',
                            'background-color': '#f8fafc',
                            'box-shadow': '0 0 0 1px #6366f1'
                        });
                    }
                });
            });

            function togglePw(id) {
                var i = document.getElementById(id);
                i.type = i.type === 'password' ? 'text' : 'password';
            }

            function togglePerm(card, key) {
                var cb = document.getElementById('perm_' + key);
                cb.checked = !cb.checked;
                if (cb.checked) {
                    $(card).css({
                        'border-color': '#6366f1',
                        'background-color': '#f8fafc',
                        'box-shadow': '0 0 0 1px #6366f1'
                    });
                } else {
                    $(card).css({
                        'border-color': '#e2e8f0',
                        'background-color': '#fff',
                        'box-shadow': 'none'
                    });
                }
            }

            function selectAll(val) {
                $('.permission-card').each(function() {
                    var cb = $(this).find('input[type=checkbox]')[0];
                    if (cb) {
                        cb.checked = val;
                        if (val) {
                            $(this).css({
                                'border-color': '#6366f1',
                                'background-color': '#f8fafc',
                                'box-shadow': '0 0 0 1px #6366f1'
                            });
                        } else {
                            $(this).css({
                                'border-color': '#e2e8f0',
                                'background-color': '#fff',
                                'box-shadow': 'none'
                            });
                        }
                    }
                });
            }

            function updateRoleInfo(role) {
                var info = document.getElementById('roleInfo');
                if(role === 'manager') info.innerHTML = '<span class="badge badge-warning" style="padding:4px 8px;border-radius:4px;"><i class="fas fa-info-circle mr-1"></i> Manager receives high-level access to chosen modules.</span>';
                else if(role === 'employee') info.innerHTML = '<span class="badge badge-info" style="padding:4px 8px;border-radius:4px;"><i class="fas fa-info-circle mr-1"></i> Employee receives operational access to chosen modules.</span>';
                else info.textContent = '';
            }
        </script>
    @endpush
@endsection

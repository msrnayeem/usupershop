@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0"><i class="fas fa-users-cog text-primary"></i> Staff Management</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Staff</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
      @endif

      {{-- Stats Row --}}
      <div class="row mb-3">
        <div class="col-md-3">
          <div class="info-box shadow-sm">
            <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">মোট Staff</span>
              <span class="info-box-number">{{ $staffList->count() }}</span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info-box shadow-sm">
            <span class="info-box-icon bg-warning"><i class="fas fa-user-tie"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Manager</span>
              <span class="info-box-number">{{ $staffList->where('role','manager')->count() }}</span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info-box shadow-sm">
            <span class="info-box-icon bg-info"><i class="fas fa-user"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Employee</span>
              <span class="info-box-number">{{ $staffList->where('role','employee')->count() }}</span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info-box shadow-sm">
            <span class="info-box-icon bg-success"><i class="fas fa-user-check"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Active</span>
              <span class="info-box-number">{{ $staffList->where('is_active',1)->count() }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
          <h3 class="card-title mr-auto"><i class="fas fa-users-cog mr-2"></i>Staff List</h3>
          <a href="{{ route('staff.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> নতুন Staff যোগ করুন
          </a>
        </div>
        <div class="card-body p-0">
          <table class="table table-hover mb-0">
            <thead class="bg-light">
              <tr>
                <th>#</th>
                <th>নাম</th>
                <th>Role</th>
                <th>Permissions</th>
                <th>Status</th>
                <th>যোগ দিয়েছে</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($staffList as $i => $s)
              <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                  <div style="font-weight:700">{{ $s->user->name ?? 'N/A' }}</div>
                  <div style="font-size:13px;color:#888">{{ $s->user->email ?? '' }}</div>
                  <div style="font-size:13px;color:#888">{{ $s->user->mobile ?? '' }}</div>
                </td>
                <td>
                  @if($s->role === 'manager')
                  <span class="badge badge-warning"><i class="fas fa-user-tie"></i> Manager</span>
                  @else
                  <span class="badge badge-info"><i class="fas fa-user"></i> Employee</span>
                  @endif
                </td>
                <td>
                  @foreach($s->permissions ?? [] as $perm)
                  @if(isset(\App\Models\Staff::MODULES[$perm]))
                  <span class="badge badge-secondary mb-1" style="font-size:13px">
                    {{ \App\Models\Staff::MODULES[$perm]['label'] }}
                  </span>
                  @endif
                  @endforeach
                </td>
                <td>
                  <form action="{{ route('staff.toggle', $s->id) }}" method="POST" style="display:inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-xs {{ $s->is_active ? 'btn-success' : 'btn-secondary' }}">
                      {{ $s->is_active ? '✅ Active' : '❌ Inactive' }}
                    </button>
                  </form>
                </td>
                <td style="font-size:14px">
                  {{ $s->created_at ? $s->created_at->format('d M Y') : '' }}
                </td>
                <td>
                  <a href="{{ route('staff.edit', $s->id) }}" class="btn btn-xs btn-info">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <form action="{{ route('staff.destroy', $s->id) }}" method="POST" style="display:inline"
                    onsubmit="return confirm('{{ $s->user->name ?? '' }}-কে delete করবেন?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-danger">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr><td colspan="7" class="text-center py-4 text-muted">
                <i class="fas fa-users fa-2x mb-2"></i><br>
                কোনো Staff নেই। <a href="{{ route('staff.create') }}">প্রথম Staff যোগ করুন</a>
              </td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{-- Permission Info Card --}}
      <div class="card shadow-sm mt-3">
        <div class="card-header bg-dark text-white">
          <h3 class="card-title"><i class="fas fa-shield-alt mr-2"></i>Permission System — নিয়মাবলী</h3>
        </div>
        <div class="card-body" style="font-size:13px">
          <div class="row">
            <div class="col-md-6">
              <ul style="padding-left:18px;line-height:2.2">
                <li>🔑 <strong>Main Admin</strong> — সব কিছুর full access</li>
                <li>👔 <strong>Manager</strong> — নির্দিষ্ট modules-এর full access</li>
                <li>👤 <strong>Employee</strong> — নির্দিষ্ট modules-এর access</li>
                <li>⛔ Main Admin-এর account কেউ edit করতে পারবে না</li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul style="padding-left:18px;line-height:2.2">
                <li>🚫 একজন Manager আরেকজন Manager বা Employee-র account edit করতে পারবে না</li>
                <li>🚫 Staff নিজের permission নিজে change করতে পারবে না</li>
                <li>✅ শুধু Main Admin সব Staff-এর তথ্য পরিবর্তন করতে পারবে</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection

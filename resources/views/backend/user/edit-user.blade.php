@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0"><i class="fas fa-user-edit text-primary"></i> User Edit</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.view') }}">Users</a></li>
            <li class="breadcrumb-item active">Edit</li>
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

      @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        @foreach($errors->all() as $err)
        <div><i class="fas fa-exclamation-circle"></i> {{ $err }}</div>
        @endforeach
      </div>
      @endif

      <div class="row">
        <div class="col-md-8">
          <form method="POST" action="{{ route('users.update', $editData->id) }}">
            @csrf

            {{-- ── User Info Card ────────────────────────────────────── --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header bg-primary text-white">
                <h3 class="card-title">
                  <i class="fas fa-user mr-2"></i>User Information
                  <span class="badge badge-light ml-2" style="font-size:13px">ID: #{{ $editData->id }}</span>
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  {{-- Name --}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">👤 পূর্ণ নাম <span class="text-danger">*</span></label>
                      <input type="text" name="name"
                        value="{{ old('name', $editData->name) }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="User-এর নাম">
                      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                  </div>

                  {{-- Role --}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">🎭 Role</label>
                      <select name="role" class="form-control">
                        <option value="user"    {{ ($editData->role ?? 'user') == 'user'    ? 'selected' : '' }}>User (Customer)</option>
                        <option value="admin"   {{ ($editData->role ?? '') == 'admin'   ? 'selected' : '' }}>Admin</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- ── Contact Info Card (Email + Mobile) ──────────────── --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header" style="background:#1e25fa;color:#fff">
                <h3 class="card-title">
                  <i class="fas fa-phone-alt mr-2"></i>Contact Information
                </h3>
              </div>
              <div class="card-body">

                <div class="alert alert-warning" style="font-size:13px">
                  <i class="fas fa-shield-alt"></i>
                  <strong>Admin Permission:</strong> আপনি Admin হিসেবে Email ও Phone পরিবর্তন করতে পারবেন। User নিজে এগুলো পরিবর্তন করতে পারে না।
                </div>

                <div class="row">
                  {{-- Email --}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">📧 Email Address</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" name="email"
                          value="{{ old('email', $editData->email) }}"
                          class="form-control @error('email') is-invalid @enderror"
                          placeholder="user@example.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      </div>
                      <small class="text-muted">Login Email — পরিবর্তন করলে user নতুন email দিয়ে login করবে</small>
                    </div>
                  </div>

                  {{-- Mobile --}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">📱 Phone Number</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" name="mobile"
                          value="{{ old('mobile', $editData->mobile) }}"
                          class="form-control @error('mobile') is-invalid @enderror"
                          placeholder="01XXXXXXXXX" maxlength="11">
                        @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      </div>
                      <small class="text-muted">১১ সংখ্যার বাংলাদেশি নম্বর</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- ── Password Card ────────────────────────────────────── --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header bg-danger text-white">
                <h3 class="card-title">
                  <i class="fas fa-lock mr-2"></i>Password পরিবর্তন
                  <span class="badge badge-light ml-2" style="font-size:12px">অপশনাল</span>
                </h3>
              </div>
              <div class="card-body">
                <div class="alert alert-info" style="font-size:13px">
                  <i class="fas fa-info-circle"></i>
                  Password পরিবর্তন না করতে চাইলে <strong>খালি রাখুন</strong>। নতুন password দিলে আগেরটা বাতিল হয়ে যাবে।
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">নতুন Password</label>
                      <div class="input-group">
                        <input type="password" name="new_password" id="newPass"
                          class="form-control @error('new_password') is-invalid @enderror"
                          placeholder="কমপক্ষে ৬ অক্ষর" autocomplete="new-password">
                        <div class="input-group-append">
                          <button type="button" class="btn btn-outline-secondary" onclick="togglePass('newPass')">
                            <i class="fas fa-eye" id="eye1"></i>
                          </button>
                        </div>
                        @error('new_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">Confirm Password</label>
                      <div class="input-group">
                        <input type="password" name="new_password_confirmation" id="confPass"
                          class="form-control"
                          placeholder="আবার টাইপ করুন" autocomplete="new-password">
                        <div class="input-group-append">
                          <button type="button" class="btn btn-outline-secondary" onclick="togglePass('confPass')">
                            <i class="fas fa-eye" id="eye2"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="d-flex" style="gap:10px">
              <button type="submit" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-save mr-2"></i>Save করুন
              </button>
              <a href="{{ route('users.view') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back
              </a>
            </div>
          </form>
        </div>

        {{-- User Info Panel --}}
        <div class="col-md-4">
          <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
              <h3 class="card-title"><i class="fas fa-id-card mr-2"></i>User Details</h3>
            </div>
            <div class="card-body" style="font-size:13px">

              {{-- Avatar --}}
              <div style="text-align:center;margin-bottom:16px">
                @if($editData->image)
                <img src="{{ asset('upload/user_images/' . $editData->image) }}"
                  style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #eee">
                @else
                <div style="width:80px;height:80px;border-radius:50%;background:#1e25fa;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:#fff;margin:0 auto">
                  {{ strtoupper(substr($editData->name ?? 'U', 0, 1)) }}
                </div>
                @endif
                <div style="margin-top:8px;font-weight:800;font-size:15px">{{ $editData->name }}</div>
                <div style="color:#888;font-size:13px">ID: #{{ $editData->id }}</div>
              </div>

              <table class="table table-sm table-bordered" style="font-size:13px">
                <tr><td class="font-weight-bold" width="40%">Account Type</td><td>
                  @php
                    $typeMap = ['user'=>'Customer','vendor'=>'Vendor','dropshipper'=>'Dropshipper','admin'=>'Admin'];
                    $typeColor = ['user'=>'info','vendor'=>'success','dropshipper'=>'danger','admin'=>'warning'];
                    $ut = $editData->usertype ?? 'user';
                  @endphp
                  <span class="badge badge-{{ $typeColor[$ut] ?? 'secondary' }}">{{ $typeMap[$ut] ?? ucfirst($ut) }}</span>
                </td></tr>
                <tr><td class="font-weight-bold">Status</td><td>
                  <span class="badge badge-{{ $editData->status ? 'success' : 'danger' }}">
                    {{ $editData->status ? 'Active ✅' : 'Inactive ❌' }}
                  </span>
                </td></tr>
                <tr><td class="font-weight-bold">Registered</td><td>
                  {{ $editData->created_at ? \Carbon\Carbon::parse($editData->created_at)->format('d M Y') : 'N/A' }}
                </td></tr>
                @if($editData->subscription_plan)
                <tr><td class="font-weight-bold">Subscription</td><td>
                  {{ \Carbon\Carbon::createFromTimestamp($editData->subscription_plan)->format('d M Y') }}
                </td></tr>
                @endif
                @if($editData->balance)
                <tr><td class="font-weight-bold">Balance</td><td>
                  <strong style="color:#00a855">৳{{ number_format($editData->balance, 0) }}</strong>
                </td></tr>
                @endif
              </table>

              <div class="alert alert-danger" style="font-size:13px;margin-bottom:0">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>সতর্কতা:</strong> Email বা Phone পরিবর্তন করলে user-এর login পরিবর্তন হবে। User-কে জানিয়ে দিন।
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

@push('scripts')
<script>
function togglePass(id) {
  var input = document.getElementById(id);
  input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endpush
@endsection

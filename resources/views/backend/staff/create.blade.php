@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h5 class="m-0"><i class="fas fa-user-plus text-primary"></i> নতুন Staff যোগ করুন</h5></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">Staff</a></li>
            <li class="breadcrumb-item active">Create</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        @foreach($errors->all() as $err)<div><i class="fas fa-exclamation-circle"></i> {{ $err }}</div>@endforeach
      </div>
      @endif

      <form action="{{ route('staff.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-7">

            {{-- Basic Info --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-user mr-2"></i>Basic Information</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">👤 পূর্ণ নাম <span class="text-danger">*</span></label>
                      <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Staff-এর নাম">
                      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">🎭 Role <span class="text-danger">*</span></label>
                      <select name="role" class="form-control @error('role') is-invalid @enderror" onchange="updateRoleInfo(this.value)">
                        <option value="">-- Select Role --</option>
                        <option value="manager" {{ old('role')=='manager' ? 'selected' : '' }}>👔 Manager</option>
                        <option value="employee" {{ old('role')=='employee' ? 'selected' : '' }}>👤 Employee</option>
                      </select>
                      @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      <div id="roleInfo" style="font-size:14px;color:#888;margin-top:4px"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">📧 Email <span class="text-danger">*</span></label>
                      <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com">
                      @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">📱 Phone <span class="text-danger">*</span></label>
                      <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control @error('mobile') is-invalid @enderror" placeholder="01XXXXXXXXX" maxlength="11">
                      @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">🔒 Password <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input type="password" name="password" id="pw" class="form-control @error('password') is-invalid @enderror" placeholder="কমপক্ষে ৬ অক্ষর">
                        <div class="input-group-append">
                          <button type="button" class="btn btn-outline-secondary" onclick="togglePw('pw')"><i class="fas fa-eye"></i></button>
                        </div>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">🔒 Confirm Password <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input type="password" name="password_confirmation" id="pw2" class="form-control" placeholder="আবার টাইপ করুন">
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
            <div class="card shadow-sm mb-3">
              <div class="card-header bg-warning">
                <h3 class="card-title"><i class="fas fa-key mr-2"></i>Permissions — কোন কোন Module-এ Access দেবেন?</h3>
              </div>
              <div class="card-body">
                @if($errors->has('permissions'))
                <div class="alert alert-danger" style="font-size:13px">
                  <i class="fas fa-exclamation-triangle"></i> {{ $errors->first('permissions') }}
                </div>
                @endif

                <div class="row">
                  @foreach($modules as $key => $module)
                  <div class="col-md-6 mb-2">
                    <div class="permission-card {{ in_array($key, old('permissions', [])) ? 'selected' : '' }}"
                      style="border:2px solid #eee;border-radius:10px;padding:12px 14px;cursor:pointer;transition:all .15s"
                      onclick="togglePerm(this, '{{ $key }}')">
                      <div class="d-flex align-items-center">
                        <div style="font-size:20px;margin-right:10px">{{ explode(' ', $module['label'])[0] }}</div>
                        <div>
                          <div style="font-weight:700;font-size:13px">{{ implode(' ', array_slice(explode(' ', $module['label']), 1)) }}</div>
                          <div style="font-size:13px;color:#888;font-family:monospace">{{ implode(', ', $module['routes']) }}</div>
                        </div>
                        <div class="ml-auto">
                          <input type="checkbox" name="permissions[]" value="{{ $key }}"
                            id="perm_{{ $key }}" {{ in_array($key, old('permissions', [])) ? 'checked' : '' }}
                            style="transform:scale(1.4)">
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>

                <div class="mt-2">
                  <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll(true)">✅ সব Select করুন</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary" onclick="selectAll(false)">❌ সব Deselect করুন</button>
                </div>
              </div>
            </div>

            <div class="d-flex" style="gap:10px">
              <button type="submit" class="btn btn-primary btn-lg px-5"><i class="fas fa-save mr-2"></i>Staff যোগ করুন</button>
              <a href="{{ route('staff.index') }}" class="btn btn-secondary btn-lg"><i class="fas fa-arrow-left mr-2"></i>Back</a>
            </div>
          </div>

          {{-- Info Panel --}}
          <div class="col-md-5">
            <div class="card shadow-sm" style="position:sticky;top:70px">
              <div class="card-header bg-dark text-white"><h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Role সম্পর্কে</h3></div>
              <div class="card-body" style="font-size:13px">
                <div style="background:#fff3cd;border-radius:8px;padding:12px;margin-bottom:10px">
                  <strong>👔 Manager:</strong>
                  <ul style="padding-left:16px;margin:5px 0 0;line-height:1.9">
                    <li>নির্দিষ্ট modules-এ পূর্ণ access</li>
                    <li>অন্য Manager/Employee edit করতে পারবে না</li>
                  </ul>
                </div>
                <div style="background:#d1ecf1;border-radius:8px;padding:12px;margin-bottom:10px">
                  <strong>👤 Employee:</strong>
                  <ul style="padding-left:16px;margin:5px 0 0;line-height:1.9">
                    <li>নির্দিষ্ট modules-এ সীমিত access</li>
                    <li>শুধু assigned কাজ করতে পারবে</li>
                  </ul>
                </div>
                <div style="background:#f8d7da;border-radius:8px;padding:12px">
                  <strong>⛔ সব Staff-এর জন্য বাধা:</strong>
                  <ul style="padding-left:16px;margin:5px 0 0;line-height:1.9">
                    <li>Main Admin-এর account edit করা যাবে না</li>
                    <li>অন্য Staff-এর account edit করা যাবে না</li>
                    <li>নিজের permission নিজে change করা যাবে না</li>
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
function togglePw(id) { var i=document.getElementById(id); i.type=i.type==='password'?'text':'password'; }
function togglePerm(card, key) {
  var cb = document.getElementById('perm_'+key);
  cb.checked = !cb.checked;
  card.style.borderColor = cb.checked ? '#1e25fa' : '#eee';
  card.style.background  = cb.checked ? '#f0f2ff' : '#fff';
}
document.querySelectorAll('.permission-card').forEach(function(card) {
  var cb = card.querySelector('input[type=checkbox]');
  if (cb && cb.checked) { card.style.borderColor='#1e25fa'; card.style.background='#f0f2ff'; }
});
function selectAll(val) {
  document.querySelectorAll('.permission-card').forEach(function(card) {
    var cb = card.querySelector('input[type=checkbox]');
    if(cb) { cb.checked=val; card.style.borderColor=val?'#1e25fa':'#eee'; card.style.background=val?'#f0f2ff':'#fff'; }
  });
}
function updateRoleInfo(role) {
  var info = document.getElementById('roleInfo');
  if(role==='manager') info.textContent='নির্দিষ্ট sections-এ full access পাবে';
  else if(role==='employee') info.textContent='শুধু নির্দিষ্ট কাজ করতে পারবে';
  else info.textContent='';
}
</script>
@endpush
@endsection

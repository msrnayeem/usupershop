@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h5 class="m-0"><i class="fas fa-plus text-primary"></i> Withdrawal Method Edit করুন</h5></div></div>
  <section class="content"><div class="container-fluid">
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>@foreach($errors->all() as $e)<div><i class="fas fa-exclamation-circle"></i> {{ $e }}</div>@endforeach</div>
    @endif

    <form action="{{ route('withdrawal.methods.update', $method->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white"><h3 class="card-title">Method Details</h3></div>
            <div class="card-body">
              <div class="form-row">
                <div class="col-md-6 form-group">
                  <label class="font-weight-bold">Method Name <span class="text-danger">*</span></label>
                  <input type="text" name="name" value="{{ old('name', \$method->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="যেমন: bKash, Nagad, Rocket, Bank">
                  @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 form-group">
                  <label class="font-weight-bold">Logo Emoji</label>
                  <input type="text" name="logo_emoji" value="{{ old('logo_emoji', \$method->logo_emoji) }}" class="form-control" placeholder="💳" maxlength="5" style="font-size:20px">
                  <small class="text-muted">একটি emoji বেছে নিন</small>
                </div>
                <div class="col-md-3 form-group">
                  <label class="font-weight-bold">Brand Color</label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><input type="color" name="logo_color" value="{{ old('logo_color', \$method->logo_color) }}" style="width:24px;height:24px;border:none;padding:0;cursor:pointer"></span></div>
                    <input type="text" class="form-control" placeholder="#e8001d" id="colorText" value="{{ old('logo_color', \$method->logo_color) }}" onchange="document.querySelector('input[type=color]').value=this.value">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Account Label <span class="text-danger">*</span></label>
                <input type="text" name="account_label" value="{{ old('account_label', \$method->account_label) }}" class="form-control @error('account_label') is-invalid @enderror" placeholder="যেমন: bKash নম্বর, Account নম্বর">
                <small class="text-muted">Withdrawal form-এ input-এর সামনে এই label দেখাবে</small>
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Account Placeholder</label>
                <input type="text" name="account_placeholder" value="{{ old('account_placeholder', \$method->account_placeholder) }}" class="form-control" placeholder="01XXXXXXXXX">
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Validation Pattern (Regex) <span class="badge badge-secondary">Optional</span></label>
                <input type="text" name="account_regex" value="{{ old('account_regex', \$method->account_regex) }}" class="form-control" style="font-family:monospace" placeholder="^01[3-9][0-9]{8}$">
                <small class="text-muted">Mobile number: <code>^01[3-9][0-9]{8}$</code> | ফাঁকা রাখলে কোনো validation হবে না</small>
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Instructions (User-এর জন্য)</label>
                <textarea name="instructions" rows="2" class="form-control" placeholder="যেমন: বিকাশ Personal নম্বর দিন। Agent নম্বর গ্রহণযোগ্য।">{{ old('instructions', \$method->instructions) }}</textarea>
              </div>
              <div class="form-row">
                <div class="col-md-4 form-group">
                  <label class="font-weight-bold">Sort Order</label>
                  <input type="number" name="sort_order" value="{{ old('sort_order', \$method->sort_order) }}" class="form-control" min="0" placeholder="1, 2, 3...">
                  <small class="text-muted">ছোট সংখ্যা আগে দেখাবে</small>
                </div>
                <div class="col-md-4 form-group" style="padding-top:28px">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="isActive" name="is_active" value="1" {{ \$method->is_active ? 'checked' : '' }}>
                    <label class="custom-control-label font-weight-bold" for="isActive">Active রাখুন</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-lg px-5"><i class="fas fa-save mr-2"></i>Save করুন</button>
          <a href="{{ route('withdrawal.methods.index') }}" class="btn btn-secondary btn-lg ml-2"><i class="fas fa-arrow-left mr-2"></i>Back</a>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm">
            <div class="card-header bg-dark text-white"><h3 class="card-title">Preview</h3></div>
            <div class="card-body" style="font-size:13px">
              <div style="background:#f8f9fb;border-radius:10px;padding:14px;border:1px solid #eee">
                <div style="font-size:12px;font-weight:700;color:#555;margin-bottom:8px">Withdrawal Form Preview:</div>
                <label style="font-size:13px;font-weight:700" id="previewLabel">bKash নম্বর</label>
                <input type="text" class="form-control mt-1" id="previewInput" placeholder="01XXXXXXXXX" disabled style="font-size:13px">
              </div>
              <div class="mt-3">
                <strong>Presets:</strong>
                <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:8px">
                  <button type="button" class="btn btn-sm btn-outline-danger" onclick="setPreset('bKash','💳','#e8001d','bKash নম্বর','01XXXXXXXXX','^01[3-9][0-9]{8}$','বিকাশ Personal নম্বর দিন।')">💳 bKash</button>
                  <button type="button" class="btn btn-sm btn-outline-warning" onclick="setPreset('Nagad','🟠','#f57c00','Nagad নম্বর','01XXXXXXXXX','^01[3-9][0-9]{8}$','নগদ Personal নম্বর দিন।')">🟠 Nagad</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setPreset('Rocket','🚀','#7b1fa2','Rocket নম্বর','01XXXXXXXXX-X','^01[1][0-9]{8,9}$','Dutch-Bangla Rocket নম্বর দিন।')">🚀 Rocket</button>
                  <button type="button" class="btn btn-sm btn-outline-info" onclick="setPreset('Bank Transfer','🏦','#1565c0','Account Number','AC নম্বর','','Bank account বিস্তারিত দিন।')">🏦 Bank</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div></section>
</div>
@push('scripts')
<script>
function setPreset(name,emoji,color,label,placeholder,regex,inst) {
  document.querySelector('input[name=name]').value=name;
  document.querySelector('input[name=logo_emoji]').value=emoji;
  document.querySelector('input[name=logo_color]').value=color;
  document.querySelector('input[type=color]').value=color;
  document.querySelector('input[name=account_label]').value=label;
  document.querySelector('input[name=account_placeholder]').value=placeholder;
  document.querySelector('input[name=account_regex]').value=regex;
  document.querySelector('textarea[name=instructions]').value=inst;
  document.getElementById('previewLabel').textContent=label;
  document.getElementById('previewInput').placeholder=placeholder;
}
document.querySelector('input[name=account_label]').addEventListener('input',function(){
  document.getElementById('previewLabel').textContent=this.value;
});
document.querySelector('input[name=account_placeholder]').addEventListener('input',function(){
  document.getElementById('previewInput').placeholder=this.value;
});
</script>
@endpush
@endsection

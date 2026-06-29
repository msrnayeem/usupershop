@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-edit" style="color:#6366f1;margin-right:8px;"></i>
                    Edit Withdrawal Method
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('withdrawal.methods.index') }}" style="color:#6366f1;text-decoration:none;">Withdrawal Methods</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Edit
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('withdrawal.methods.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-arrow-left"></i> Back to Methods
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" style="border:none;border-radius:8px;background:#fef2f2;color:#b91c1c;margin-bottom:20px;">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        @foreach($errors->all() as $e)
                            <div><i class="fas fa-exclamation-circle mr-1"></i> {{ $e }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('withdrawal.methods.update', $method->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <span class="card-title">
                                        <i class="fas fa-sliders-h" style="color:#6366f1;margin-right:6px;"></i>
                                        Method Parameters Configuration
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">Method Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ old('name', $method->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g., bKash Personal, Nagad, Bank Transfer" required>
                                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="font-weight-bold">Logo Emoji</label>
                                            <input type="text" name="logo_emoji" value="{{ old('logo_emoji', $method->logo_emoji) }}" class="form-control" placeholder="💳" maxlength="5" style="font-size:18px;">
                                            <small class="text-muted">A representation emoji</small>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="font-weight-bold">Brand Color</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text" style="padding:4px 10px;background:#fff;"><input type="color" name="logo_color" value="{{ old('logo_color', $method->logo_color) }}" style="width:24px;height:24px;border:none;padding:0;cursor:pointer;background:transparent;"></span></div>
                                                <input type="text" class="form-control" placeholder="#e8001d" id="colorText" value="{{ old('logo_color', $method->logo_color) }}" onchange="document.querySelector('input[type=color]').value=this.value">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Account Label <span class="text-danger">*</span></label>
                                        <input type="text" name="account_label" value="{{ old('account_label', $method->account_label) }}" class="form-control @error('account_label') is-invalid @enderror" placeholder="e.g., Wallet Account ID, Account Number, Mobile No" required>
                                        <small class="text-muted">This text appears as label for the input on payout forms</small>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Account Input Placeholder</label>
                                        <input type="text" name="account_placeholder" value="{{ old('account_placeholder', $method->account_placeholder) }}" class="form-control" placeholder="e.g., 01XXXXXXXXX, 100-3452-1928">
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Validation Pattern (Regex Regex) <span class="badge badge-light ml-1" style="border:1px solid #cbd5e1;color:#475569;">Optional</span></label>
                                        <input type="text" name="account_regex" value="{{ old('account_regex', $method->account_regex) }}" class="form-control" style="font-family:monospace;" placeholder="^01[3-9][0-9]{8}$">
                                        <small class="text-muted">Standard BD Phone Regex: <code>^01[3-9][0-9]{8}$</code> | Leave blank for no client-side pattern matching</small>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">User Instructions</label>
                                        <textarea name="instructions" rows="2" class="form-control" placeholder="Describe instructions such as: Enter Personal mobile number only. Agent cashout not accepted.">{{ old('instructions', $method->instructions) }}</textarea>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold">Sort Order</label>
                                            <input type="number" name="sort_order" value="{{ old('sort_order', $method->sort_order) }}" class="form-control" min="0" placeholder="1, 2, 3...">
                                            <small class="text-muted">Smaller numbers rank first</small>
                                        </div>
                                        <div class="col-md-4 form-group" style="display:flex;align-items:center;padding-top:20px;">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="isActive" name="is_active" value="1" {{ $method->is_active ? 'checked' : '' }}>
                                                <label class="custom-control-label font-weight-bold" for="isActive" style="cursor:pointer;">Active Status</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="display:flex;gap:12px;margin-bottom:40px;">
                                <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:12px 30px;border-radius:8px;font-weight:600;"><i class="fas fa-save mr-2"></i>Save Method</button>
                                <a href="{{ route('withdrawal.methods.index') }}" class="btn btn-secondary" style="background:#f1f5f9;border:1px solid #cbd5e1;color:#475569;padding:12px 24px;border-radius:8px;font-weight:600;"><i class="fas fa-arrow-left mr-2"></i>Cancel</a>
                            </div>
                        </div>

                        {{-- Live Preview --}}
                        <div class="col-md-4">
                            <div class="card mb-4" style="position:sticky;top:20px;">
                                <div class="card-header" style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                                    <span class="card-title font-weight-bold text-dark"><i class="fas fa-eye mr-1" style="color:#6366f1;"></i> Form Live Preview</span>
                                </div>
                                <div class="card-body">
                                    <div style="background:#f8fafc;border-radius:10px;padding:16px;border:1px solid #e2e8f0;">
                                        <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:12px;">Checkout Wallet Preview</div>
                                        <label style="font-size:13px;font-weight:700;color:#0f172a;" id="previewLabel">{{ $method->account_label }}</label>
                                        <input type="text" class="form-control mt-1" id="previewInput" placeholder="{{ $method->account_placeholder }}" disabled style="font-size:13px;background:#fff;">
                                    </div>
                                    <div class="mt-4">
                                        <strong style="font-size:13px;color:#0f172a;">Presets QuickFill:</strong>
                                        <div style="display:flex;flex-direction:column;gap:8px;margin-top:12px;">
                                            <button type="button" class="btn btn-sm btn-outline-danger text-left" onclick="setPreset('bKash','💳','#e8001d','bKash Number','01XXXXXXXXX','^01[3-9][0-9]{8}$','Please enter your personal bKash number. Agent numbers not allowed.')" style="border-radius:6px;font-weight:600;"><i class="fas fa-bolt mr-2"></i> bKash Preset</button>
                                            <button type="button" class="btn btn-sm btn-outline-warning text-left" onclick="setPreset('Nagad','🟠','#f57c00','Nagad Number','01XXXXXXXXX','^01[3-9][0-9]{8}$','Please enter your personal Nagad number.')" style="border-radius:6px;font-weight:600;color:#ea580c;border-color:#fdba74;"><i class="fas fa-bolt mr-2"></i> Nagad Preset</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary text-left" onclick="setPreset('Rocket','🚀','#7b1fa2','Rocket Number','01XXXXXXXXX-X','^01[1][0-9]{8,9}$','Please enter your personal DBBL Rocket wallet number.')" style="border-radius:6px;font-weight:600;color:#701a75;border-color:#f5d0fe;"><i class="fas fa-bolt mr-2"></i> Rocket Preset</button>
                                            <button type="button" class="btn btn-sm btn-outline-info text-left" onclick="setPreset('Bank Transfer','🏦','#1565c0','Bank Account Number','Enter Full IBAN / Account Number','','Provide bank branch name, routing code, and title in checkout descriptions.')" style="border-radius:6px;font-weight:600;"><i class="fas fa-bolt mr-2"></i> Bank Transfer Preset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

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

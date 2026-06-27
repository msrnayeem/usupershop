@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0"><i class="fas fa-file-invoice text-primary"></i> Invoice Settings</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Invoice Settings</li>
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

      <div class="row">
        <div class="col-md-7">

          <form action="{{ route('settings.invoice.update') }}" method="POST">
            @csrf @method('PUT')

            {{-- Invoice Format --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-hashtag mr-2"></i>Invoice Number Format</h3>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="font-weight-bold">Invoice Prefix</label>
                      <input type="text" name="invoice_prefix"
                        value="{{ $setting->invoice_prefix ?? 'USP' }}"
                        class="form-control @error('invoice_prefix') is-invalid @enderror"
                        maxlength="10" placeholder="USP"
                        style="font-family:monospace;font-size:16px;font-weight:700;text-transform:uppercase"
                        oninput="this.value=this.value.toUpperCase();updatePreview()">
                      @error('invoice_prefix')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      <small class="text-muted">যেমন: USP, INV, ORD (সর্বোচ্চ ১০ অক্ষর)</small>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="font-weight-bold">Number Digits</label>
                      <select name="invoice_digits" class="form-control" onchange="updatePreview()">
                        @foreach([3,4,5,6,7] as $d)
                        <option value="{{ $d }}" {{ ($setting->invoice_digits ?? 5) == $d ? 'selected' : '' }}>
                          {{ $d }} digits ({{ str_pad('1', $d, '0', STR_PAD_LEFT) }})
                        </option>
                        @endforeach
                      </select>
                      <small class="text-muted">Invoice number-এ কতটি সংখ্যা থাকবে</small>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="font-weight-bold">Start Number</label>
                      <input type="number" name="invoice_start_no"
                        value="{{ $setting->invoice_start_no ?? 1 }}"
                        class="form-control" min="1" placeholder="1"
                        oninput="updatePreview()">
                      <small class="text-muted">প্রথম invoice কত নম্বর থেকে শুরু হবে</small>
                    </div>
                  </div>
                </div>

                {{-- Live Preview --}}
                <div style="background:#f8f9fb;border:2px dashed #e8001d;border-radius:10px;padding:16px;text-align:center;margin-top:8px">
                  <small class="text-muted d-block mb-1">Invoice Preview</small>
                  <span id="invoicePreview" style="font-size:28px;font-weight:800;color:#e8001d;font-family:monospace;letter-spacing:2px">USP00044</span>
                </div>
              </div>
            </div>

            {{-- Invoice Content --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header bg-success text-white">
                <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Invoice Content</h3>
              </div>
              <div class="card-body">

                <div class="form-group">
                  <label class="font-weight-bold">Footer Note / Important Notice</label>
                  <textarea name="invoice_footer_note" rows="3"
                    class="form-control"
                    placeholder="Invoice-এর নিচে গুরুত্বপূর্ণ নোট...">{{ $setting->invoice_footer_note ?? 'পণ্য গ্রহণের সময় ডেলিভারি ম্যানের সামনেই চেক করুন। যেকোনো সমস্যায় WhatsApp করুন: 01816622128' }}</textarea>
                  <small class="text-muted">Invoice-এর নিচে যে সতর্কতা বা নোট দেখাবে</small>
                </div>

                <div class="form-group">
                  <label class="font-weight-bold">Thank You Message</label>
                  <input type="text" name="invoice_thank_you"
                    value="{{ $setting->invoice_thank_you ?? 'ধন্যবাদ U Super Shop-এ কেনাকাটার জন্য!' }}"
                    class="form-control"
                    placeholder="ধন্যবাদ বার্তা...">
                  <small class="text-muted">Invoice-এর একদম নিচে Thank You section-এ দেখাবে</small>
                </div>

              </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg px-5">
              <i class="fas fa-save mr-2"></i> Save Settings
            </button>
          </form>

        </div>

        {{-- Preview Panel --}}
        <div class="col-md-5">
          <div class="card shadow-sm" style="position:sticky;top:70px">
            <div class="card-header bg-dark text-white">
              <h3 class="card-title"><i class="fas fa-eye mr-2"></i>Invoice Preview</h3>
            </div>
            <div class="card-body p-0">
              <div style="background:#e8001d;padding:20px;text-align:center">
                <div style="background:#fff;display:inline-block;border-radius:6px;padding:4px 12px;font-size:16px;font-weight:800;color:#e8001d;margin-bottom:8px">
                  U SUPER SHOP
                </div>
                <div style="color:#fff;font-size:20px;font-weight:800">INVOICE</div>
                <div style="background:rgba(255,255,255,.2);color:#fff;font-size:14px;font-weight:700;padding:4px 16px;border-radius:20px;display:inline-block;margin-top:4px" id="previewInvoiceNo">USP00044</div>
              </div>

              <div style="padding:16px">
                <div style="background:#f8f9fb;border-radius:8px;padding:12px;margin-bottom:12px;font-size:14px">
                  <div style="font-weight:800;color:#e8001d;margin-bottom:6px">Ship To</div>
                  <div><strong>রাহেলা বেগম</strong></div>
                  <div>📱 01712345678</div>
                  <div>📍 ধানমন্ডি, ঢাকা</div>
                </div>

                <table style="width:100%;border-collapse:collapse;font-size:14px;margin-bottom:12px">
                  <thead><tr style="background:#1a1a2e;color:#fff">
                    <th style="padding:8px;text-align:left">Product</th>
                    <th style="padding:8px;text-align:right">Total</th>
                  </tr></thead>
                  <tbody>
                    <tr style="background:#fafafa"><td style="padding:8px">পাঞ্জাবি কালেকশন × 2</td><td style="padding:8px;text-align:right;color:#e8001d;font-weight:800">৳1,560</td></tr>
                    <tr><td style="padding:8px">স্কিনকেয়ার সেট × 1</td><td style="padding:8px;text-align:right;color:#e8001d;font-weight:800">৳425</td></tr>
                  </tbody>
                </table>

                <div style="background:#f8f9fb;border-radius:6px;overflow:hidden;margin-bottom:10px;font-size:14px">
                  <div style="display:flex;justify-content:space-between;padding:6px 10px">
                    <span>Delivery Charge</span><span style="color:#00a855;font-weight:700">বিনামূল্যে 🎉</span>
                  </div>
                  <div style="display:flex;justify-content:space-between;padding:8px 10px;background:#e8001d;color:#fff;font-weight:800">
                    <span>Grand Total</span><span>৳1,985</span>
                  </div>
                </div>

                <div style="background:#fff8e1;border:1px solid #f5c400;border-radius:6px;padding:8px 10px;font-size:13px;color:#856404;margin-bottom:10px" id="previewFooterNote">
                  📌 পণ্য গ্রহণের সময় ডেলিভারি ম্যানের সামনেই চেক করুন।
                </div>

                <div style="text-align:center;font-size:13px;color:#666;padding:8px" id="previewThankYou">
                  🙏 ধন্যবাদ U Super Shop-এ কেনাকাটার জন্য!
                </div>
              </div>

              <div style="background:#1a1a2e;padding:10px;text-align:center;font-size:13px;color:rgba(255,255,255,.7)">
                usuper.shop | 01816622128 | usupershopbd@gmail.com
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
function updatePreview() {
  var prefix = document.querySelector('[name="invoice_prefix"]').value.toUpperCase() || 'USP';
  var digits  = parseInt(document.querySelector('[name="invoice_digits"]').value) || 5;
  var start   = parseInt(document.querySelector('[name="invoice_start_no"]').value) || 1;
  var num     = 44 + start - 1;
  var padded  = String(num).padStart(digits, '0');
  var invoice = prefix + padded;
  document.getElementById('invoicePreview').textContent = invoice;
  document.getElementById('previewInvoiceNo').textContent = invoice;
}
updatePreview();
</script>
@endpush
@endsection

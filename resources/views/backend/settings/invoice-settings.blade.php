@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-file-invoice" style="color:#6366f1;margin-right:8px;"></i>
                    Invoice Settings
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Invoice Settings
                </p>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" style="border:none;border-radius:8px;background:#f0fdf4;color:#15803d;margin-bottom:20px;">
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <div class="row">
                    {{-- Form Configuration Column --}}
                    <div class="col-md-7">
                        <form action="{{ route('settings.invoice.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Invoice Format Card --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <span class="card-title">
                                        <i class="fas fa-hashtag" style="color:#6366f1;margin-right:6px;"></i>
                                        Invoice Number Format Settings
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="invoice_prefix" style="font-weight:600;color:#334155;font-size:13px;">Invoice Prefix</label>
                                                <input type="text" name="invoice_prefix" value="{{ $setting->invoice_prefix ?? 'USP' }}" class="form-control @error('invoice_prefix') is-invalid @enderror" maxlength="10" placeholder="e.g. USP, INV" style="font-family:monospace;font-size:15px;font-weight:700;text-transform:uppercase;" oninput="this.value=this.value.toUpperCase();updatePreview()" required>
                                                @error('invoice_prefix')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                <small class="text-muted mt-1 d-block">Max 10 alphanumeric letters</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="invoice_digits" style="font-weight:600;color:#334155;font-size:13px;">Number Pad Digits</label>
                                                <select name="invoice_digits" id="invoice_digits" class="form-control select2" onchange="updatePreview()">
                                                    @foreach([3,4,5,6,7] as $d)
                                                        <option value="{{ $d }}" {{ ($setting->invoice_digits ?? 5) == $d ? 'selected' : '' }}>
                                                            {{ $d }} digits ({{ str_pad('1', $d, '0', STR_PAD_LEFT) }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-muted mt-1 d-block">Pads leading zeros to alignment</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="invoice_start_no" style="font-weight:600;color:#334155;font-size:13px;">Starting Serial No.</label>
                                                <input type="number" name="invoice_start_no" value="{{ $setting->invoice_start_no ?? 1 }}" class="form-control" min="1" placeholder="1" oninput="updatePreview()" required>
                                                <small class="text-muted mt-1 d-block">Starts incrementing from this value</small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Live Code Preview --}}
                                    <div style="background:#f8fafc;border:2px dashed #6366f1;border-radius:10px;padding:18px;text-align:center;margin-top:10px;">
                                        <small class="text-muted d-block mb-1" style="font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Live Invoice Serial Preview</small>
                                        <span id="invoicePreview" style="font-size:26px;font-weight:800;color:#6366f1;font-family:monospace;letter-spacing:1px;">USP00044</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Invoice Footer Details --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <span class="card-title">
                                        <i class="fas fa-edit" style="color:#6366f1;margin-right:6px;"></i>
                                        Invoice Content Customization
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="invoice_footer_note" style="font-weight:600;color:#334155;font-size:13px;">Footer Terms & Important Notice</label>
                                        <textarea name="invoice_footer_note" id="invoice_footer_note" rows="3" class="form-control" placeholder="Important notices, warranty guidelines, or terms of return..." oninput="updatePreviewNote(this.value)">{{ $setting->invoice_footer_note ?? 'Please verify package contents with delivery person. For help, WhatsApp support: 01816622128' }}</textarea>
                                        <small class="text-muted mt-1 d-block">Renders at the base of PDF print slips</small>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label for="invoice_thank_you" style="font-weight:600;color:#334155;font-size:13px;">Signoff Thank You Message</label>
                                        <input type="text" name="invoice_thank_you" id="invoice_thank_you" value="{{ $setting->invoice_thank_you ?? 'Thank you for shopping at U Super Shop!' }}" class="form-control" placeholder="e.g. Thanks for choosing us!" oninput="updatePreviewThankYou(this.value)">
                                        <small class="text-muted mt-1 d-block">Polite thank you greeting on bills</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom:40px;">
                                <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:12px 30px;border-radius:8px;font-weight:600;box-shadow: 0 4px 6px -1px rgba(99,102,241,0.2);">
                                    <i class="fas fa-save mr-2"></i> Save Invoice Configuration
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Live Mock Bill Column --}}
                    <div class="col-md-5">
                        <div class="card" style="position:sticky;top:20px;">
                            <div class="card-header bg-dark d-flex align-items-center">
                                <span class="card-title font-weight-bold text-white"><i class="fas fa-eye mr-2"></i>Live Layout Preview</span>
                            </div>
                            <div class="card-body p-0" style="background:#fff;overflow:hidden;">
                                <div style="background:#6366f1;padding:24px;text-align:center;">
                                    <div style="background:#fff;display:inline-block;border-radius:6px;padding:4px 12px;font-size:14px;font-weight:800;color:#6366f1;margin-bottom:8px;">
                                        U SUPER SHOP
                                    </div>
                                    <div style="color:#fff;font-size:18px;font-weight:800;letter-spacing:1px;">INVOICE</div>
                                    <div style="background:rgba(255,255,255,0.25);color:#fff;font-size:13px;font-weight:700;padding:4px 16px;border-radius:20px;display:inline-block;margin-top:6px;font-family:monospace;" id="previewInvoiceNo">USP00044</div>
                                </div>

                                <div style="padding:20px;">
                                    <div style="background:#f8fafc;border-radius:8px;padding:15px;margin-bottom:15px;font-size:13px;border:1px solid #e2e8f0;">
                                        <div style="font-weight:800;color:#6366f1;margin-bottom:6px;font-size:11px;text-transform:uppercase;">Customer Shipping Info</div>
                                        <div><strong>Rahela Begum</strong></div>
                                        <div>📱 01712345678</div>
                                        <div>📍 Dhanmondi, Dhaka</div>
                                    </div>

                                    <table style="width:100%;border-collapse:collapse;font-size:13px;margin-bottom:15px;">
                                        <thead>
                                            <tr style="background:#0f172a;color:#fff;">
                                                <th style="padding:8px 10px;text-align:left;border-top-left-radius:6px;border-bottom-left-radius:6px;">Product / SKU</th>
                                                <th style="padding:8px 10px;text-align:right;border-top-right-radius:6px;border-bottom-right-radius:6px;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:10px 8px;">Premium Punjabi Collection × 2</td><td style="padding:10px 8px;text-align:right;color:#0f172a;font-weight:700;">৳1,560</td></tr>
                                            <tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:10px 8px;">Skincare Moisturizer Set × 1</td><td style="padding:10px 8px;text-align:right;color:#0f172a;font-weight:700;">৳425</td></tr>
                                        </tbody>
                                    </table>

                                    <div style="background:#f8fafc;border-radius:8px;overflow:hidden;margin-bottom:15px;font-size:13px;border:1px solid #e2e8f0;">
                                        <div style="display:flex;justify-content:space-between;padding:8px 12px;color:#475569;">
                                            <span>Delivery Charge</span><span style="color:#16a34a;font-weight:700;">Free Shipping 🎉</span>
                                        </div>
                                        <div style="display:flex;justify-content:space-between;padding:10px 12px;background:#6366f1;color:#fff;font-weight:800;">
                                            <span>Grand Total Payable</span><span>৳1,985</span>
                                        </div>
                                    </div>

                                    <div style="background:#fef9c3;border:1px solid #fef08a;border-radius:8px;padding:12px;font-size:12px;color:#713f12;margin-bottom:15px;line-height:1.5;" id="previewFooterNote">
                                        📌 Please verify package contents with delivery person. For help, WhatsApp support: 01816622128
                                    </div>

                                    <div style="text-align:center;font-size:12px;color:#64748b;padding:8px;font-weight:600;" id="previewThankYou">
                                        🙏 Thank you for shopping at U Super Shop!
                                    </div>
                                </div>

                                <div style="background:#0f172a;padding:12px;text-align:center;font-size:11px;color:rgba(255,255,255,0.6);font-family:monospace;">
                                    usuper.shop | 01816622128 | support@usuper.shop
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });

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

        function updatePreviewNote(val) {
            document.getElementById('previewFooterNote').textContent = val ? '📌 ' + val : '';
        }

        function updatePreviewThankYou(val) {
            document.getElementById('previewThankYou').textContent = val ? '🙏 ' + val : '';
        }
        updatePreview();
    </script>
@endpush

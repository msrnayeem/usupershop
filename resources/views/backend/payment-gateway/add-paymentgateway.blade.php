@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-credit-card" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($editData)) Edit Payment Gateway @else Add Payment Gateway @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('paymentgatways.view') }}" style="color:#6366f1;text-decoration:none;">Payment Gateways</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($editData)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('paymentgatways.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Gateways List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form method="post" action="{{ @$editData ? route('paymentgatways.update', $editData->id) : route('paymentgatways.store') }}" id="myForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            {{-- Status Toggles --}}
                            <div class="card mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between" style="padding:20px;">
                                    <div>
                                        <h6 class="font-weight-bold mb-1" style="color:#0f172a;">Gateway Activation Status</h6>
                                        <p class="text-muted mb-0" style="font-size:12px;">Toggle whether online mobile payments are active on the store checkout.</p>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="active_status" id="customSwitch1" value="1" {{ @$editData->active_status == 1 ? 'checked' : '' }} style="cursor:pointer;">
                                        <label class="custom-control-label font-weight-bold" for="customSwitch1" style="cursor:pointer;color:#0f172a;">API Status Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- bKash Section --}}
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center" style="background:#fff3f5;">
                                    <span class="card-title font-weight-bold" style="color:#e11d48;">
                                        <i class="fas fa-mobile-alt mr-2"></i> bKash PGW API Credentials
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="BKASH_USERNAME" style="font-weight:600;color:#334155;font-size:13px;">bKash API Username</label>
                                        <input type="text" name="BKASH_USERNAME" value="{{ @$editData->BKASH_USERNAME }}" class="form-control" id="BKASH_USERNAME" placeholder="Enter Bkash Username">
                                        <span style="color: red;">{{ $errors->has('BKASH_USERNAME') ? $errors->first('BKASH_USERNAME') : '' }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="BKASH_PASSWORD" style="font-weight:600;color:#334155;font-size:13px;">bKash API Password</label>
                                        <input type="password" name="BKASH_PASSWORD" value="{{ @$editData->BKASH_PASSWORD }}" class="form-control" id="BKASH_PASSWORD" placeholder="Enter Bkash Password">
                                        <span style="color: red;">{{ $errors->has('BKASH_PASSWORD') ? $errors->first('BKASH_PASSWORD') : '' }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="BKASH_API_KEY" style="font-weight:600;color:#334155;font-size:13px;">bKash API App Key</label>
                                        <input type="text" name="BKASH_API_KEY" value="{{ @$editData->BKASH_API_KEY }}" class="form-control" id="BKASH_API_KEY" placeholder="Enter Bkash App Key">
                                        <span style="color: red;">{{ $errors->has('BKASH_API_KEY') ? $errors->first('BKASH_API_KEY') : '' }}</span>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="BKASH_SECRET_KEY" style="font-weight:600;color:#334155;font-size:13px;">bKash API App Secret Key</label>
                                        <input type="text" name="BKASH_SECRET_KEY" value="{{ @$editData->BKASH_SECRET_KEY }}" class="form-control" id="BKASH_SECRET_KEY" placeholder="Enter Bkash App Secret Key">
                                        <span style="color: red;">{{ $errors->has('BKASH_SECRET_KEY') ? $errors->first('BKASH_SECRET_KEY') : '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Nagad Section --}}
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center" style="background:#fff7ed;">
                                    <span class="card-title font-weight-bold" style="color:#ea580c;">
                                        <i class="fas fa-mobile-alt mr-2"></i> Nagad PGW API Credentials
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="NAGAD_USERNAME" style="font-weight:600;color:#334155;font-size:13px;">Nagad API Merchant ID / Username</label>
                                        <input type="text" name="NAGAD_USERNAME" value="{{ @$editData->NAGAD_USERNAME }}" class="form-control" id="NAGAD_USERNAME" placeholder="Enter Nagad Merchant ID">
                                        <span style="color: red;">{{ $errors->has('NAGAD_USERNAME') ? $errors->first('NAGAD_USERNAME') : '' }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="NAGAD_PASSWORD" style="font-weight:600;color:#334155;font-size:13px;">Nagad API Password</label>
                                        <input type="password" name="NAGAD_PASSWORD" value="{{ @$editData->NAGAD_PASSWORD }}" class="form-control" id="NAGAD_PASSWORD" placeholder="Enter Nagad Password">
                                        <span style="color: red;">{{ $errors->has('NAGAD_PASSWORD') ? $errors->first('NAGAD_PASSWORD') : '' }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="NAGAD_API_KEY" style="font-weight:600;color:#334155;font-size:13px;">Nagad Merchant Public Key</label>
                                        <input type="text" name="NAGAD_API_KEY" value="{{ @$editData->NAGAD_API_KEY }}" class="form-control" id="NAGAD_API_KEY" placeholder="Enter Nagad Public Key">
                                        <span style="color: red;">{{ $errors->has('NAGAD_API_KEY') ? $errors->first('NAGAD_API_KEY') : '' }}</span>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="NAGAD_SECRET_KEY" style="font-weight:600;color:#334155;font-size:13px;">Nagad Merchant Private Secret Key</label>
                                        <input type="text" name="NAGAD_SECRET_KEY" value="{{ @$editData->NAGAD_SECRET_KEY }}" class="form-control" id="NAGAD_SECRET_KEY" placeholder="Enter Nagad Private Key">
                                        <span style="color: red;">{{ $errors->has('NAGAD_SECRET_KEY') ? $errors->first('NAGAD_SECRET_KEY') : '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-right" style="margin-top:10px;margin-bottom:30px;">
                            <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:12px 30px;border-radius:8px;font-weight:600;box-shadow: 0 4px 6px -1px rgba(99,102,241,0.2);">
                                <i class="fas fa-save mr-2"></i> Save API Credentials
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

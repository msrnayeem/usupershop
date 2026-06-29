@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                <i class="fas fa-edit" style="color:#6366f1;margin-right:8px;"></i>
                Edit Courier
            </h1>
            <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>
                <a href="{{ route('couriers.index') }}" style="color:#6366f1;text-decoration:none;">Couriers</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>
                Edit
            </p>
        </div>
        <a class="btn btn-sm btn-primary" href="{{ route('couriers.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <i class="fas fa-sliders-h" style="color:#6366f1;margin-right:6px;"></i>
                        Edit Courier Integration Parameters
                    </span>
                </div>
                <div class="card-body">
                    <form action="{{ route('couriers.update', $courier->id) }}" method="POST" id="myForm">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name" style="font-weight:600;color:#334155;font-size:13px;">Courier Name <span class="text-danger">*</span></label>
                                <select name="name" id="name" class="form-control select2" required>
                                    <option value="Pathao" {{ $courier->name == 'Pathao' ? 'selected' : '' }}>Pathao</option>
                                    <option value="Steadfast" {{ $courier->name == 'Steadfast' ? 'selected' : '' }}>Steadfast</option>
                                    <option value="RedX" {{ $courier->name == 'RedX' ? 'selected' : '' }}>RedX</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="client_id" style="font-weight:600;color:#334155;font-size:13px;">Client ID</label>
                                <input type="text" name="client_id" id="client_id" value="{{ $courier->client_id }}" class="form-control" placeholder="Enter API Client ID">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="client_secret" style="font-weight:600;color:#334155;font-size:13px;">Client Secret Key</label>
                                <input type="text" name="client_secret" id="client_secret" value="{{ $courier->client_secret }}" class="form-control" placeholder="Enter API Client Secret">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="api_key" style="font-weight:600;color:#334155;font-size:13px;">API Key</label>
                                <input type="text" name="api_key" id="api_key" value="{{ $courier->api_key }}" class="form-control" placeholder="Enter Carrier API Secret Key">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="store_id" style="font-weight:600;color:#334155;font-size:13px;">Store ID / Hub ID</label>
                                <input type="text" name="store_id" id="store_id" value="{{ $courier->store_id }}" class="form-control" placeholder="Enter Merchant Hub Store ID">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="is_active" style="font-weight:600;color:#334155;font-size:13px;">Activation Status</label>
                                <select name="is_active" id="is_active" class="form-control select2">
                                    <option value="1" {{ $courier->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$courier->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="form-group col-md-12 text-right" style="margin-top:20px;border-top:1px solid #e2e8f0;padding-top:20px;margin-bottom:0;">
                                <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:10px 30px;border-radius:8px;font-weight:600;">
                                    <i class="fas fa-save mr-1"></i> Update Courier Config
                                </button>
                            </div>
                        </div>
                    </form>
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
</script>
@endpush

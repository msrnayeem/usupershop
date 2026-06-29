@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-map-marker-alt" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($editData)) Edit Location @else Add Location @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('areas.location') }}" style="color:#6366f1;text-decoration:none;">Locations</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($editData)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('areas.location') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Locations List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-cog" style="color:#6366f1;margin-right:6px;"></i>
                            Location Parameters
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="post"
                            action="{{ @$editData ? route('areas.location.update', $editData->id) : route('areas.location.store') }}"
                            id="myForm">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="division_id" style="font-weight:600;color:#334155;font-size:13px;">Division <span class="text-danger">*</span></label>
                                    <select name="division_id" id="division_id" class="form-control select2" required>
                                        <option value="">Select Division</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}"
                                                {{ @$editData->division_id == $division->id ? 'Selected' : '' }}>
                                                {{ $division->division_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="location_name" style="font-weight:600;color:#334155;font-size:13px;">Location / District Name <span class="text-danger">*</span></label>
                                    <input type="text" name="location_name"
                                        value="{{ @$editData->location_name }}" class="form-control"
                                        id="location_name" placeholder="Enter location name" required>
                                    <span style="color: red;">{{ $errors->has('location_name') ? $errors->first('location_name') : '' }}</span>
                                </div>

                                <div class="form-group col-md-12 text-right mt-3" style="border-top:1px solid #e2e8f0;padding-top:20px;margin-bottom:0;">
                                    <button type="submit" class="btn btn-primary px-4" style="background:#6366f1;border:none;font-weight:600;padding:10px 24px;border-radius:8px;">
                                        <i class="fas fa-save mr-1"></i> {{ @$editData ? 'Update Location' : 'Save Location' }}
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
    <script type="text/javascript">
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#myForm').validate({
                rules: {
                    division_id: {
                        required: true
                    },
                    location_name: {
                        required: true
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush

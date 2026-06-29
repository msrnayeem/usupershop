@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-cogs" style="color:#6366f1;margin-right:8px;"></i>
                    Meta settings
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    About settings
                </p>
            </div>
            @if ($countSettings < 1)
                <a class="btn btn-sm btn-primary" href="{{ route('settings.add') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                    <i class="fas fa-plus-circle"></i> Add Settings
                </a>
            @endif
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                            App Settings Config List
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="dataTables table table-bordered table-striped nowrap dt-responsive" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="6%" class="text-center">SN</th>
                                        <th>App Name</th>
                                        <th>Meta Title</th>
                                        <th>Meta Description</th>
                                        <th width="12%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($settings as $key => $setting)
                                        <tr class="{{ $setting->id }}">
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td style="font-weight:700;color:#0f172a;">{{ $setting->app_name }}</td>
                                            <td>{{ $setting->keywords }}</td>
                                            <td style="text-align:justify;font-size:13px;color:#475569;">{!! $setting->description !!}</td>
                                            <td class="text-center">
                                                <a title="Edit" class="btn btn-sm btn-info" href="{{ route('settings.edit', $setting->id) }}" style="border-radius:6px;padding:5px 12px;font-weight:600;">
                                                    <i class="fas fa-edit mr-1"></i> Edit Settings
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.dataTables').DataTable({
                responsive: true
            });
        });
    </script>
@endpush

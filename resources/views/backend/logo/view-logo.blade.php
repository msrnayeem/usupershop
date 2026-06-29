@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-image" style="color:#6366f1;margin-right:8px;"></i>
                    Manage Logo
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Logo List
                </p>
            </div>
            @if ($countLogo < 1)
                <a class="btn btn-sm btn-primary" href="{{ route('logos.add') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                    <i class="fas fa-plus-circle"></i> Add Logo
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
                            Logo Identity Details
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped nowrap dt-responsive" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th width="8%" class="text-center">SN</th>
                                        <th>Logo Name</th>
                                        <th>Logo Image</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $key => $logo)
                                        <tr class="{{ $logo->id }}">
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td style="font-weight:700;color:#0f172a;">{{ $logo->name }}</td>
                                            <td>
                                                <div style="background:#f8fafc;padding:6px;border-radius:8px;border:1px solid #e2e8f0;display:inline-block;">
                                                    <img style="max-height:48px;max-width:140px;object-fit:contain;display:block;"
                                                        src="{{ !empty($logo->image) ? url('upload/logo_image/' . $logo->image) : url('frontend/no-image-icon.jpg') }}"
                                                        onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div style="display:flex;gap:6px;justify-content:center;">
                                                    <a title="Edit" class="btn btn-sm btn-info"
                                                        href="{{ route('logos.edit', $logo->id) }}" style="border-radius:6px;padding:5px 12px;font-weight:600;">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>
                                                    <a title="Delete" id="delete" class="btn btn-sm btn-danger"
                                                        href="{{ route('logos.delete') }}" data-token="{{ csrf_token() }}"
                                                        data-id="{{ $logo->id }}" style="border-radius:6px;padding:5px 12px;font-weight:600;">
                                                        <i class="fas fa-trash mr-1"></i> Delete
                                                    </a>
                                                </div>
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

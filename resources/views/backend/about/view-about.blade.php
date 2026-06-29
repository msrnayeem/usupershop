@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-info-circle" style="color:#6366f1;margin-right:8px;"></i>
                    Manage About Info
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    About Section Info
                </p>
            </div>
            @if ($countAbout < 1)
                <a class="btn btn-sm btn-primary" href="{{ route('abouts.add') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                    <i class="fas fa-plus-circle"></i> Add About Details
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
                            About Page Description Info
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="8%" class="text-center">SN</th>
                                        <th>Title Heading</th>
                                        <th>Description details</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $key => $about)
                                        <tr class="{{ $about->id }}">
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td style="font-weight:700;color:#0f172a;">{{ $about->title }}</td>
                                            <td style="text-align:justify;font-size:13px;color:#475569;">{!! $about->description !!}</td>
                                            <td class="text-center">
                                                <div style="display:flex;gap:6px;justify-content:center;">
                                                    <a title="Edit" class="btn btn-sm btn-info"
                                                        href="{{ route('abouts.edit', $about->id) }}" style="border-radius:6px;padding:5px 12px;font-weight:600;">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>
                                                    <a title="Delete" id="delete" class="btn btn-sm btn-danger"
                                                        href="{{ route('abouts.delete') }}" data-token="{{ csrf_token() }}"
                                                        data-id="{{ $about->id }}" style="border-radius:6px;padding:5px 12px;font-weight:600;">
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

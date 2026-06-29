@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-file-alt" style="color:#6366f1;margin-right:8px;"></i>
                    Manage Custom Pages
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Custom Pages List
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('pages.create') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-plus-circle"></i> Add Custom Page
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                            Custom Information Pages
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped nowrap dt-responsive" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th width="8%" class="text-center">SN</th>
                                        <th>Page Title</th>
                                        <th>Content Details</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pages as $key => $page)
                                        <tr class="{{ $page->id }}">
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td style="font-weight:700;color:#0f172a;">{{ $page->name }}</td>
                                            <td style="font-size:13px;color:#475569;">{!! Str::limit($page->description, 180) !!}</td>
                                            <td class="text-center">
                                                <a title="Edit Page" class="btn btn-sm btn-info"
                                                    href="{{ route('pages.edit', $page->id) }}" style="border-radius:6px;padding:5px 12px;font-weight:600;">
                                                    <i class="fas fa-edit mr-1"></i> Edit Page
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

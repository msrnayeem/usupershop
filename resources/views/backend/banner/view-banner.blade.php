@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-images" style="color:#6366f1;margin-right:8px;"></i>
                    Manage Banners
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Banners
                </p>
            </div>
            @if ($countBanner < 1)
                <a class="btn btn-sm btn-primary" href="{{ route('banners.add') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                    <i class="fas fa-plus-circle"></i> Add Banner
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
                            Banner Campaign Asset Listing
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="6%" class="text-center">SN</th>
                                        <th>Homepage Small Banner 1</th>
                                        <th>Homepage Small Banner 2</th>
                                        <th>Category Banner Banner</th>
                                        <th>Shop Page Banner</th>
                                        <th width="12%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($allData != null)
                                        @foreach ($allData as $key => $logo)
                                            <tr class="{{ $logo->id }}">
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>
                                                    <div style="background:#f8fafc;padding:4px;border-radius:6px;border:1px solid #e2e8f0;display:inline-block;">
                                                        <img style="max-height:50px;max-width:100px;object-fit:contain;"
                                                            src="{{ !empty($logo->banner_small_image_one) ? url('upload/banner/' . $logo->banner_small_image_one) : url('frontend/no-image-icon.jpg') }}"
                                                            onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="background:#f8fafc;padding:4px;border-radius:6px;border:1px solid #e2e8f0;display:inline-block;">
                                                        <img style="max-height:50px;max-width:100px;object-fit:contain;"
                                                            src="{{ !empty($logo->banner_small_image_two) ? url('upload/banner/' . $logo->banner_small_image_two) : url('frontend/no-image-icon.jpg') }}"
                                                            onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="background:#f8fafc;padding:4px;border-radius:6px;border:1px solid #e2e8f0;display:inline-block;">
                                                        <img style="max-height:50px;max-width:160px;object-fit:contain;"
                                                            src="{{ !empty($logo->category_banner_image) ? url('upload/banner/' . $logo->category_banner_image) : url('frontend/no-image-icon.jpg') }}"
                                                            onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="background:#f8fafc;padding:4px;border-radius:6px;border:1px solid #e2e8f0;display:inline-block;">
                                                        <img style="max-height:50px;max-width:160px;object-fit:contain;"
                                                            src="{{ !empty($logo->shop_page_banner) ? url('upload/banner/' . $logo->shop_page_banner) : url('frontend/no-image-icon.jpg') }}"
                                                            onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a title="Edit" class="btn btn-sm btn-info"
                                                        href="{{ route('banners.edit', $logo->id) }}" style="border-radius:6px;padding:5px 12px;font-weight:600;">
                                                        <i class="fas fa-edit mr-1"></i> Edit Banners
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

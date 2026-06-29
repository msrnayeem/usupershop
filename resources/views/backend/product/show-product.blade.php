@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-info-circle" style="color:#6366f1;margin-right:8px;"></i>
                    Product Details
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('products.view') }}" style="color:#6366f1;text-decoration:none;">Products</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Details
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('products.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Product List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title">
                                    <i class="fas fa-file-alt" style="color:#6366f1;margin-right:6px;"></i>
                                    Product Detailed Info
                                </span>
                            </div>
                            <div class="card-body" style="padding:0;">
                                <table class="table table-bordered table-hover" style="margin:0;">
                                    <tbody>
                                        <tr>
                                            <td width="35%" style="font-weight:600;color:#475569;background:#f8fafc;padding:12px 20px;">Category</td>
                                            <td width="65%" style="padding:12px 20px;">{{ $showData['category']['name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;color:#475569;background:#f8fafc;padding:12px 20px;">Brand</td>
                                            <td style="padding:12px 20px;">{{ $showData['brand']['name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;color:#475569;background:#f8fafc;padding:12px 20px;">Product Name</td>
                                            <td style="padding:12px 20px;font-weight:600;color:#0f172a;">{{ $showData->name }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;color:#475569;background:#f8fafc;padding:12px 20px;">Origin</td>
                                            <td style="padding:12px 20px;">{{ $showData['origin']['country'] }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;color:#475569;background:#f8fafc;padding:12px 20px;">Price</td>
                                            <td style="padding:12px 20px;font-weight:700;color:#6366f1;">{{ $showData->price }} Tk.</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;color:#475569;background:#f8fafc;padding:12px 20px;">Short Description</td>
                                            <td style="padding:12px 20px;color:#475569;line-height:1.6;">{{ $showData->short_desc }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;color:#475569;background:#f8fafc;padding:12px 20px;">Long Description</td>
                                            <td style="padding:12px 20px;color:#475569;line-height:1.6;">{!! $showData->long_desc !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;color:#475569;background:#f8fafc;padding:12px 20px;">Image</td>
                                            <td style="padding:12px 20px;">
                                                <img style="width: 80px;height:90px;border-radius:8px;border:1px solid #e2e8f0;object-fit:cover;"
                                                    src="{{ !empty($showData->image) ? url('upload/product_images/' . $showData->image) : url('frontend/no-image-icon.jpg') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;color:#475569;background:#f8fafc;padding:12px 20px;">Colors</td>
                                            <td style="padding:12px 20px;">
                                                @php
                                                    $colorss = App\Models\ProductColor::where('product_id', $showData->id)->get();
                                                @endphp
                                                @foreach ($colorss as $cls)
                                                    <span style="background:#f1f5f9;color:#334155;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;margin-right:6px;display:inline-block;margin-bottom:4px;">
                                                        {{ $cls['color']['name'] }}
                                                    </span>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;color:#475569;background:#f8fafc;padding:12px 20px;">Sizes</td>
                                            <td style="padding:12px 20px;">
                                                @php
                                                    $sizes = App\Models\ProductSize::where('product_id', $showData->id)->get();
                                                @endphp
                                                @foreach ($sizes as $s)
                                                    <span style="background:#f1f5f9;color:#334155;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;margin-right:6px;display:inline-block;margin-bottom:4px;">
                                                        {{ $s['size']['name'] }}
                                                    </span>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:600;color:#475569;background:#f8fafc;padding:12px 20px;">Product Sub Images</td>
                                            <td style="padding:12px 20px;display:flex;flex-wrap:wrap;gap:10px;">
                                                @php
                                                    $sub_images = App\Models\ProductSubImage::where('product_id', $showData->id)->get();
                                                @endphp
                                                @foreach ($sub_images as $img)
                                                    <img style="width:60px;height:65px;border-radius:6px;border:1px solid #e2e8f0;object-fit:cover;"
                                                        src="{{ url('upload/product_images/product_sub_images/' . $img->sub_image) }}">
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection

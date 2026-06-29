@extends('backend.seller.seller-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-store" style="color:#6366f1;margin-right:8px;"></i>
                    Usupershop Catalog
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    Browse and import master catalog products directly into your personal storefront
                </p>
            </div>
            
            <form class="form-inline m-0" action="{{ route('sellers.product_search') }}">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Search catalog..." aria-label="Search" name="product_search" style="border-radius:8px 0 0 8px;border-right:none;height:38px;padding-left:15px;">
                    <div class="input-group-append">
                        <button class="btn btn-outline-success" type="submit" style="border-radius:0 8px 8px 0;background:#6366f1;color:#fff;border:none;height:38px;padding:0 20px;font-weight:600;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                            @forelse ($products as $items)
                                <div class="col mb-4">
                                    <div class="card h-100" style="border-radius:12px;overflow:hidden;border:1px solid #e2e8f0;transition:all 0.2s ease;">
                                        <div style="position:relative;background:#f8fafc;padding:10px;text-align:center;">
                                            <img src="{{ url('upload/product_images/' . $items->image) }}"
                                                alt="{{ $items->slug }}" style="height:180px;object-fit:contain;width:100%;border-radius:8px;">
                                            @if(!empty($items->discount))
                                                <span style="position:absolute;top:10px;left:10px;background:#ef4444;color:#fff;font-size:11px;font-weight:700;padding:2px 8px;border-radius:20px;">
                                                    @if($items->discount_type == 1)
                                                        {{ $items->discount }}% OFF
                                                    @else
                                                        ৳{{ $items->discount }} OFF
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                        <div class="card-body d-flex flex-column justify-content-between p-3" style="background:#fff;">
                                            <div>
                                                <h6 class="font-weight-bold text-dark mb-2" title="{{ $items->name }}" style="font-size:13.5px;line-height:1.4;height:38px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">
                                                    {{ $items->name }}
                                                </h6>
                                                <div style="margin-bottom:15px;">
                                                    @if (!empty($items->discount))
                                                        <span style="font-weight:800;color:#ef4444;font-size:15px;">
                                                            ৳{{ $items->discount_type == 1 ? $items->price - ($items->price * $items->discount) / 100 : $items->price - $items->discount }}
                                                        </span>
                                                        <span style="text-decoration:line-through;color:#94a3b8;font-size:12px;margin-left:6px;">৳{{ $items->price }}</span>
                                                    @else
                                                        <span style="font-weight:800;color:#0f172a;font-size:15px;">৳{{ $items->price }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <button type="button" onclick="addToMyShop(this.id)" id="{{ $items->id }}" class="btn btn-sm btn-primary btn-block font-weight-bold" style="background:#6366f1;border:none;border-radius:6px;padding:8px 0;">
                                                <i class="fas fa-plus-circle mr-1"></i> Add to Storefront
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5 text-muted">
                                    <div style="font-size:40px;margin-bottom:10px;">📦</div>
                                    No products found matching your catalog search criteria.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

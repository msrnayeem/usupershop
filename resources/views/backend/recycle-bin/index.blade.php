@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  {{-- Page Header --}}
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
      <div>
          <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;display:flex;align-items:center;gap:8px;">
              <i class="fas fa-trash-alt" style="color:#ef4444;"></i>
              Recycle Bin
              @if($totalTrashed > 0)
                  <span class="badge badge-danger" style="background:#ef4444;font-size:12px;padding:4px 10px;border-radius:12px;">{{ $totalTrashed }} Trashed Items</span>
              @endif
          </h1>
          <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
              <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
              <span style="margin:0 6px;color:#cbd5e1;">/</span>
              Recycle Bin
          </p>
      </div>
  </div>

  <section class="content">
      <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" style="border:none;border-radius:8px;background:#f0fdf4;color:#15803d;margin-bottom:20px;">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" style="border:none;border-radius:8px;background:#fef2f2;color:#b91c1c;margin-bottom:20px;">
                <i class="fas fa-times-circle mr-1"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        {{-- Info Banner --}}
        <div class="alert alert-info border-0 mb-4" style="font-size:13px;background:#f0f9ff;color:#0369a1;border-radius:8px;padding:15px;line-height:1.6;">
            <i class="fas fa-info-circle mr-2" style="font-size:16px;"></i>
            <strong>Recycle Bin Notice:</strong> Deleted items are temporarily kept here for safety. Restoring items will activate them back onto the storefront. Permanently deleting items will remove them forever. Items are automatically purged after 30 days.
        </div>

        <div class="row">
            {{-- Left Sidebar: Types Tabs --}}
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <span class="card-title font-weight-bold text-white"><i class="fas fa-folder-open mr-2"></i>Content Categories</span>
                    </div>
                    <div class="card-body p-2" style="background:#fff;">
                        @foreach($tabs as $tabKey => $tab)
                            <a href="{{ route('recycle.bin', ['type' => $tabKey]) }}"
                                class="d-flex align-items-center justify-content-between p-2 mb-1 rounded font-weight-bold"
                                style="text-decoration:none;font-size:13px;transition:all 0.2s ease;
                                    {{ $type === $tabKey ? 'background:#6366f1;color:#fff;' : 'color:#475569;background:#f8fafc;' }}">
                                <span>{{ $tab['icon'] }} {{ $tab['label'] }}</span>
                                @if($counts[$tabKey] > 0)
                                    <span class="badge {{ $type === $tabKey ? 'badge-light text-dark' : 'badge-danger' }}" style="padding:4px 8px;border-radius:4px;">
                                        {{ $counts[$tabKey] }}
                                    </span>
                                @else
                                    <span class="badge badge-secondary" style="padding:4px 8px;border-radius:4px;background:#cbd5e1;color:#475569;">0</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                    @if($totalTrashed > 0)
                        <div class="card-footer p-2 bg-light" style="border-top:1px solid #e2e8f0;">
                            <button type="button" class="btn btn-danger btn-sm btn-block"
                                data-toggle="modal" data-target="#emptyBinModal" style="border-radius:6px;font-weight:700;padding:8px 0;">
                                <i class="fas fa-trash-restore-alt mr-1"></i> Empty Recycle Bin
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right: Items Table --}}
            <div class="col-md-9 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2"
                        style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                        <span class="card-title font-weight-bold text-dark mb-0">
                            {{ $tabs[$type]['icon'] }} Deleted {{ $tabs[$type]['label'] }}
                            <span class="badge badge-secondary ml-1" style="background:#cbd5e1;color:#0f172a;">{{ $counts[$type] }} items</span>
                        </span>
                        @if($counts[$type] > 0)
                            <form action="{{ route('recycle.restore-all', $type) }}" method="POST" class="m-0">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm" style="border-radius:6px;font-weight:600;"
                                    onclick="return confirm('Are you sure you want to restore all items in this section?')">
                                    <i class="fas fa-undo mr-1"></i> Restore All
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Search --}}
                    <div class="card-body pb-0 pt-3">
                        <form method="GET" action="{{ route('recycle.bin') }}" class="d-flex" style="gap:8px">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <input type="text" name="search" value="{{ $search }}"
                                class="form-control form-control-sm" style="border-radius:6px;height:38px;padding-left:15px;"
                                placeholder="🔍 Search trashed items...">
                            <button type="submit" class="btn btn-secondary btn-sm px-4" style="border-radius:6px;font-weight:600;height:38px;background:#64748b;border:none;">Search</button>
                            @if($search)
                                <a href="{{ route('recycle.bin', ['type'=>$type]) }}"
                                    class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center px-3" style="border-radius:6px;height:38px;font-weight:600;">✕ Clear</a>
                            @endif
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="6%" class="text-center">#</th>
                                        @if($type === 'products')
                                            <th>Product</th><th>Original Price</th>
                                        @elseif($type === 'users')
                                            <th>User Name</th><th>Email Coordinates</th><th>Member Type</th>
                                        @elseif($type === 'orders')
                                            <th>Invoice Serial No.</th><th>Payable Total</th><th>Payment Status</th>
                                        @elseif($type === 'coupons')
                                            <th>Coupon Code</th><th>Discount Amount</th><th>Rate Type</th>
                                        @elseif($type === 'categories')
                                            <th>Category Heading</th><th>Url Slug</th>
                                        @else
                                            <th>Name / Title Reference</th>
                                        @endif
                                        <th class="text-center">Deleted At</th>
                                        <th width="150px" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $i => $item)
                                        <tr>
                                            <td class="text-center">{{ ($items->currentPage()-1)*20 + $i + 1 }}</td>

                                            @if($type === 'products')
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if($item->image)
                                                            <div style="background:#f8fafc;padding:4px;border:1px solid #cbd5e1;border-radius:6px;">
                                                                <img src="{{ asset('upload/products/thumbnail/'.$item->image) }}"
                                                                    style="width:36px;height:36px;object-fit:cover;display:block;"
                                                                    onerror="this.src='{{ asset('frontend/no-image-icon.jpg') }}'">
                                                            </div>
                                                        @endif
                                                        <strong style="font-size:13px;color:#0f172a;">{{ Str::limit($item->name, 35) }}</strong>
                                                    </div>
                                                </td>
                                                <td style="font-size:13px;font-weight:700;color:#0f172a;">৳{{ number_format($item->price, 0) }}</td>

                                            @elseif($type === 'users')
                                                <td><strong style="font-size:13px;color:#0f172a;">{{ $item->name }}</strong></td>
                                                <td style="font-size:12px;color:#475569;font-family:monospace;">{{ $item->email }}</td>
                                                <td>
                                                    @php $badge=['seller'=>'primary','vendor'=>'success','dropshipper'=>'danger','customer'=>'info'][$item->usertype]??'secondary'; @endphp
                                                    <span class="badge badge-{{ $badge }}" style="text-transform:uppercase;font-weight:700;border-radius:4px;padding:4px 8px;">{{ $item->usertype }}</span>
                                                </td>

                                            @elseif($type === 'orders')
                                                <td style="font-family:monospace;font-weight:700;color:#0f172a;">{{ $item->invoice_no ?? $item->order_no }}</td>
                                                <td style="font-weight:700;color:#0f172a;">৳{{ number_format($item->grand_total, 0) }}</td>
                                                <td><span class="badge badge-secondary" style="border-radius:4px;padding:4px 8px;">{{ $item->order_payment }}</span></td>

                                            @elseif($type === 'coupons')
                                                <td><strong style="font-family:monospace;color:#6366f1;">{{ $item->promoCode }}</strong></td>
                                                <td style="font-weight:700;">{{ $item->discount_amount }}{{ $item->discount_type == 1 ? '%' : '৳' }}</td>
                                                <td><span class="badge badge-info" style="border-radius:4px;padding:4px 8px;">{{ $item->discount_type == 1 ? 'Percentage' : 'Fixed' }}</span></td>

                                            @elseif($type === 'categories')
                                                <td>{{ $item->cat_icon }} <strong style="color:#0f172a;">{{ $item->name }}</strong></td>
                                                <td style="font-size:12px;font-family:monospace;color:#64748b;">{{ $item->cat_slug ?? '-' }}</td>

                                            @else
                                                <td style="font-weight:600;color:#0f172a;">{{ $item->title ?? $item->name ?? '#'.$item->id }}</td>
                                            @endif

                                            <td class="text-center" style="font-size:12px;">
                                                <span class="text-danger font-weight-bold">{{ $item->deleted_at->diffForHumans() }}</span>
                                                <div class="text-muted" style="font-size:11px;margin-top:2px;">
                                                    {{ $item->deleted_at->format('d M Y, h:i A') }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div style="display:flex;gap:6px;justify-content:center;">
                                                    {{-- Restore --}}
                                                    <form action="{{ route('recycle.restore', [$type, $item->id]) }}" method="POST" class="m-0">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-xs" style="font-weight:600;border-radius:4px;"
                                                            title="Restore" onclick="return confirm('Are you sure you want to restore this item?')">
                                                            <i class="fas fa-undo mr-1"></i> Restore
                                                        </button>
                                                    </form>
                                                    {{-- Permanent Delete --}}
                                                    <form action="{{ route('recycle.force-delete', [$type, $item->id]) }}" method="POST" class="m-0">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-xs" style="font-weight:600;border-radius:4px;"
                                                            title="Force Delete" onclick="return confirm('⚠️ Warning! This item will be permanently removed. This action cannot be undone. Proceed?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div style="font-size:48px;margin-bottom:8px;">🗑️</div>
                                                <div class="text-muted" style="font-size:15px;font-weight:600;">
                                                    Recycle Bin is empty for this category
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($items->hasPages())
                        <div class="card-footer" style="border-top:1px solid #e2e8f0;background:#fff;">
                            {{ $items->appends(['type'=>$type,'search'=>$search])->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
      </div>
  </section>
</div>

{{-- Empty Bin Modal --}}
<div class="modal fade" id="emptyBinModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-exclamation-triangle mr-2"></i>Empty Recycle Bin</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('recycle.empty') }}" method="POST">
                @csrf @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-danger" style="border:none;border-radius:8px;">
                        <strong>Warning!</strong> Performing this action will permanently delete all <strong>{{ $totalTrashed }}</strong> items. This action is irreversible.
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" style="font-size:13px;color:#334155;">Confirm by typing <code>DELETE</code> below:</label>
                        <input type="text" name="confirm" class="form-control"
                            placeholder="DELETE" pattern="DELETE" required style="font-family:monospace;font-weight:700;">
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #e2e8f0;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:6px;font-weight:600;">Cancel</button>
                    <button type="submit" class="btn btn-danger" style="border-radius:6px;font-weight:600;background:#ef4444;border:none;">
                        <i class="fas fa-trash-alt mr-1"></i> Permanently Delete All
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

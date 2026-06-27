@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0">
            🗑️ Recycle Bin
            @if($totalTrashed > 0)
              <span class="badge badge-danger ml-2">{{ $totalTrashed }} items</span>
            @endif
          </h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Recycle Bin</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content"><div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="fas fa-times-circle mr-2"></i>{{ session('error') }}
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    {{-- Info Banner --}}
    <div class="alert alert-info" style="font-size:13px;border-left:4px solid #17a2b8">
      <i class="fas fa-info-circle mr-2"></i>
      <strong>Recycle Bin:</strong>
      Delete করা items এখানে থাকে। <strong>Restore</strong> করলে আবার active হবে।
      <strong>Permanent Delete</strong> করলে আর ফিরে আসবে না।
      <strong>Auto-clean:</strong> ৩০ দিন পর automatically permanent delete হয়।
    </div>

    <div class="row">
      {{-- Left: Type Tabs --}}
      <div class="col-md-3">
        <div class="card shadow-sm">
          <div class="card-header bg-dark text-white">
            <h3 class="card-title"><i class="fas fa-folder-open mr-2"></i>ধরন</h3>
          </div>
          <div class="card-body p-2">
            @foreach($tabs as $tabKey => $tab)
            <a href="{{ route('recycle.bin', ['type' => $tabKey]) }}"
              class="d-flex align-items-center justify-content-between p-2 mb-1 rounded
                {{ $type === $tabKey ? 'text-white' : 'text-dark bg-light' }}"
              style="{{ $type === $tabKey ? 'background:'.$tab['color'].';' : '' }}text-decoration:none;font-size:14px">
              <span>{{ $tab['icon'] }} {{ $tab['label'] }}</span>
              @if($counts[$tabKey] > 0)
              <span class="badge {{ $type === $tabKey ? 'badge-light text-dark' : 'badge-danger' }}">
                {{ $counts[$tabKey] }}
              </span>
              @else
              <span class="badge badge-secondary">0</span>
              @endif
            </a>
            @endforeach
          </div>
          @if($totalTrashed > 0)
          <div class="card-footer p-2">
            {{-- Empty Bin --}}
            <button type="button" class="btn btn-danger btn-sm btn-block"
              data-toggle="modal" data-target="#emptyBinModal">
              <i class="fas fa-fire mr-1"></i>Recycle Bin খালি করুন
            </button>
          </div>
          @endif
        </div>
      </div>

      {{-- Right: Items Table --}}
      <div class="col-md-9">
        <div class="card shadow-sm">
          <div class="card-header d-flex align-items-center"
            style="background:{{ $tabs[$type]['color'] }};color:#fff">
            <h3 class="card-title mr-auto">
              {{ $tabs[$type]['icon'] }} Deleted {{ $tabs[$type]['label'] }}
              <span class="badge badge-light text-dark ml-2">{{ $counts[$type] }}</span>
            </h3>
            @if($counts[$type] > 0)
            <form action="{{ route('recycle.restore-all', $type) }}" method="POST" class="ml-2">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-success btn-sm"
                onclick="return confirm('সব {{ $tabs[$type]['label'] }} Restore করবেন?')">
                <i class="fas fa-undo mr-1"></i>সব Restore করুন
              </button>
            </form>
            @endif
          </div>

          {{-- Search --}}
          <div class="card-body pb-0 pt-2">
            <form method="GET" action="{{ route('recycle.bin') }}" class="d-flex" style="gap:8px">
              <input type="hidden" name="type" value="{{ $type }}">
              <input type="text" name="search" value="{{ $search }}"
                class="form-control form-control-sm"
                placeholder="🔍 খুঁজুন...">
              <button type="submit" class="btn btn-secondary btn-sm px-3">খুঁজুন</button>
              @if($search)
              <a href="{{ route('recycle.bin', ['type'=>$type]) }}"
                class="btn btn-outline-secondary btn-sm">✕ Clear</a>
              @endif
            </form>
          </div>

          <div class="card-body p-0">
            <table class="table table-hover mb-0">
              <thead class="bg-light">
                <tr>
                  <th>#</th>
                  @if($type === 'products')
                    <th>Product</th><th>Price</th>
                  @elseif($type === 'users')
                    <th>নাম</th><th>Email</th><th>Type</th>
                  @elseif($type === 'orders')
                    <th>Invoice</th><th>Total</th><th>Status</th>
                  @elseif($type === 'coupons')
                    <th>Code</th><th>Discount</th><th>Type</th>
                  @elseif($type === 'categories')
                    <th>Category</th><th>Slug</th>
                  @else
                    <th>Name/Title</th>
                  @endif
                  <th>Delete হয়েছে</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($items as $i => $item)
                <tr>
                  <td>{{ ($items->currentPage()-1)*20 + $i + 1 }}</td>

                  @if($type === 'products')
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      @if($item->image)
                      <img src="{{ asset('upload/products/thumbnail/'.$item->image) }}"
                        style="width:36px;height:36px;border-radius:6px;object-fit:cover;border:1px solid #eee"
                        onerror="this.src='{{ asset('frontend/no-image-icon.jpg') }}'">
                      @endif
                      <strong style="font-size:13px">{{ Str::limit($item->name, 35) }}</strong>
                    </div>
                  </td>
                  <td style="font-size:13px">৳{{ number_format($item->price, 0) }}</td>

                  @elseif($type === 'users')
                  <td><strong style="font-size:13px">{{ $item->name }}</strong></td>
                  <td style="font-size:12px;color:#888">{{ $item->email }}</td>
                  <td>
                    @php $badge=['seller'=>'primary','vendor'=>'success','dropshipper'=>'danger','customer'=>'info'][$item->usertype]??'secondary'; @endphp
                    <span class="badge badge-{{ $badge }}">{{ ucfirst($item->usertype) }}</span>
                  </td>

                  @elseif($type === 'orders')
                  <td><strong>{{ $item->invoice_no ?? $item->order_no }}</strong></td>
                  <td>৳{{ number_format($item->grand_total, 0) }}</td>
                  <td><span class="badge badge-secondary">{{ $item->order_payment }}</span></td>

                  @elseif($type === 'coupons')
                  <td><strong style="font-family:monospace">{{ $item->promoCode }}</strong></td>
                  <td>{{ $item->discount_amount }}{{ $item->discount_type == 1 ? '%' : '৳' }}</td>
                  <td><span class="badge badge-info">{{ $item->discount_type == 1 ? 'Percentage' : 'Fixed' }}</span></td>

                  @elseif($type === 'categories')
                  <td>{{ $item->cat_icon }} <strong>{{ $item->name }}</strong></td>
                  <td style="font-size:12px;font-family:monospace;color:#888">{{ $item->cat_slug ?? '-' }}</td>

                  @else
                  <td><strong>{{ $item->title ?? $item->name ?? '#'.$item->id }}</strong></td>
                  @endif

                  <td style="font-size:12px">
                    <span class="text-danger">{{ $item->deleted_at->diffForHumans() }}</span>
                    <div class="text-muted" style="font-size:11px">
                      {{ $item->deleted_at->format('d M Y, h:i A') }}
                    </div>
                  </td>
                  <td>
                    <div class="d-flex" style="gap:5px">
                      {{-- Restore --}}
                      <form action="{{ route('recycle.restore', [$type, $item->id]) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-success btn-xs"
                          title="Restore করুন"
                          onclick="return confirm('Restore করবেন?')">
                          <i class="fas fa-undo"></i> Restore
                        </button>
                      </form>
                      {{-- Permanent Delete --}}
                      <form action="{{ route('recycle.force-delete', [$type, $item->id]) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-xs"
                          title="চিরতরে Delete করুন"
                          onclick="return confirm('⚠️ এটি চিরতরে মুছে যাবে! আর ফিরিয়ে আনা যাবে না। Confirm?')">
                          <i class="fas fa-times"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-5">
                    <div style="font-size:48px;margin-bottom:8px">🗑️</div>
                    <div class="text-muted" style="font-size:15px">
                      এই ধরনের কোনো deleted item নেই
                    </div>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          @if($items->hasPages())
          <div class="card-footer">
            {{ $items->appends(['type'=>$type,'search'=>$search])->links() }}
          </div>
          @endif
        </div>
      </div>
    </div>

  </div></section>
</div>

{{-- Empty Bin Modal --}}
<div class="modal fade" id="emptyBinModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">⚠️ Recycle Bin সম্পূর্ণ খালি করুন</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <form action="{{ route('recycle.empty') }}" method="POST">
        @csrf @method('DELETE')
        <div class="modal-body">
          <div class="alert alert-danger">
            <strong>সাবধান!</strong> এই কাজটি করলে Recycle Bin-এর
            <strong>{{ $totalTrashed }}টি</strong> সব item চিরতরে মুছে যাবে।
            কোনো কিছুই আর ফিরিয়ে আনা যাবে না।
          </div>
          <div class="form-group">
            <label class="font-weight-bold">নিশ্চিত করতে নিচে <code>DELETE</code> টাইপ করুন:</label>
            <input type="text" name="confirm" class="form-control"
              placeholder="DELETE" pattern="DELETE" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-fire mr-1"></i>সম্পূর্ণ খালি করুন
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

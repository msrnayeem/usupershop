@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0"><i class="fas fa-wallet text-primary"></i> Withdraw Payment Methods</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Settings</li>
            <li class="breadcrumb-item active">Withdraw Methods</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
      @endif

      <div class="row">

        {{-- ── Current Methods ──────────────────────────── --}}
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex align-items-center">
              <h3 class="card-title mr-auto"><i class="fas fa-list mr-2"></i>Withdraw Methods</h3>
              <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#addMethodModal">
                <i class="fas fa-plus"></i> নতুন Method
              </button>
            </div>
            <div class="card-body p-0">
              <table class="table table-hover mb-0">
                <thead class="bg-light">
                  <tr>
                    <th>Method</th>
                    <th>Number Label</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($methods as $m)
                  <tr>
                    <td>
                      <span style="font-size:20px">{{ $m->logo_icon }}</span>
                      <strong style="color:{{ $m->color }};margin-left:6px">{{ $m->name }}</strong>
                    </td>
                    <td style="font-size:13px">{{ $m->number_label }}<br><span style="color:#aaa;font-size:11px">{{ $m->number_placeholder }}</span></td>
                    <td>
                      <form action="{{ route('settings.withdraw.toggle', $m->id) }}" method="POST" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-xs {{ $m->is_active ? 'btn-success' : 'btn-secondary' }}">
                          {{ $m->is_active ? '✅ Active' : '❌ Inactive' }}
                        </button>
                      </form>
                    </td>
                    <td>
                      <button class="btn btn-xs btn-info" onclick="editMethod({{ $m->id }}, '{{ $m->name }}', '{{ $m->logo_icon }}', '{{ $m->color }}', '{{ $m->number_label }}', '{{ $m->number_placeholder }}')">
                        <i class="fas fa-edit"></i> Edit
                      </button>
                      <form action="{{ route('settings.withdraw.destroy', $m->id) }}" method="POST" style="display:inline"
                        onsubmit="return confirm('Delete করবেন?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                      </form>
                    </td>
                  </tr>
                  @empty
                  <tr><td colspan="4" class="text-center text-muted py-3">কোনো method নেই</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          {{-- Info --}}
          <div class="alert alert-info" style="font-size:13px">
            <i class="fas fa-info-circle"></i>
            <strong>কীভাবে কাজ করে:</strong>
            এখানে Active করা methods গুলো Seller, Vendor ও Dropshipper-এর Withdraw form-এ দেখাবে।
            Inactive করলে সেই method hide হয়ে যাবে।
          </div>
        </div>

        {{-- ── Preview ──────────────────────────────────── --}}
        <div class="col-md-4">
          <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
              <h3 class="card-title"><i class="fas fa-eye mr-2"></i>Seller দেখবে</h3>
            </div>
            <div class="card-body" style="font-size:13px">
              <div style="font-weight:700;margin-bottom:8px">Payment Method বেছে নিন:</div>
              @foreach($methods->where('is_active', 1) as $m)
              <div style="border:1.5px solid #eee;border-radius:10px;padding:10px 12px;margin-bottom:7px;display:flex;align-items:center;gap:10px;cursor:pointer"
                onmouseover="this.style.borderColor='{{ $m->color }}'" onmouseout="this.style.borderColor='#eee'">
                <span style="font-size:20px">{{ $m->logo_icon }}</span>
                <div>
                  <div style="font-weight:800;color:{{ $m->color }}">{{ $m->name }}</div>
                  <div style="font-size:11px;color:#aaa">{{ $m->number_label }}</div>
                </div>
                <div style="margin-left:auto;width:18px;height:18px;border:2px solid #ddd;border-radius:50%"></div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

{{-- Add/Edit Modal --}}
<div class="modal fade" id="addMethodModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalTitle">নতুন Withdraw Method যোগ করুন</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <form id="methodForm" action="{{ route('settings.withdraw.store') }}" method="POST">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST">
        <input type="hidden" name="method_id" id="methodId" value="">
        <div class="modal-body">
          <div class="form-group">
            <label class="font-weight-bold">Method Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="mName" class="form-control" placeholder="যেমন: bKash, Nagad" required>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label class="font-weight-bold">Logo Icon (Emoji)</label>
                <input type="text" name="logo_icon" id="mIcon" class="form-control" placeholder="💗" maxlength="5">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label class="font-weight-bold">Brand Color</label>
                <input type="color" name="color" id="mColor" class="form-control" value="#E2136E" style="height:38px">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Number Field Label <span class="text-danger">*</span></label>
            <input type="text" name="number_label" id="mLabel" class="form-control" placeholder="বিকাশ নম্বর" required>
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Placeholder Text</label>
            <input type="text" name="number_placeholder" id="mPlaceholder" class="form-control" placeholder="01XXXXXXXXX">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="submitBtn">Save করুন</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
function editMethod(id, name, icon, color, label, placeholder) {
  document.getElementById('modalTitle').textContent = 'Method Edit করুন';
  document.getElementById('formMethod').value = 'PUT';
  document.getElementById('methodForm').action = '/admin/settings/withdraw-methods/' + id;
  document.getElementById('methodId').value = id;
  document.getElementById('mName').value = name;
  document.getElementById('mIcon').value = icon;
  document.getElementById('mColor').value = color;
  document.getElementById('mLabel').value = label;
  document.getElementById('mPlaceholder').value = placeholder;
  document.getElementById('submitBtn').textContent = 'Update করুন';
  $('#addMethodModal').modal('show');
}
$('#addMethodModal').on('hidden.bs.modal', function() {
  document.getElementById('methodForm').reset();
  document.getElementById('modalTitle').textContent = 'নতুন Withdraw Method যোগ করুন';
  document.getElementById('formMethod').value = 'POST';
  document.getElementById('methodForm').action = '{{ route("settings.withdraw.store") }}';
  document.getElementById('submitBtn').textContent = 'Save করুন';
});
</script>
@endpush
@endsection

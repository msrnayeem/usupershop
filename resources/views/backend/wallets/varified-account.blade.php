@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-check" style="color:#6366f1;margin-right:8px;"></i>
                    Verified Accounts
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Verified Accounts
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('wallets.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-wallet"></i> Manage Wallets
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-id-card" style="color:#6366f1;margin-right:6px;"></i>
                            Verified Account Credentials
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="dataTables table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="6%" class="text-center">SN</th>
                                        <th>User Name</th>
                                        <th class="d-none">User id</th>
                                        <th>Nid Number</th>
                                        <th>Bkash Phone No</th>
                                        <th class="text-center">Nid Front Image</th>
                                        <th class="text-center">Nid Back Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($wallets!=null)
                                        @forelse ($wallets as $key=>$wallet)
                                            <tr class="{{ $wallet->id }}">
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td style="font-weight:700;color:#0f172a;">{{ $wallet->name ?? ''}}</td>
                                                <td class="d-none userID">{{ $wallet->user_id}}</td>
                                                <td style="font-weight:600;color:#475569;">{{ $wallet->nid_no ?? 'N/A'}}</td>
                                                <td class="wallet-mobile">{{ $wallet->mobile_no ?? ''}}</td>
                                                <td class="text-center">
                                                    <img style="width: 80px;height:50px;cursor:pointer;border-radius:6px;object-fit:cover;border:1px solid #cbd5e1;"
                                                         src="{{ !empty($wallet->front_image) ? url('public/upload/profile_verify/' . $wallet->front_image) : url('frontend/no-image-icon.jpg') }}"
                                                         class="img-clickable"
                                                         data-toggle="modal"
                                                         data-target="#imageModal"
                                                         data-image="{{ !empty($wallet->front_image) ? url('public/upload/profile_verify/' . $wallet->front_image) : url('frontend/no-image-icon.jpg') }}">
                                                </td>
                                                <td class="text-center">
                                                    <img style="width: 80px;height:50px;cursor:pointer;border-radius:6px;object-fit:cover;border:1px solid #cbd5e1;"
                                                         src="{{ !empty($wallet->back_image) ? url('public/upload/profile_verify/' . $wallet->back_image) : url('frontend/no-image-icon.jpg') }}"
                                                         class="img-clickable"
                                                         data-toggle="modal"
                                                         data-target="#imageModal"
                                                         data-image="{{ !empty($wallet->back_image) ? url('public/upload/profile_verify/' . $wallet->back_image) : url('frontend/no-image-icon.jpg') }}">
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-5 text-muted">
                                                    <i class="fas fa-user-check fa-3x mb-2" style="opacity:0.8;"></i>
                                                    <p style="font-weight:600;margin-bottom:0;color:#1e293b;">No Verified Accounts Found</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Image Modal Structure -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0" style="border-radius:12px;overflow:hidden;box-shadow:0 10px 25px -5px rgba(0,0,0,0.15);">
                            <div class="modal-header" style="border-bottom:1px solid #e2e8f0;background:#f8fafc;">
                                <h6 class="modal-title font-weight-bold" id="imageModalLabel" style="color:#0f172a;">Verification Document Preview</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center" style="background:#0f172a;padding:20px;">
                                <img id="modalImage" src="" class="img-fluid" style="max-height:75vh;border-radius:6px;box-shadow:0 4px 15px rgba(0,0,0,0.5);">
                            </div>
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

        document.addEventListener("DOMContentLoaded", function () {
            const modalImage = document.getElementById("modalImage");
            document.querySelectorAll(".img-clickable").forEach(img => {
                img.addEventListener("click", function () {
                    modalImage.src = this.dataset.image;
                });
            });
        });
    </script>
@endpush

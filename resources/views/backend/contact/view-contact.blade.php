@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-address-book" style="color:#6366f1;margin-right:8px;"></i>
                    Manage Contact Details
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Contacts Section
                </p>
            </div>
            @if ($countContact < 1)
                <a class="btn btn-sm btn-primary" href="{{ route('contacts.add') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                    <i class="fas fa-plus-circle"></i> Add Contact details
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
                            Company Contact Coordinates
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="8%" class="text-center">SN</th>
                                        <th>Physical Address</th>
                                        <th>Mobile Number</th>
                                        <th>Email Address</th>
                                        <th>Facebook Link</th>
                                        <th>YouTube Channel</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $key => $contact)
                                        <tr class="{{ $contact->id }}">
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td style="font-weight:600;color:#0f172a;">{{ $contact->address }}</td>
                                            <td style="font-family:monospace;font-weight:700;">{{ $contact->mobile }}</td>
                                            <td><a href="mailto:{{ $contact->email }}" style="color:#6366f1;text-decoration:none;">{{ $contact->email }}</a></td>
                                            <td><a href="{{ $contact->facebook }}" target="_blank" style="color:#1877f2;text-decoration:none;"><i class="fab fa-facebook mr-1"></i>Link</a></td>
                                            <td><a href="{{ $contact->youtube }}" target="_blank" style="color:#ff0000;text-decoration:none;"><i class="fab fa-youtube mr-1"></i>Channel</a></td>
                                            <td class="text-center">
                                                <div style="display:flex;gap:6px;justify-content:center;">
                                                    <a title="Edit" class="btn btn-sm btn-info"
                                                        href="{{ route('contacts.edit', $contact->id) }}" style="border-radius:6px;padding:5px 12px;font-weight:600;">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>
                                                    <a title="Delete" id="delete" class="btn btn-sm btn-danger"
                                                        href="{{ route('contacts.delete') }}"
                                                        data-token="{{ csrf_token() }}" data-id="{{ $contact->id }}" style="border-radius:6px;padding:5px 12px;font-weight:600;">
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

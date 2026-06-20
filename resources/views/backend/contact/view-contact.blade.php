@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Contact</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Contacts</li>
                            &nbsp;&nbsp;&nbsp;
                            @if ($countContact < 1)
                                <a class="btn btn-sm btn-primary float-right" href="{{ route('contacts.add') }}"><i
                                        class="fas fa-plus-circle"></i> Add Contact</a>
                            @endif
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-md-12">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <!-- <div class="card-header">
                                <h3>
                                    Contact List
                                    @if ($countContact < 1)
                                        <a class="btn btn-sm btn-primary float-right" href="{{ route('contacts.add') }}"><i
                                                class="fas fa-plus-circle"></i> Add Contact</a>
                                    @endif
                                </h3>
                            </div> -->
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="6%">SN</th>
                                                <th>Address</th>
                                                <th>Mobile No</th>
                                                <th>Email</th>
                                                <th>Facebook </th>
                                                <th>Youtube</th>
                                               
                                                <th width="12%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allData as $key => $contact)
                                                <tr class="{{ $contact->id }}">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $contact->address }}</td>
                                                    <td>{{ $contact->mobile }}</td>
                                                    <td>{{ $contact->email }}</td>
                                                    <td>{{ $contact->facebook }}</td>
                                                    <td>{{ $contact->youtube }}</td>
                                                   
                                                    <td>
                                                        <a title="Edit" class="btn btn-sm btn-info"
                                                            href="{{ route('contacts.edit', $contact->id) }}"><i
                                                                class="fas fa-edit"></i> Edit</a>
    
                                                        <a title="Delete" id="delete" class="btn btn-sm btn-danger"
                                                            href="{{ route('contacts.delete') }}"
                                                            data-token="{{ csrf_token() }}" data-id="{{ $contact->id }}"><i
                                                                class="fas fa-trash"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <!-- /.card -->
                    </section>
                    <!-- /.Left col -->
                </div>
                <!-- /.row (main row) -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@extends('backend.layouts.master')

@section('content')
<section class='content-wrapper'>
    
<div class="container">
    <h4>Courier Services</h4>
    <a href="{{ route('couriers.create') }}" class="btn btn-success mb-3">+ Add Courier</a>

    <table class="table table-bordered" id="courier-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Client ID</th>
                <th>Store ID</th>
                <th>Status</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
    </table>
</div>
</section>

<script>
$(function(){
    $('#courier-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('couriers.index') }}",
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'client_id', name: 'client_id' },
        { data: 'store_id', name: 'store_id' },
        { data: 'status', name: 'status', orderable: false, searchable: false },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ]
});

});
</script>
@endsection

@extends('backend.layouts.master')

@section('content')
<section class='content-wrapper'>
    
<div class="container">
    <h4>Add Courier</h4>
    <form action="{{ route('couriers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Courier Name</label>
            <select name="name" class="form-control">
                <option value="Pathao">Pathao</option>
                <option value="Steadfast">Steadfast</option>
                <option value="RedX">RedX</option>
            </select>
        </div>
        <div class="form-group">
            <label>Client ID</label>
            <input type="text" name="client_id" class="form-control">
        </div>
        <div class="form-group">
            <label>Client Secret</label>
            <input type="text" name="client_secret" class="form-control">
        </div>
        <div class="form-group">
            <label>API Key</label>
            <input type="text" name="api_key" class="form-control">
        </div>
        <div class="form-group">
            <label>Store ID</label>
            <input type="text" name="store_id" class="form-control">
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="is_active" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
</section>
@endsection

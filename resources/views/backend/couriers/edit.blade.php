@extends('backend.layouts.master')

@section('content')
<section class="content-wrapper">
    <div class="container">
        <h4>Edit Courier</h4>
        <form action="{{ route('couriers.update', $courier->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Courier Name</label>
                <select name="name" class="form-control" required>
                    <option value="Pathao" {{ $courier->name == 'Pathao' ? 'selected' : '' }}>Pathao</option>
                    <option value="Steadfast" {{ $courier->name == 'Steadfast' ? 'selected' : '' }}>Steadfast</option>
                    <option value="RedX" {{ $courier->name == 'RedX' ? 'selected' : '' }}>RedX</option>
                </select>
            </div>
            <div class="form-group">
                <label>Client ID</label>
                <input type="text" name="client_id" value="{{ $courier->client_id }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Client Secret</label>
                <input type="text" name="client_secret" value="{{ $courier->client_secret }}" class="form-control">
            </div>
            <div class="form-group">
                <label>API Key</label>
                <input type="text" name="api_key" value="{{ $courier->api_key }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Store ID</label>
                <input type="text" name="store_id" value="{{ $courier->store_id }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1" {{ $courier->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$courier->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('couriers.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</section>
@endsection

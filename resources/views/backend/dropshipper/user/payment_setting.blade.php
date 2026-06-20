@extends('backend.dropshipper.dropshipper-master')

@section('title')
    Payment Setting
@endsection

@section('content')
    <main class="content-wrapper">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4 ">
                <h2 class="mb-0">Payment Setting</h2>
            </div>

            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('manage.wallets.payment.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="method" class="form-label">Payment Method</label>
                            <select name="method" id="method" class="form-control" required>
                                <option value="">--Select Method--</option>
                                <option value="Bkash" {{ $payment?->method == 'Bkash' ? 'selected' : '' }}>Bkash</option>
                                <option value="Nagad" {{ $payment?->method == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                <option value="Rocket" {{ $payment?->method == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="number" class="form-label">Number</label>
                            <input type="text" name="number" id="number" class="form-control"
                                value="{{ $payment?->number }}" required placeholder="e.g. 017XXXXXXXX">
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('custom_js')
    <script>
        $('#method').on('change', function() {

            let method = $(this).val();

            if (method === "") {
                $('#number').val("");
                return;
            }

            $.ajax({
                url: "{{ route('manage.wallets.payment') }}",
                type: "GET",
                data: {
                    method_type: method
                },
                success: function(res) {
                    if (res.data) {
                        $('#number').val(res.data.number);
                    } else {
                        $('#number').val("");
                    }
                }
            });

        });
    </script>
@endsection

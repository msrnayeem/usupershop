@extends('backend.dropshipper.dropshipper-master')
@section('content')
<div class="content-wrapper">
    <div class="content-header" style="padding-bottom:0px;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Shopkeeper Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dropshipper Products</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-md-12">
                    <div class="card">
                        <nav class="navbar justify-content-end">
                            <form class="form-inline" id="product-search-form" method="GET">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" name="product_search" id="product_search">
                            </form>
                        </nav>

                        <div class="card-body">
                            <div id="products-wrapper">
                                @include('backend.dropshipper.order.product-cards', ['products' => $products])
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<!-- jQuery AJAX Script -->
<script>
$(document).ready(function() {
    let typingTimer;
    const debounceInterval = 300; // ms

    $('#product_search').on('keyup', function() {
        clearTimeout(typingTimer);
        let query = $(this).val();

        typingTimer = setTimeout(function() {
            $.ajax({
                url: "{{ route('dropshipper.orders.create') }}",
                type: "GET",
                data: { product_search: query },
                success: function(data) {
                    $('#products-wrapper').html(data);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }, debounceInterval);
    });
});
</script>
@endsection

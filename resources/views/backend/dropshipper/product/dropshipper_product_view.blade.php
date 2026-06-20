@extends('backend.dropshipper.dropshipper-master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Manage Products</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>
                                    Product Details Info
                                    <a class="btn btn-sm btn-primary float-right"
                                        href="{{ route('dropshipper.product.list') }}">
                                        <i class="fas fa-list"></i> Product List
                                    </a>
                                </h3>
                            </div>

                            @php $showData = $myshop->product; @endphp

                            <div class="card-body">
                                <table class="table table-bordered table-hover table-sm">
                                    <tr>
                                        <td width="40%">Category</td>
                                        <td width="60%" class="copy-cell">{{ $showData['category']['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Brand</td>
                                        <td width="60%" class="copy-cell">{{ $showData['brand']['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Product Name</td>
                                        <td width="60%" class="copy-cell">{{ $showData->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Origin</td>
                                        <td width="60%">{{ $showData['origin']['country'] }}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Price</td>
                                        <td width="60%" class="copy-cell">
                                            @if (isset($showData->sale_price) && $showData->sale_price > 0)
                                                {{ $showData->sale_price }} Tk. <span class="badge badge-success">Hole Sale Price</span>
                                            @else
                                                {{ $showData->price }} Tk.
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Short Description</td>
                                        <td width="60%" class="copy-cell">{{ $showData->short_desc }}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Long Description</td>
                                        <td width="60%" class="copy-cell">{!! $showData->long_desc !!}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Main Image</td>
                                        <td width="60%" class="download-cell">
                                            <img style="width:60px;height:70px"
                                                src="{{ !empty($showData->image) ? url('upload/product_images/' . $showData->image) : url('frontend/no-image-icon.jpg') }}">
                                            <span class="download-icon">⬇️</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Colors</td>
                                        <td width="60%">
                                            @php $colorss = App\Models\ProductColor::where('product_id', $showData->id)->get(); @endphp
                                            @foreach ($colorss as $cls)
                                                {{ $cls['color']['name'] }},
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Sizes</td>
                                        <td width="60%">
                                            @php $sizes = App\Models\ProductSize::where('product_id', $showData->id)->get(); @endphp
                                            @foreach ($sizes as $s)
                                                {{ $s['size']['name'] }},
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Sub Images</td>
                                        <td width="60%" class="download-cell">
                                            @php $sub_images = App\Models\ProductSubImage::where('product_id', $showData->id)->get(); @endphp
                                            @foreach ($sub_images as $img)
                                                <img style="width:50px;height:55px"
                                                    src="{{ url('upload/product_images/product_sub_images/' . $img->sub_image) }}">
                                                <span class="download-icon">⬇️</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            // Add copy icon dynamically
            $('.copy-cell').each(function() {
                $(this).append(
                '<span class="copy-icon" style="cursor:pointer; margin-left:5px;">📋</span>');
            });

            // Copy text on icon click
            $(document).on('click', '.copy-icon', function(e) {
                e.stopPropagation();
                const text = $(this).parent().clone() // clone cell
                    .children().remove().end() // remove icon
                    .text().trim();
                copyToClipboard(text);
            });

            function copyToClipboard(text) {
                const temp = $('<input>');
                $('body').append(temp);
                temp.val(text).select();
                document.execCommand('copy');
                temp.remove();

                // small toast
                const toast = $('<div>').text('Copied!').css({
                    position: 'fixed',
                    bottom: '10px',
                    right: '10px',
                    background: '#333',
                    color: '#fff',
                    padding: '6px 10px',
                    borderRadius: '4px',
                    opacity: 0.9,
                    zIndex: 9999
                });
                $('body').append(toast);
                setTimeout(() => toast.fadeOut(300, () => toast.remove()), 1000);
            }

            // Download image on click of image or download icon
            $(document).on('click', '.download-cell img, .download-cell .download-icon', function(e) {
                e.stopPropagation();
                let img = $(this).hasClass('download-icon') ? $(this).siblings('img') : $(this);
                const imageUrl = img.attr('src');

                if (!imageUrl) {
                    console.error('Image URL not found!');
                    return;
                }

                const fileName = imageUrl.split('/').pop();
                const link = document.createElement('a');
                link.href = imageUrl;
                link.download = fileName;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        });
    </script>
@endsection

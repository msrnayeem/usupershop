<div id="hero" style="width:100%;">
    <div id="owl-main" class="owl-carousel">
        @foreach ($sliders as $slider)
        <div class="item">
            @if(!empty($slider->slider_link))
            {{-- Link আছে — clickable --}}
            <a href="{{ $slider->slider_link }}"
               target="{{ $slider->link_target ?? '_self' }}"
               rel="{{ ($slider->link_target ?? '_self') === '_blank' ? 'noopener noreferrer' : '' }}"
               style="display:block;cursor:pointer"
               title="{{ $slider->name ?? '' }}">
                <img src="{{ asset('upload/slider_images/' . $slider->image) }}"
                     alt="{{ $slider->name ?? 'Slider Image' }}"
                     style="width:100%;display:block">
            </a>
            @else
            {{-- Link নেই — শুধু ছবি --}}
            <img src="{{ asset('upload/slider_images/' . $slider->image) }}"
                 alt="{{ $slider->name ?? 'Slider Image' }}"
                 style="width:100%;display:block;cursor:default">
            @endif
        </div>
        @endforeach
    </div>
</div>

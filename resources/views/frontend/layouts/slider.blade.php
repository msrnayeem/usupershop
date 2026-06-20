<div id="hero" style="width:100%;">
    <div id="owl-main" class="owl-carousel">
        @foreach ($sliders as $slider)
            <div class="item">
                <img src="{{ asset('upload/slider_images/' . $slider->image) }}" alt="Slider Image" >
            </div>
        @endforeach
    </div>
</div>


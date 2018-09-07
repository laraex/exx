<div data-ride="carousel" class="carousel carousel-fade" id="carousel-example-captions" style="max-height:500px;">
    <ol class="carousel-indicators">
           @foreach ($slider as $data)           
               <li class="{{ $loop->iteration == 1 ? 'active' : '' }}" data-slide-to="{{ ($loop->iteration)-1 }}" data-target="#carousel-example-captions"></li>
           @endforeach  
    </ol>
    <div role="listbox" class="carousel-inner">
    @foreach ($slider as $data)
        @php
            $path = str_replace('\\', '/', $data['image'])
        @endphp 
        <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}" style="background-size:cover; background-image: url({{ $path }})">
          <div class="container">
          <div class="carousel-caption">
            <h3>{!!  $data['slidertext'] !!}</h3>
              <p><a href="{{ url($data['url']) }}" class="btn  btn-default cta-button cta-button-white" target="_blank">{{ $data['urltext'] }}</a></p>
          </div>
        </div>
        </div>
    @endforeach
    </div>
</div>
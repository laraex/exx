<div class="mt-20 mb-20 p-20">
        <div class="faq-section" style="min-width: 90vw">
            <div id="accordion" class="accordion">
                <div class=" mb-0">
                    @if (count($faq))
                        @foreach($faq as $data)
                        <div class="faq-data" style="border-bottom: 1px dotted #ccc; padding: 10px 0;">
                        <div class=" collapsed" data-toggle="collapse" href="#collapse{{ $data->id }}">
                             <a class="" href="#">
                            <h5 class="faq-title">{{ $data->title }}</h5>
                            </a>
                        </div>
                        <div id="collapse{{ $data->id }}" class=" collapse" data-parent="#accordion" >
                            <p class="padding:20px;">{!! $data->description !!}</p>
                        </div>
                    </div>
            
            
            @endforeach
            @else
                    <div class="col-md-12">
                        {{ trans('company.nofaqfound') }}
                    </div>
             
        </div>
        @endif
    </div>
</div>
</div>

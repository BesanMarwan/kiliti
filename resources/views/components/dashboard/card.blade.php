@props([
    'href'=>'#',
    'title'=>'',
    'count'=>'',
    'counttext'=>'',
    'class'=>'col-xl-3',
    'color'=>'white',
    'svg'=>'',
    'icon'=>'',
])
<div class="{{$class}}">
    <a href="{{$href}}" class="card bg-{{$color}} hoverable card-xl-stretch mb-xl-8">
        <div class="card-body">

                @if($svg)
                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
{{--                        {{ svg($svg) }}--}}
                    </span>
                @elseif($icon)

                    <i class="{{$icon}} text-inverse-{{$color}} fa-3x"></i>

                @else
                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
{{--                        <x-metronic-Equalizer/>--}}

                    </span>
                @endif


            <div class="text-inverse-{{$color}} fw-bolder fs-2 mb-2 mt-5">{{$title}}</div>
            <div class="fw-bold text-inverse-{{$color}} fs-7">{{$count}} {{$counttext}}</div>
        </div>
        <!--end::Body-->
    </a>
</div>

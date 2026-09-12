@props([
    'title'=>'',
    'message'=>'',
    'time'=>'',
    'href'=>'',
    'accent'=>'primary'
])
<div class="d-flex flex-stack py-4">
    <div class="d-flex align-items-center">
        <div class="symbol symbol-35px me-4">
            <span class="symbol-label bg-light-{{$accent}}">
                <span class="svg-icon svg-icon-2 svg-icon-{{$accent}}">
                    <x-metronic-Notifications1/>
                </span>
            </span>
        </div>
        <div class="mb-0 me-2">
            @if($href)
            <a href="{{$href}}" class="fs-6 text-gray-800 text-hover-{{$accent}} fw-bolder">{{$title}}</a>
            @else
                <span class="fs-6 text-gray-800 text-hover-{{$accent}} fw-bolder">{{$title}}</span>
            @endif
            <div class="text-gray-400 fs-7">{{$message}}</div>
        </div>
    </div>
    <span class="badge badge-light fs-8">{{$time}}</span>
</div>

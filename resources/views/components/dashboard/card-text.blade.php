@props([
    'href'=>'#',
    'title'=>'',
    'class'=>'col-xl-3',
    'color'=>'white',
    'class2'=>'',

])
<div class="{{$class}}">
    <a href="{{$href}}" class="card bg-{{$color}} hoverable card-xl-stretch mb-xl-2 {{$class2}}">
        <div class="card-body p-4">

            <div class="text-inverse-{{$color}} text-center fw-bolder fs-2 my-2">{{$title}}</div>
        </div>
        <!--end::Body-->
    </a>
</div>

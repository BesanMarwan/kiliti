<div class="d-flex align-items-center position-relative my-1">

    <input  @if($type=='date')data="has_date_picker" @else type="{{$type?:'text'}}" @endif {{$attributes}} class="form-control form-control-solid w-200px" />

</div>

@extends('layouts.admin')
@section('title',$obj->display_name)
@section('page_title')
    <x-header.title name="لوحة التحكم">
        <x-header.breadcrumb-item :href="route('system.general.index',$module)" :name="$obj->display_name"/>
        <x-header.breadcrumb-item name="اضافة "/>

    </x-header.title>
@endsection
@section('content')

    <x-theme.card>
        <form action="{{route('system.general.create',$module)}}" id="FormSubmit" method="post">
            @csrf

            @php
                $right=[];
                $left=[];
                foreach ($obj->fields as $field_name=>$field){
                    if(in_array($field['type'],['image','icon'])){
                        $left[$field_name]=$field;
                    }else{
                        $right[$field_name]=$field;
                    }
                }
            @endphp
            <div class="row justify-content-center">

                <div class="col-md-{{count($left)?9:12}} row">
                    @foreach ($right as $field_name=>$field)
                       @if($field['type'] == 'translation')
                           <div class="col-md-6">
                               <x-inputs.input :name="$field_name.'_ar'"  type="{{$field['type']}}" :placeholder="$field['title']['ar']" :isrequired="isset($field['rules']) && is_array($field['rules']) && in_array('required',$field['rules'])" :title="$field['title']['ar']"/>
                           </div>
                           <div class="col-md-6">
                               <x-inputs.input :name="$field_name.'_en'"  type="{{$field['type']}}" :isrequired="isset($field['rules']) && is_array($field['rules']) && in_array('required',$field['rules'])" :placeholder="$field['title']['en']" :title="$field['title']['en']"/>
                           </div>
                        @elseif($field['type'] == 'select'||$field['type'] == 'status')
                            <div class="col-md-6">
                            <x-inputs.select :name="$field_name" :title="$field['title']"  :placeholder="$field['title']" :isrequired="isset($field['rules']) && is_array($field['rules']) && in_array('required',$field['rules'])" :options="$field['options']"/>
                            </div>
                        @else
                            <div class="col-md-6">
                                <x-inputs.input :name="$field_name" :type="$field['type']" :isrequired="isset($field['rules']) && is_array($field['rules']) && in_array('required',$field['rules'])"  type="{{$field['type']}}" :placeholder="$field['title']" :title="$field['title']"/>
                            </div>
                        @endif
                    @endforeach
                </div>

                @if(count($left))
                    <div class="col-md-3">
                        @foreach ($left as $field_name=>$field)
                            @if($field['type'] == 'image')
                                <x-inputs.image :name="$field_name"  :title="$field['title']" width="300" height="300"/>

                             @endif
                        @endforeach

                    </div>
                @endif
                <div class="col-md-5">
                    <button class="btn btn-sm w-100 btn-flex justify-content-center btn-light-primary btn-save" data-closemodal="#OpenModal_2">اضافة</button>

                </div>
            </div>
        </form>

    </x-theme.card>


@endsection

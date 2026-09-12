@extends('layouts.admin')
@section('title',$obj->display_name)
@section('page_title')
    <x-header.title name="لوحة التحكم">
        <x-header.breadcrumb-item :name="$obj->display_name"/>
    </x-header.title>
@endsection
@section('search_content')
    <x-search :searchable="$obj->getSearch()"/>
@endsection
@section('content')
    <x-theme.card>

        <x-slot name="toolbar">
            <a  class="btn btn-sm btn-info  mx-2 OpenModal"
                     data-title=" اضافة عنصر جديد"
                     href="{{route('system.general.create',$module)}}"
                     data-size="modal-xl"
                     level="2"
            >
                <span class="svg-icon svg-icon-white svg-icon-x">@svg('lineawesome-plus-solid')</span>
                <span>اضافةعنصر جديد</span>
            </a>
        </x-slot>
        <x-slot name="bulkactions">
            <button type="button" class="btn btn-danger  mx-2 btn-bulk-action"
                    data-url="{{route('system.general.delete',$module)}}" data-token="{{csrf_token()}}">حذف المحدد
            </button>
            @if($obj->has_status)
                <button type="button" class="btn btn-success mx-2 btn-bulk-action"
                        data-url="{{route('system.general.activate',$module)}}" data-token="{{csrf_token()}}">تفعيل المحدد
                </button>
                <button type="button" class="btn btn-warning mx-2 btn-bulk-action"
                        data-url="{{route('system.general.deactivate',$module)}}" data-token="{{csrf_token()}}">تعطيل المحدد
                </button>
            @endif
        </x-slot>
        <x-theme.tables.table>
            <x-slot name="thead">
{{--                <th class="w-10px pe-2">--}}
{{--                    #--}}
{{--                </th>--}}
                <th class="w-10px pe-2">
                    <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                                             value="1"/>
                </th>
                @foreach ($obj->fields as $field_name=>$field)
                    @if(isset($field['show_in_table'])&&$field['show_in_table'])
                        <th class="min-w-50px text-center">{{is_array($field['title'])?$field['title']['ar']:$field['title']}}</th>
                    @endif
                @endforeach
                <th class="text-center min-w-100px">الاعدادات</th>
            </x-slot>
            <x-slot name="tbody">

                @foreach($out as $o)
                    <tr id="TR_{{$o->id}}">
{{--                        <td class="w-10px pe-2">--}}
{{--                            {{$loop->iteration + ($out->currentPage()-1)*$out->perPage()}}--}}
{{--                        </td>--}}
                        <td class="w-10px pe-2">
                            @if($o->can_del())
                            <x-theme.tables.checkbox value="{{$o->id}}"/>
                            @endif
                        </td>
                        @foreach ($obj->fields as $field_name=>$field)
                            @if(isset($field['show_in_table'])&&$field['show_in_table'])
                                @if($field['type']=='image')

                                    <td class="text-center">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <div class="symbol-label">
                                                <img src="{{$o->{$field_name.'_url'} }}"
                                                     alt="{{is_array($field['title'])?$field['title']['ar']:$field['title']}}"
                                                     class="w-100"/>
                                            </div>
                                        </div>
                                    </td>
                                @elseif($field['type']=='translation')
                                    <td class="text-center">
                                        <div class="d-flex flex-column">
                                <span
                                    class="text-gray-800 text-hover-primary mb-1">{{$o->getTranslation($field_name, 'ar')}}</span>
                                            <span>{{$o->getTranslation($field_name, 'en')}}</span>
                                        </div>
                                    </td>
                                @elseif($field['type'] == 'status')
                                    <td class="text-center">
                                        <div
                                            class="badge {{$o->{$field_name} == 'enabled'|| $o->{$field_name} == 1 ?'badge-success':'badge-danger'}} fw-bolder">{{set_if($field['options'][$o->{$field_name}])}}</div>
                                    </td>
                                @elseif($field['type'] == 'select')
                                    <td class="text-center">
                                        <div
                                            class="badge badge-info fw-bolder">{{set_if($field['options'][$o->{$field_name}])}}</div>
                                    </td>
                                @else
                                    <td class="text-center">

                                        {{ $o->{$field_name} }}

                                    </td>
                                @endif
                            @endif
                        @endforeach
                        <td class="text-center">
                            <x-theme.tables.menu title="العمليات">
                                <x-theme.tables.menu-item title="تعديل" class=" OpenModal"
                                                          data-title=" تعديل بيانات عنصر"
                                                          data-size="modal-xl"
                                                          level="2"
                                                          :href="route('system.general.update',['module'=>$module,'id'=>$o->id])"/>
                                @if($obj->has_status)
                                    @if($o->status == 'enabled')
                                        <x-theme.tables.menu-item title="تعطيل" data-table-action="action"
                                                                  data-url="{{route('system.general.deactivate',$module)}}"
                                                                  data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>

                                    @else
                                        <x-theme.tables.menu-item title="تفعيل" data-table-action="action"
                                                                  data-url="{{route('system.general.activate',$module)}}"
                                                                  data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>

                                    @endif
                                @endif

                                @if($o->can_del())
                                    <x-theme.tables.menu-item title="حذف" data-table-action="delete_row"
                                                              data-url="{{route('system.general.delete',$module)}}"
                                                              data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>
                                @endif
                            </x-theme.tables.menu>
                        </td>
                    </tr>
                @endforeach

            </x-slot>
        </x-theme.tables.table>
        {{$out->links()}}
    </x-theme.card>

@endsection

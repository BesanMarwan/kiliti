@extends('layouts.admin')
@section('title',lng('dashboard.users.users'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :name="lng('dashboard.users.users')"/>
    </x-header.title>
@endsection
@section('search_content')
    <x-search :searchable="\App\Models\User::getSearchable()"/>
@endsection
@section('content')
<x-theme.card>

    <x-slot name="bulkactions">
        <button type="button" class="btn btn-danger mx-2 btn-bulk-action"
                data-url="{{route('system.users.delete')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.delete_selected','حذف المحدد')
        </button>
        <button type="button" class="btn btn-success mx-2 btn-bulk-action"
                data-url="{{route('system.users.activate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.activate_selected','تفعيل المحدد')
        </button>
        <button type="button" class="btn btn-warning mx-2 btn-bulk-action"
                data-url="{{route('system.users.deactivate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.deactivate_selected','تعطيل المحدد')
        </button>

    </x-slot>


    <x-theme.tables.table>
        <x-slot name="thead">
            <th class="w-10px pe-2">
                <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                                  />
            </th>
            <th class="">@lng('dashboard.general.image')</th>
            <th class="text-center">@lng('dashboard.general.Name')</th>
            <th class="text-center">@lng('dashboard.general.Mobile')</th>
            <th class="text-center">@lng('dashboard.general.Email')</th>
            <th class="text-center">@lng('dashboard.general.Status','الحالة')</th>
            <th class="text-center">@lng('dashboard.general.created_at','تاريخ الاضافة')</th>
            <th class="text-center">@lng('dashboard.general.last_login','اخر دخول')</th>
            <th class="text-center min-w-100px">@lng('dashboard.general.settings','الاعدادات')</th>
        </x-slot>
        <x-slot name="tbody">

            @forelse($out as $o)
                <tr id="TR_{{$o->id}}">
{{--                    <td class="w-10px pe-2">--}}
{{--                            {{$loop->iteration + ($out->currentPage()-1)*$out->perPage()}}--}}
{{--                        </td>--}}
                    <td class="w-10px pe-2">
                        <x-theme.tables.checkbox value="{{$o->id}}"/>
                    </td>
                    <td class="d-flex align-items-center">
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <div class="symbol-label">
                                    <img src="{{$o->image_url}}" alt="Emma Smith" class="w-100" />
                                </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex flex-column">
                                  <a  data-title="{{lng('dashboard.general.details','التفاصيل')}} "
                                       data-size="modal-xl"
                                       level="3"
                                       href="{{route('system.users.details',$o->id)}}" class="text-gray-800 text-hover-primary mb-1 OpenModal">{{$o->name??'-'}}</a>
                        </div>
                    </td>
                    <td class="text-center">{{$o->mobile_prefix}}</td>
                    <td class="text-center">

                        {{$o->email??'-'}}
                        </td>
                    <td class="text-center">
                        <div
                            class="badge {{$o->status == 'enabled'|| $o->status == 1 ?'badge-success':'badge-danger'}} fw-bolder">{{set_if(\App\Models\User::getSearchable()['status']['options'][$o->status])}}</div>
                    </td>


                    <td class="text-center">
                        <div class="badge {{$o->created_at && $o->created_at->diffInDays() == 0 ?'badge-info':'badge-light'}} fw-bolder">{{$o->created_at?$o->created_at->diffForHumans():'-'}}</div>
                    </td>
                    <td class="text-center">
                        <div class="badge {{$o->last_login && $o->last_login->diffInDays() == 0 ?'badge-info':'badge-light'}} fw-bolder">{{$o->last_login?$o->last_login->diffForHumans():'-'}}</div>
                    </td>


                    <td class="text-center">
                        <x-theme.tables.menu :title="lng('dashboard.general.settings','الاعدادات')">
                            <x-theme.tables.menu-item :title="lng('dashboard.general.details','التفاصيل')"
                                                                                                                    class="OpenModal"
                                                                                                                    data-title="{{lng('dashboard.general.details','التفاصيل')}} "
                                                                                                                    data-size="modal-xl"
                                                                                                                    level="3"
                                                                                                                    :href="route('system.users.details',$o->id)"/>
                               <x-theme.tables.menu-item :title="lng('dashboard.general.send_msg','تعديل')"
                                                           class="OpenModal"
                                                          data-title="{{lng('dashboard.general.send_msg','ارسال رسالة نصية')}} "
                                                          data-size="modal-xl"
                                                          level="2"
                                                          :href="route('system.users.sendMsgView',$o->id)"/>


                        @if($o->status =='not_verified' || $o->status == 'disabled')
                                <x-theme.tables.menu-item :title="lng('dashboard.general.activate')" data-table-action="action" data-url="{{route('system.users.activate')}}" data-token="{{csrf_token()}}" data-id="{{$o->id}}" />
                            @else
                                <x-theme.tables.menu-item :title="lng('dashboard.general.deactivate')" data-table-action="action" data-url="{{route('system.users.deactivate')}}" data-token="{{csrf_token()}}" data-id="{{$o->id}}" />
                            @endif
                                <x-theme.tables.menu-item :title="lng('dashboard.general.delete')" data-table-action="delete_row" data-url="{{route('system.users.delete')}}" data-token="{{csrf_token()}}" data-id="{{$o->id}}" />
                        </x-theme.tables.menu>
                    </td>
                </tr>
            @empty
                <tr id="TR_0">

                    <td colspan="15" class="text-center text-muted">
                      لا يوجد نتائج
                    </td>
                </tr>
            @endforelse

        </x-slot>
    </x-theme.tables.table>
    {{$out->links()}}
</x-theme.card>



@endsection

@extends('layouts.admin')
@section('title',lng('dashboard.dialysis_sessions.dialysis_sessions','جلسات الغسيل'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :name="lng('dashboard.dialysis_sessions.dialysis_sessions','جلسات الغسيل')"/>
    </x-header.title>
@endsection
@push('css')

@endpush
@section('search_content')
    <x-search :searchable="\App\Models\DialysisSession::getSearchable()"/>
@endsection
@section('content')
    <x-theme.card>
        <x-slot name="toolbar">
            <a  class="btn btn-sm btn-info  mx-2"
                data-title=" اضافة جلسة غسيل "
                href="{{route('system.dialysis_sessions.create')}}"

            >
                <span class="svg-icon svg-icon-white svg-icon-x">@svg('lineawesome-plus-solid')</span>
                <span>{{lng('dashboard.dialysis_sessions.add_session','اضافة جلسة غسيل')}}</span>
            </a>
        </x-slot>
        <x-slot name="bulkactions">
            <button type="button" class="btn btn-danger mx-2 btn-bulk-action"
                    data-url="{{route('system.medications.delete')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.delete_selected','حذف المحدد')
            </button>
            <button type="button" class="btn btn-success mx-2 btn-bulk-action"
                    data-url="{{route('system.medications.activate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.activate_selected','تفعيل المحدد')
            </button>
            <button type="button" class="btn btn-warning mx-2 btn-bulk-action"
                    data-url="{{route('system.medications.deactivate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.deactivate_selected','تعطيل المحدد')
            </button>
        </x-slot>
        <x-theme.tables.table>
            <x-slot name="thead">
                <th class="w-10px pe-2">
                    <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                                             value="1"/>
                </th>
                <th class="">@lng('dashboard.sessions.center','اسم المركز')</th>
                <th class="text-center">@lng('dashboard.session.patient_name','المريض')</th>
                <th class="text-center">@lng('dashboard.session.doctor','الدكتور')</th>
                <th class="text-center">@lng('dashboard.session.session_type','نوع الجلسة')</th>
                <th class="text-center">@lng('dashboard.session.scheduled_at','موعد الجلسة')</th>
                <th class="text-center">@lng('dashboard.general.status')</th>
                <th class="text-center min-w-100px">@lng('dashboard.general.settings','الاعدادات')</th>
            </x-slot>
            <x-slot name="tbody">

                @forelse($out as $o)
                    <tr id="TR_{{$o->id}}">
                        <td class="w-10px pe-2"> <x-theme.tables.checkbox value="{{$o->id}}"/></td>
                        <td class="d-flex align-items-center">
                            {{@$o->center->name ?? '-'}}

                        </td>
                        <td class="text-center">
                            <div class="d-flex flex-column">
                               {{@$o->patient->user->name ?? '-'}}
                            </div>
                        </td>

                        <td class="text-center">
                           {{@$o->doctor->user->name}}
                        </td>

                        <td class="text-center">
                            {{@$o->session_type_title}}
                        </td>

                        <td class="text-center">
                            {{@$o->scheduled_at->format('Y-m-d')}}
                        </td>


                        <td class="text-center">
                            <div
                                class="badge {{$o->status_color}} fw-bolder">{{$o->status_title}}</div>

                        </td>



                        <td class="text-center">
                            <x-theme.tables.menu :title="lng('dashboard.general.settings','الاعدادات')">
                                @if($o->status == 'scheduled')
                                <x-theme.tables.menu-item :title="lng('dashboard.general.edit','تعديل')"
                                                          class="OpenModal"
                                                          data-title="{{lng('dashboard.general.edit_medication','تعديل بيانات الدواء')}} "
                                                          data-size="modal-xl"
                                                          level="2"
                                                          :href="route('system.medications.update',$o->id)"/>
                                @endif

                                @if($o->status == 'enabled')
                                    <x-theme.tables.menu-item :title="lng('dashboard.general.deactivate','تعطيل')" data-table-action="action"
                                      data-url="{{route('system.medications.deactivate')}}"
                                      data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>

                            @else
                                <x-theme.tables.menu-item :title="lng('dashboard.general.activate','تفعيل')" data-table-action="action"
                                                          data-url="{{route('system.medications.activate')}}"
                                                          data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>

                            @endif
                                    <x-theme.tables.menu-item :title="lng('dashboard.general.delete','حذف')" data-table-action="delete_row"
                                                              data-url="{{route('system.medications.delete')}}"
                                                              data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>
                                                           </x-theme.tables.menu>
                        </td>
                    </tr>
                @empty
                    <tr id="TR_0">

                        <td colspan="15" class="text-center text-muted">
                            @lng('dashboard.general.no_data','لا يوجد نتائج')

                        </td>
                    </tr>
                @endforelse

            </x-slot>
        </x-theme.tables.table>
        {{$out->links()}}
    </x-theme.card>

@endsection

@extends('layouts.admin')
@section('title',lng('dashboard.medications.patient_medications','إدارة أدوية المرضى'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :name="lng('dashboard.medications.patient_medications','إدارة أدوية المرضى')"/>
    </x-header.title>
@endsection
@push('css')

@endpush
@section('search_content')
    <x-search :searchable="\App\Models\PatientMedication::getSearchable()"/>
@endsection
@section('content')
    <x-theme.card>
        <x-slot name="toolbar">
            <a  class="btn btn-sm btn-info  mx-2 OpenModal"
                data-title=" اضافة دواء عام جديد"
                href="{{route('system.patient_medications.create')}}"
                data-size="modal-xl"
                level="2"
            >
                <span class="svg-icon svg-icon-white svg-icon-x">@svg('lineawesome-plus-solid')</span>
                <span>{{lng('dashboard.patient_medications.add_medication','اضافة دواء لمريض')}}</span>
            </a>
        </x-slot>
        <x-slot name="bulkactions">
            <button type="button" class="btn btn-danger mx-2 btn-bulk-action"
                    data-url="{{route('system.patient_medications.stopped')}}" data-token="{{csrf_token()}}">@lng('dashboard.patient_medications.stopped_selected','إيقاف المحدد')
            </button>

            <button type="button" class="btn btn-success mx-2 btn-bulk-action"
                    data-url="{{route('system.patient_medications.activate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.activate','تفعيل المحدد')
            </button>
        </x-slot>
        <x-theme.tables.table>
            <x-slot name="thead">
                <th class="w-10px pe-2">
                    <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                                             value="1"/>
                </th>
                <th class="">@lng('dashboard.patient_medication.patient','المريض')</th>
                <th class="text-center">@lng('dashboard.patient_medication.medication','الدواء')</th>
                <th class="text-center">@lng('dashboard.patient_medication.doctor','الطبيب')</th>
                <th class="text-center">@lng('dashboard.patient_medication.frequency','عدد الجرعات')</th>
                <th class="text-center">@lng('dashboard.patient_medication.start_date','بداية العلاج')</th>
                <th class="text-center">@lng('dashboard.patient_medication.end_date','نهاية العلاج')</th>
                <th class="text-center">@lng('dashboard.general.status')</th>
                <th class="text-center min-w-100px">@lng('dashboard.general.settings','الاعدادات')</th>
            </x-slot>
            <x-slot name="tbody">

                @forelse($out as $o)
                    <tr id="TR_{{$o->id}}">
                        <td class="w-10px pe-2"> <x-theme.tables.checkbox value="{{$o->id}}"/></td>
                        <td class="">
                                <span class="text-gray-800 text-hover-primary mb-1">{{$o->patient->user->name??'-'}}</span>
                        </td>

                        <td class="text-center">
                            <div class="d-flex flex-column">
                                <span class="text-gray-800 ">{{$o->medication->name??'-'}}</span>
                            </div>
                        </td>

                        <td class="text-center">
                            <div class="d-flex flex-column">
                                <span class="text-gray-800 ">{{$o->doctor->user->name??'-'}}</span>
                            </div>
                        </td>

                        <td class="text-center">
                            <div class="d-flex flex-column">
                                <span class="text-gray-800 ">{{$o->frequency?->label()}}</span>
                            </div>
                        </td>

                        <td class="text-center">
                            <div class="d-flex flex-column">
                               {{$o->start_date->format('Y-m-d')}}
                            </div>
                        </td>

                        <td class="text-center">
                            <div class="d-flex flex-column">
                                {{$o->end_date?->format('Y-m-d')}}
                            </div>
                        </td>



                        <td class="text-center">
                            <div
                                class="badge {{$o->status_color}} fw-bolder">{{$o->status_title}}</div>

                        </td>



                        <td class="text-center">
                            <x-theme.tables.menu :title="lng('dashboard.general.settings','الاعدادات')">
                                <x-theme.tables.menu-item :title="lng('dashboard.general.edit','تعديل')"
                                                          class="OpenModal"
                                                          data-title="{{lng('dashboard.general.edit_medication','تعديل بيانات الدواء')}} "
                                                          data-size="modal-xl"
                                                          level="2"
                                                          :href="route('system.medications.update',$o->id)"/>

                                @if($o->status == 'active')

                                    <x-theme.tables.menu-item :title="lng('dashboard.general.stopped','إيقاف الدواء')" data-table-action="action"
                                                              data-url="{{route('system.patient_medications.stopped')}}"
                                                              data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>

                                @endif

                              @if($o->status == 'stopped')

                                <x-theme.tables.menu-item :title="lng('dashboard.general.activate','تفعيل')" data-table-action="action"
                                                          data-url="{{route('system.patient_medications.activate')}}"
                                                          data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>

                                @endif
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

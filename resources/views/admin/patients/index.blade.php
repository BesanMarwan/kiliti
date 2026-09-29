@extends('layouts.admin')
@section('title',lng('dashboard.patients.patients','المرضى'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :name="lng('dashboard.patients.patients','المرضى')"/>
    </x-header.title>
@endsection
@section('search_content')
    <x-search :searchable="\App\Models\DialysisCenter::getSearchable()"/>
@endsection
@section('content')
<x-theme.card>

{{--    <x-slot name="toolbar">--}}
{{--        <a  class="btn btn-sm btn-info  mx-2 OpenModal"--}}
{{--            data-title=" {{lng('admin.centers.add','اضافة مركز جديد')}}"--}}
{{--            href="{{route('system.centers.create')}}"--}}
{{--            data-size="modal-xl"--}}
{{--            level="2"--}}
{{--        >--}}
{{--            <span class="svg-icon svg-icon-white svg-icon-x">@svg('lineawesome-plus-solid')</span>--}}
{{--            <span>{{lng('admin.centers.add','اضافة مركز جديد')}}</span>--}}
{{--        </a>--}}
{{--    </x-slot>--}}

    <x-slot name="bulkactions">
        <button type="button" class="btn btn-danger mx-2 btn-bulk-action"
                data-url="{{route('system.patients.delete')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.delete_selected','حذف المحدد')
        </button>
        <button type="button" class="btn btn-success mx-2 btn-bulk-action"
                data-url="{{route('system.patients.activate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.activate_selected','تفعيل المحدد')
        </button>
        <button type="button" class="btn btn-warning mx-2 btn-bulk-action"
                data-url="{{route('system.patients.deactivate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.deactivate_selected','تعطيل المحدد')
        </button>

    </x-slot>


    <x-theme.tables.table>
        <x-slot name="thead">
            <th class="w-10px pe-2">
                <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                                  />
            </th>
            <th class="">@lng('dashboard.general.image')</th>
            <th class="text-center">@lng('dashboard.patients.Name','الاسم')</th>
            <th class="text-center">@lng('dashboard.general.Mobile')</th>
            <th class="text-center">@lng('dashboard.centers.gender','الجنس')</th>
            <th class="text-center">@lng('dashboard.centers.date_of_birth','تاريخ الميلاد')</th>
            <th class="text-center">@lng('dashboard.centers.blood_type','فصيلة الدم')</th>
            <th class="text-center">@lng('dashboard.centers.kidney_disease_type','نوع الغسيل')</th>
            <th class="text-center">@lng('dashboard.general.Status','الحالة')</th>
            <th class="text-center">@lng('dashboard.general.created_at','تاريخ الاضافة')</th>
            <th class="text-center min-w-100px">@lng('dashboard.general.settings','الاعدادات')</th>
        </x-slot>
        <x-slot name="tbody">

            @forelse($patients  as $user)
                <tr id="TR_{{$user->id}}">
{{--                    <td class="w-10px pe-2">--}}
{{--                            {{$loop->iteration + ($out->currentPage()-1)*$out->perPage()}}--}}
{{--                        </td>--}}
                    <td class="w-10px pe-2">
                        <x-theme.tables.checkbox value="{{$user->id}}"/>
                    </td>
                    <td class="d-flex align-items-center">
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                            <div class="symbol-label">
                                <img src="{{$user->image_url}}" alt="Emma Smith" class="w-100" />
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex flex-column">
                                  <a  data-title="{{lng('dashboard.general.details','التفاصيل')}} "
                                       data-size="modal-xl"
                                       level="3"
                                       href="{{route('system.users.details',$user->id)}}" class="text-gray-800 text-hover-primary mb-1 OpenModal">{{$user->name??'-'}}</a>


                        </div>
                    </td>
                    <td class="text-center">{{$user->mobile}}</td>
                    <td class="text-center">{{$user->patient->gender_title}}</td>
                    <td class="text-center">{{$user->patient->date_of_birth->format('Y-m-d')}}</td>
                    <td class="text-center">{{$user->patient->blood_type}}</td>
                    <td class="text-center">{{$user->patient->kidney_disease_type}}</td>
                    <td class="text-center">
                        <div
                            class="badge {{$user->status_color}} fw-bolder">{{$user->status_title}}</div>
                    </td>


                    <td class="text-center">
                        <div class="badge {{$user->created_at && $user->created_at->diffInDays() == 0 ?'badge-info':'badge-light'}} fw-bolder">{{$user->created_at?$user->created_at->diffForHumans():'-'}}</div>
                    </td>


                    <td class="text-center">
                        <x-theme.tables.menu :title="lng('dashboard.general.settings','الاعدادات')">
                            <x-theme.tables.menu-item :title="lng('dashboard.general.details','التفاصيل')"/>

                            <x-theme.tables.menu-item :title="lng('dashboard.general.edit')" class=" OpenModal"
                                                      data-title="{{lng('dashboard.ceters.edit','تعديل بيانات المركز')}}"
                                                      data-size="modal-xl"
                                                      level="2"
                                                      :href="route('system.centers.update',['id'=>$user->id])"/>
                         @if($user->status =='not_verified' || $user->status == 'disabled')
                                <x-theme.tables.menu-item :title="lng('dashboard.general.activate')" data-table-action="action" data-url="{{route('system.centers.activate')}}" data-token="{{csrf_token()}}" data-id="{{$user->id}}" />
                            @else
                                <x-theme.tables.menu-item :title="lng('dashboard.general.deactivate')" data-table-action="action" data-url="{{route('system.centers.deactivate')}}" data-token="{{csrf_token()}}" data-id="{{$user->id}}" />
                                <x-theme.tables.menu-item :title="lng('dashboard.general.temporarily_closed','ايقاف مؤقتا')" data-table-action="action" data-url="{{route('system.centers.temporarily_closed')}}" data-token="{{csrf_token()}}" data-id="{{$user->id}}" />
                            @endif
{{--                                <x-theme.tables.menu-item :title="lng('dashboard.general.delete')" data-table-action="delete_row" data-url="{{route('system.users.delete')}}" data-token="{{csrf_token()}}" data-id="{{$user->id}}" />--}}
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
    {{$patients ->links()}}
</x-theme.card>



@endsection

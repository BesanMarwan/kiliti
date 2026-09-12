@extends('layouts.admin')
@section('title',lng('dashboard.services.services','الخدمات'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :name="lng('dashboard.services.services','الخدمات')"/>
    </x-header.title>
@endsection
@push('css')

@endpush
@section('search_content')
    <x-search :searchable="\App\Models\Service::getSearchable()"/>
@endsection
@section('content')
    <x-theme.card>
        <x-slot name="toolbar">
            <x-theme.button type="openmodal"  class="btn btn-sm btn-flex btn-light-primary mx-2"
                            :modaltitle="lng('dashboard.services.add_service_title','اضافة خدمة جديدة')"
                            modalsize="modal-xl"
                            modallevel="2"
                href="{{route('system.services.create')}}">
                <span class="svg-icon svg-icon-white svg-icon-x">@svg('lineawesome-plus-solid')</span>
                <span>@lng('dashboard.services.add_service_title','اضافة خدمة جديدة')</span>
            </x-theme.button>
        </x-slot>
        <x-slot name="bulkactions">
            <button type="button" class="btn btn-danger mx-2 btn-bulk-action"
                    data-url="{{route('system.services.delete')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.delete_selected','حذف المحدد')
            </button>
            <button type="button" class="btn btn-success mx-2 btn-bulk-action"
                    data-url="{{route('system.services.activate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.activate_selected','تفعيل المحدد')
            </button>
            <button type="button" class="btn btn-warning mx-2 btn-bulk-action"
                    data-url="{{route('system.services.deactivate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.deactivate_selected','تعطيل المحدد')
            </button>
        </x-slot>
        <x-theme.tables.table>
            <x-slot name="thead">
                <th class="w-10px pe-2">
                    #
                </th>
                <th class="w-10px pe-2">
                    <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                                             value="1"/>
                </th>
                <th class="">@lng('dashboard.general.name')</th>
                <th class="">@lng('dashboard.services.category')</th>
                <th class="">@lng('dashboard.general.price')</th>
                <th class="">@lng('dashboard.general.status')</th>
                <th class="text-end min-w-100px">@lng('dashboard.general.settings','الاعدادات')</th>
            </x-slot>
            <x-slot name="tbody">

                @forelse($out as $o)
                    <tr id="TR_{{$o->id}}">
                        <td class="w-10px pe-2">
                            {{$loop->iteration + ($out->currentPage()-1)*$out->perPage()}}
                        </td>
                        <td class="w-10px pe-2"> <x-theme.tables.checkbox value="{{$o->id}}"/></td>
                        <td class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <div class="symbol-label">
                                    <img src="{{$o->image_url}}" alt="Emma Smith" class="w-100" />
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a  data-title="{{lng('dashboard.general.details','التفاصيل')}} "
                                       data-size="modal-xl"
                                       level="3"
                                       href="{{route('system.services.show',$o->id)}}" class="text-gray-800 text-hover-primary mb-1 OpenModal">{{$o->name??'-'}}</a>
                            </div>
                        </td>

                        <td class="">{{@$o->category->name}}  </td>

                        <td class="">
                           {{$o->price}} {{currency()}}
                        </td>
                        <td class="">
                            <div
                                class="badge {{$o->status == 'enabled' ?'badge-success':'badge-danger'}} fw-bolder">{{$o->status == 'enabled' ?lng('dashboard.general.status_enabled','فعال'):lng('dashboard.general.status_disabled','معطل')}}</div>

                        </td>



                        <td class="text-end">
                            <x-theme.tables.menu :title="lng('dashboard.general.settings','الاعدادات')">
                                <x-theme.tables.menu-item :title="lng('dashboard.general.details','التفاصيل')"
                                                          class="OpenModal"
                                                          data-title="{{lng('dashboard.general.details','التفاصيل')}} "
                                                          data-size="modal-xl"
                                                          level="3"
                                                          :href="route('system.services.show',$o->id)"/>
                                <x-theme.tables.menu-item :title="lng('dashboard.general.edit','تعديل')"
                                                          class="OpenModal"
                                                          data-title="{{lng('dashboard.general.edit','تعديل')}} "
                                                          data-size="modal-xl"
                                                          level="2"
                                                          :href="route('system.services.update',$o->id)"/>

                                @if($o->status == 'enabled')
                                    <x-theme.tables.menu-item :title="lng('dashboard.general.deactivate','تعطيل')" data-table-action="action"
                                      data-url="{{route('system.services.deactivate')}}"
                                      data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>

                            @else
                                <x-theme.tables.menu-item :title="lng('dashboard.general.activate','تفعيل')" data-table-action="action"
                                                          data-url="{{route('system.services.activate')}}"
                                                          data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>

                            @endif
                                    <x-theme.tables.menu-item :title="lng('dashboard.general.delete','حذف')" data-table-action="delete_row"
                                                              data-url="{{route('system.services.delete')}}"
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

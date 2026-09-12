@extends('layouts.admin')
@section('title',lng('dashboard.categories.categories','الأقسام المتاحة'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :name="lng('dashboard.catgeories.categories','الأقسام المتاحة')"/>
    </x-header.title>
@endsection
@push('css')

@endpush
@section('search_content')
    <x-search :searchable="\App\Models\Category::getSearchable()"/>
@endsection
@section('content')
    <x-theme.card>
        <x-slot name="toolbar">
            <a  class="btn btn-sm btn-info  mx-2 OpenModal"
                data-title=" اضافة قسم جديد"
                href="{{route('system.categories.create')}}"
                data-size="modal-xl"
                level="2"
            >
                <span class="svg-icon svg-icon-white svg-icon-x">@svg('lineawesome-plus-solid')</span>
                <span>{{__('dashboard.categories.add_category')}}</span>
            </a>
        </x-slot>
        <x-slot name="bulkactions">
            <button type="button" class="btn btn-danger mx-2 btn-bulk-action"
                    data-url="{{route('system.categories.delete')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.delete_selected','حذف المحدد')
            </button>
            <button type="button" class="btn btn-success mx-2 btn-bulk-action"
                    data-url="{{route('system.categories.activate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.activate_selected','تفعيل المحدد')
            </button>
            <button type="button" class="btn btn-warning mx-2 btn-bulk-action"
                    data-url="{{route('system.categories.deactivate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.deactivate_selected','تعطيل المحدد')
            </button>
        </x-slot>
        <x-theme.tables.table>
            <x-slot name="thead">
                <th class="w-10px pe-2">
                    <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                                             value="1"/>
                </th>
                <th class="">@lng('dashboard.general.image')</th>
                <th class="text-center">@lng('dashboard.general.name')</th>
                <th class="text-center">@lng('dashboard.general.status')</th>
                <th class="text-center min-w-100px">@lng('dashboard.general.settings','الاعدادات')</th>
            </x-slot>
            <x-slot name="tbody">

                @forelse($out as $o)
                    <tr id="TR_{{$o->id}}">
                        <td class="w-10px pe-2"> <x-theme.tables.checkbox value="{{$o->id}}"/></td>
                        <td class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <div class="symbol-label">
                                    <img src="{{$o->image_url}}" alt="Emma Smith" class="w-100" />
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex flex-column">
                                <span class="text-gray-800 text-hover-primary mb-1">{{$o->getTranslation('name','ar')??'-'}}</span>
                                <span>{{$o->getTranslation('name','en')}}</span>
                            </div>
                        </td>


                        <td class="text-center">
                            <div
                                class="badge {{$o->status == 'enabled' ?'badge-success':'badge-danger'}} fw-bolder">{{$o->status == 'enabled' ?lng('dashboard.general.status_enabled','فعال'):lng('dashboard.general.status_disabled','معطل')}}</div>

                        </td>



                        <td class="text-center">
                            <x-theme.tables.menu :title="lng('dashboard.general.settings','الاعدادات')">
                                <x-theme.tables.menu-item :title="lng('dashboard.general.edit','تعديل')"
                                                          class="OpenModal"
                                                          data-title="{{lng('dashboard.general.edit_catgeory','تعديل بيانات قسم')}} "
                                                          data-size="modal-xl"
                                                          level="2"
                                                          :href="route('system.categories.update',$o->id)"/>

                                @if($o->status == 'enabled')
                                    <x-theme.tables.menu-item :title="lng('dashboard.general.deactivate','تعطيل')" data-table-action="action"
                                      data-url="{{route('system.categories.deactivate')}}"
                                      data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>

                            @else
                                <x-theme.tables.menu-item :title="lng('dashboard.general.activate','تفعيل')" data-table-action="action"
                                                          data-url="{{route('system.categories.activate')}}"
                                                          data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>

                            @endif
                                    <x-theme.tables.menu-item :title="lng('dashboard.general.delete','حذف')" data-table-action="delete_row"
                                                              data-url="{{route('system.categories.delete')}}"
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

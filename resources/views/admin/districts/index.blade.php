@extends('layouts.admin')
@section('title',lng('dashboard.districts.districts','الأحياء'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :name="lng('dashboard.districts.districts','الأحياء')"/>
    </x-header.title>
@endsection
@push('css')

@endpush
@section('search_content')
    <x-search :searchable="\App\Models\City::getSearchDistrict()"/>
@endsection
@section('content')
    <x-theme.card>
        <x-slot name="toolbar">
            <a  class="btn btn-sm btn-info  mx-2 OpenModal"
                data-title="{{lng('dashboard.areas.create_district','اضافة حي جديد')}}"
                href="{{route('system.districts.create')}}"
                data-size="modal-xl"
                level="2"
            >
                <span class="svg-icon svg-icon-white svg-icon-x">@svg('lineawesome-plus-solid')</span>
                <span>@lng('dashboard.areas.create_district','اضافة حي جديد')</span>
            </a>
        </x-slot>
        <x-slot name="bulkactions">
            <button type="button" class="btn btn-danger mx-2 btn-bulk-action"
                    data-url="{{route('system.areas.delete')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.delete_selected','حذف المحدد')
            </button>
            <button type="button" class="btn btn-success mx-2 btn-bulk-action"
                    data-url="{{route('system.areas.activate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.activate_selected','تفعيل المحدد')
            </button>
            <button type="button" class="btn btn-warning mx-2 btn-bulk-action"
                    data-url="{{route('system.areas.deactivate')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.deactivate_selected','تعطيل المحدد')
            </button>
        </x-slot>
        <x-theme.tables.table>
            <x-slot name="thead">
                <th class="w-10px pe-2">
                    <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                                             />
                </th>
                <th class="text-center">@lng('dashboard.general.name')</th>
                <th class="text-center">@lng('dashboard.general.area_name','المنطقة')</th>
                <th class="text-center">@lng('dashboard.general.city_name','المدينة')</th>
                <th class="text-center">@lng('dashboard.general.status')</th>
                <th class="text-center min-w-100px">@lng('dashboard.general.settings','الاعدادات')</th>
            </x-slot>
            <x-slot name="tbody">

                @forelse($out as $o)
                    <tr id="TR_{{$o->id}}">
                        <td class="w-10px pe-2">
                            @if($o->can_del())
                            <x-theme.tables.checkbox value="{{$o->id}}"/>
                                @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex flex-column">
                                <span class="text-gray-800 text-hover-primary mb-1">{{$o->getTranslation('name','ar')??'-'}}</span>
                                <span>{{$o->getTranslation('name','en')}}</span>
                            </div>
                        </td>


                        <td class="text-center">
                            <a  data-title="{{lng('dashboard.general.cities','عرض مدن المنطقة ')}} "
                                data-size="modal-xl"
                                level="3"
                                href="{{route('system.areas.cities',$o->parent->parent->id)}}" class="text-gray-800 text-hover-primary mb-1 OpenModal">
                                {{@$o->parent->parent->name}}
                            </a>
                        </td>


                        <td class="text-center">
                            <a  data-title="{{lng('dashboard.general.districts','عرض أحياء المدينة ')}} "
                                data-size="modal-xl"
                                level="3"
                                href="{{route('system.cities.districts',$o->parent_id)}}" class="text-gray-800 text-hover-primary mb-1 OpenModal">
                                {{@$o->parent->name}}
                            </a>
                        </td>

                        <td class="text-center">
                            <div
                                class="badge {{$o->status == 'enabled' ?'badge-success':'badge-danger'}} fw-bolder">{{$o->status == 'enabled' ?lng('dashboard.general.status_enabled','فعال'):lng('dashboard.general.status_disabled','معطل')}}</div>

                        </td>

                        <td class="text-center">
                            <x-theme.tables.menu :title="lng('dashboard.general.settings','الاعدادات')">
                                <x-theme.tables.menu-item :title="lng('dashboard.general.edit','تعديل')"
                                                          class="OpenModal"
                                                          data-title="{{lng('dashboard.general.edit_district','تعديل بيانات حي')}} "
                                                          data-size="modal-xl"
                                                          level="2"
                                                          :href="route('system.districts.update',$o->id)"/>

                                @if($o->status == 'enabled')
                                    @if($o->can_del())
                                    <x-theme.tables.menu-item :title="lng('dashboard.general.deactivate','تعطيل')" data-table-action="action"
                                      data-url="{{route('system.areas.deactivate')}}"
                                      data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>
                                        @endif

                            @else
                                <x-theme.tables.menu-item :title="lng('dashboard.general.activate','تفعيل')" data-table-action="action"
                                                          data-url="{{route('system.areas.activate')}}"
                                                          data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>

                            @endif
                                @if($o->can_del())
                                    <x-theme.tables.menu-item :title="lng('dashboard.general.delete','حذف')" data-table-action="delete_row"
                                                              data-url="{{route('system.areas.delete')}}"
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
@push('js')
    <script>

        $('#area_id').on('change', function () {

            var id = this.value;
            $.get('/cms/admin/areas/show-cities/' + id, function (data) {
                console.log(data);
                $('#parent_id').html('');

                if (data.data.length > 0) {
                    $('#parent_id').html('');
                    $('#parent_id').append('<option>المدينة</option>');
                    $.each(data.data, function (index, value) {
                        $('#parent_id').append("<option value='" + value.id + "'>" + value.name + "</option>");
                    });
                    $('#city_id').trigger("change");

                }
            })
        });

    </script>

@endpush

@extends('layouts.admin')
@section('title',lng('dashboard.general.roles','الصلاحيات'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :name="lng('dashboard.general.roles','الصلاحيات')"/>

    </x-header.title>
@endsection
@section('search_content')
    <x-search :searchable="App\Models\Role::getSearchable()"/>
@endsection
@section('content')
    <x-theme.card>

        <x-slot name="toolbar">
            <a  class="btn btn-sm btn-info  mx-2"
                data-title="@lng('dashboard.roles.add_new_role','اضافة صلاحية جديدة')"
                href="{{route('system.roles.create')}}"
                data-size="modal-xl"
                level="2"
            >
                <span class="svg-icon svg-icon-white svg-icon-x">@svg('lineawesome-plus-solid')</span>
                <span>@lng('dashboard.roles.add_new_role','اضافة صلاحية جديدة')</span>
            </a>
        </x-slot>

        <x-slot name="bulkactions">
            <button type="button" class="btn btn-danger mx-2 btn-bulk-action"
                    data-url="{{route('system.roles.delete')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.delete_selected','حذف المحدد')
            </button>

        </x-slot>
        <x-theme.tables.table>
            <x-slot name="thead">
                <th class="w-10px pe-2">

                    <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                    />
                </th>
                <th class="min-w-125px text-center">@lng('dashboard.roles.role_name','اسم الصلاحية')</th>
                <th class="text-center d-block mx-12">@lng('dashboard.general.settings','الاعدادات')</th>
            </x-slot>
            <x-slot name="tbody">

                @forelse($out as $o)
                    <tr>
                        <td class="w-10px pe-2">
                            @if($o->can_del())
                            <x-theme.tables.checkbox value="{{$o->id}}"/>
                                @endif
                        </td>
                        <td class="min-w-125px text-center">{{$o->name}}</td>
                        <td class="text-center">
                            <x-theme.tables.menu :title="lng('dashboard.general.settings','الاعدادات')">
                                <x-theme.tables.menu-item :title="lng('dashboard.general.edit','تعديل')" :href="route('system.roles.update',$o->id)"/>
                                @if($o->can_del())
                                <x-theme.tables.menu-item :title="lng('dashboard.general.delete','حذف')" data-table-action="delete_row" data-url="{{route('system.roles.delete')}}" data-token="{{csrf_token()}}" data-id="{{$o->id}}" />
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
    </x-theme.card>



@endsection

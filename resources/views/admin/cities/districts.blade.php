@extends('layouts.admin')
@section('title',lng('dashboard.areas.create_city','اضافة مدينة'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :href="route('system.cities.index')" :name="lng('dashboard.cities.cities','المدن')"/>
        <x-header.breadcrumb-item  :name="lng('dashboard.cities.show_districts','عرض أحياء المدن')"/>
    </x-header.title>
@endsection
@push('css')

@endpush

@section('content')
    <x-theme.card>

        <x-theme.tables.table>
            <x-slot name="thead">
                <th class="w-10px pe-2">
                  #
                </th>
                <th class="text-center">@lng('dashboard.general.name')</th>
                <th class="text-center">@lng('dashboard.general.status')</th>
            </x-slot>
            <x-slot name="tbody">

                @forelse($city->children as $o)
                    <tr id="TR_{{$o->id}}">
                        <td class="w-10px pe-2">
                           {{$loop->iteration}}
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

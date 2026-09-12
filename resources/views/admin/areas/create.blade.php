@extends('layouts.admin')
@section('title',lng('dashboard.areas.create_areas','اضافة منطقة'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :href="route('system.areas.index')" :name="lng('dashboard.areas.areas','المناطق')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.areas.create_areas')"/>
    </x-header.title>
@endsection

@section('content')
    <x-theme.card>
        <form action="{{route('system.areas.store')}}" id="FormSubmit" method="post">
            @csrf
            <div class="row justify-content-center">

                        <div class="col-md-6">
                            <x-inputs.input name="name_ar" required :title="lng('dashboard.general.name_ar','الاسم')"/>
                        </div>
                        <div class="col-md-6">
                            <x-inputs.input name="name_en" required :title="lng('dashboard.general.name_en','Name')"/>
                        </div>
                <div class="w-100"></div>
                <div class="col-md-5">
                    <x-button class="w-100 btn-save" data-closemodal="#OpenModal_2">
                        <span class="svg-icon svg-icon-2"><x-lineawesome-check-solid/></span>@lng('dashboard.general.add','اضافة')

                    </x-button>
                </div>
            </div>
        </form>
    </x-theme.card>

@endsection
@push('js')


@endpush

@extends('layouts.admin')
@section('title',lng('dashboard.services.create_service','ضافة خدمة'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :href="route('system.services.index')" :name="lng('dashboard.services.services','الخدمات')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.services.create_service')"/>
    </x-header.title>
@endsection

@section('content')
    <x-theme.card>
        <form action="{{route('system.services.create')}}" id="FormSubmit" method="post">
            @csrf
            <div class="row justify-content-center">

                <div class="col-md-9">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <x-inputs.input name="name_ar" required :title="lng('dashboard.general.name_ar','الاسم بالعربية')"/>
                        </div>
                        <div class="col-md-6">
                            <x-inputs.input name="name_en" required :title="lng('dashboard.general.name_en','الاسم بالانجليزية')"/>
                        </div>
                        <div class="col-md-6">
                            <x-inputs.select :options="$categories" name="service_category_id" required :title="lng('dashboard.services.category')"/>
                        </div>
                        <div class="col-md-6">
                            <x-inputs.input name="price" required :title="lng('dashboard.general.price','السعر')"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <x-inputs.image name="image"  :title="lng('dashboard.general.image','الصورة')" width="300" height="300"/>

                </div>

                <div class="col-md-6">
                    <x-inputs.area name="ingredients_ar"  :title="lng('dashboard.services.ingredients_ar','المكونات')"/>
                </div>

                <div class="col-md-6">
                    <x-inputs.area name="ingredients_en"  :title="lng('dashboard.services.ingredients_en',' المكونات بالانجليزية')"/>
                </div>

                <div class="col-md-6">
                    <x-inputs.area name="nutrition_facts_ar"  :title="lng('dashboard.services.nutrition_facts_ar','القيمة الغذائية')"/>
                </div>

                <div class="col-md-6">
                    <x-inputs.area name="nutrition_facts_en"  :title="lng('dashboard.services.nutrition_facts_en',' القيمة الغذائية بالانجليزية')"/>
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

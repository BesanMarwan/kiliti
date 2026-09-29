@extends('layouts.admin')
@section('title',lng('dashboard.services.edit_service','تعديل بيانات خدمة'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :href="route('system.services.index')" :name="lng('dashboard.services.services','الخدمات')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.general.details')"/>
    </x-header.title>
@endsection

@section('content')
    <x-theme.card>
            <div class="row justify-content-center">

                <div class="col-md-9">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <x-inputs.inputext name="name_ar" required :value="$service->getTranslation('name','ar')" :title="lng('dashboard.general.name_ar','الاسم بالعربية')"/>
                        </div>
                        <div class="col-md-6">
                            <x-inputs.inputext name="name_en" required :value="$service->getTranslation('name','en')" :title="lng('dashboard.general.name_en','الاسم بالانجليزية')"/>
                        </div>
                        <div class="col-md-6">
                            <x-inputs.inputext :value="@$service->category->name" name="service_category_id" required :title="lng('dashboard.services.category')"/>
                        </div>
                        <div class="col-md-6">
                            <x-inputs.inputext name="price" required :value="$service->price" :title="lng('dashboard.general.price','السعر')"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <img src="{{$service->image_url}}" class="img-fluid" alt="">

                </div>

                <div class="col-md-6">
                    <x-inputs.inputext name="ingredients_ar" :value="$service->getTranslation('ingredients','ar')"  :title="lng('dashboard.services.ingredients_ar','المكونات')"/>
                </div>

                <div class="col-md-6">
                    <x-inputs.inputext name="ingredients_en" :value="$service->getTranslation('ingredients','en')"  :title="lng('dashboard.services.ingredients_en',' المكونات بالانجليزية')"/>
                </div>

                <div class="col-md-6">
                    <x-inputs.inputext name="nutrition_facts_ar" :value="$service->getTranslation('nutrition_facts','ar')"  :title="lng('dashboard.services.nutrition_facts_ar','القيمة الغذائية')"/>
                </div>

                <div class="col-md-6">
                    <x-inputs.inputext name="nutrition_facts_en" :value="$service->getTranslation('nutrition_facts','en')"  :title="lng('dashboard.services.nutrition_facts_en',' القيمة الغذائية بالانجليزية')"/>
                </div>


            </div>
    </x-theme.card>

@endsection
@push('js')


@endpush

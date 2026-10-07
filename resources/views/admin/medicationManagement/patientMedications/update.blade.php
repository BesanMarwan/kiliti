@extends('layouts.admin')
@section('title',lng('dashboard.medications.edit_medications','تعديل بيانات دواء عام'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :href="route('system.medications.index')" :name="lng('dashboard.medications.medications','الأدوية العامة')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.medications.edit_medications','تعديل بيانات دواء عام')"/>
    </x-header.title>
@endsection

@section('content')
    <x-theme.card>
        <form action="{{route('system.medications.update',$medication->id)}}" id="FormSubmit" method="post">
            @csrf
            <div class="row justify-content-center">

                <div class="col-md-9">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <x-inputs.input name="name_ar" required :value="$medication->getTranslation('name','ar')" :title="lng('dashboard.general.name_ar','الاسم ')"/>
                        </div>
                        <div class="col-md-6">
                            <x-inputs.input name="name_en" required :value="$medication->getTranslation('name','en')" :title="lng('dashboard.general.name_en','Name')"/>
                        </div>

                        <div class="col-md-6">
                            <x-inputs.select name="category_id" required :title="lng('dashboard.general.category_id','القسم')" :options="$drug_categories" :value="$medication->category_id"/>
                        </div>

                        <div class="col-md-6">
                            <x-inputs.select name="status" required :title="lng('dashboard.general.status','الحالة')" :options="\App\Models\Medication::getStatusArray()" :value="$medication->status"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <x-inputs.image name="image"  :title="lng('dashboard.general.image','الصورة')" :value="$medication->image" width="300" height="300"/>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-inputs.area name="description_ar" :value="$medication->getTranslation('description','ar')" required :title="lng('dashboard.general.description_ar','وصف الدواء')"/>
                    </div>
                    <div class="col-md-6">
                        <x-inputs.area name="description_en" :value="$medication->getTranslation('description','en')" required :title="lng('dashboard.general.description_en','Medicine Description')"/>
                    </div>

                    <div class="col-md-6">
                        <x-inputs.area name="important_alert_ar" :value="$medication->getTranslation('important_alert','ar')" required :title="lng('dashboard.general.important_alert_ar','تنبيه هام')"/>
                    </div>
                    <div class="col-md-6">
                        <x-inputs.area name="important_alert_en" :value="$medication->getTranslation('important_alert','en')" required :title="lng('dashboard.general.important_alert_en','Important Alert')"/>
                    </div>

                </div>
                <div class="w-100"></div>
                <div class="col-md-5">
                    <x-button class="w-100 btn-save" data-closemodal="#OpenModal_2">
                        <span class="svg-icon svg-icon-2"><x-lineawesome-check-solid/></span>@lng('dashboard.general.edit','تعديل')

                    </x-button>
                </div>
            </div>
        </form>
    </x-theme.card>

@endsection
@push('js')


@endpush

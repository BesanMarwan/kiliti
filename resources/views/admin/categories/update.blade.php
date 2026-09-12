@extends('layouts.admin')
@section('title',lng('dashboard.categories.edit_category','تعديل بيانات قسم'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :href="route('system.categories.index')" :name="lng('dashboard.categories.categories','الأقسام')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.categories.edit_categories')"/>
    </x-header.title>
@endsection

@section('content')
    <x-theme.card>
        <form action="{{route('system.categories.update',$category->id)}}" id="FormSubmit" method="post">
            @csrf
            <div class="row justify-content-center">

                <div class="col-md-9">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <x-inputs.input name="name_ar" required :value="$category->getTranslation('name','ar')" :title="lng('dashboard.general.name_ar','الاسم ')"/>
                        </div>
                        <div class="col-md-6">
                            <x-inputs.input name="name_en" required :value="$category->getTranslation('name','en')" :title="lng('dashboard.general.name_en','Name')"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <x-inputs.image name="image"  :title="lng('dashboard.general.image','الصورة')" :value="$category->image" width="300" height="300"/>

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

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
        <form action="{{route('system.centers.update',$center->id)}}" id="FormSubmit" method="post">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <x-inputs.input name="name" required :title="lng('dashboard.centers.name','اسم المركز')" :value="$center->name"/>
                </div>
                <div class="col-md-4">
                    <x-inputs.input name="phone" required :title="lng('dashboard.centers.phone','رقم المركز')" :value="$center->phone"/>
                </div>
                <div class="col-md-4">
                    <x-inputs.select name="status" required :title="lng('dashboard.centers.status','حالة المركز')" :options="\App\Models\DialysisCenter::getStatusArray()" :value="$center->status"/>
                </div>

                <div class="col-md-4">
                    <x-inputs.input name="governorate" required :title="lng('dashboard.centers.governorate','المحافظة')" :value="$center->governorate"/>
                </div>
                <div class="col-md-4">
                    <x-inputs.input name="city" required :title="lng('dashboard.centers.city','المنطقة')" :value="$center->city"/>
                </div>
                <div class="col-md-4">
                    <x-inputs.input name="address" required :title="lng('dashboard.centers.address','العنوان كاملا')" :value="$center->address"/>
                </div>
                <div class="col-md-4">
                    <x-inputs.input name="total_machines" required :title="lng('dashboard.centers.total_machines','عدد الأجهزة الكلية')" :value="$center->total_machines"/>
                </div>
                <div class="col-md-4">
                    <x-inputs.input name="working_machines" required :title="lng('dashboard.centers.working_machines','عدد الأجهزة الفعالة')" :value="$center->working_machines"/>
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

@extends('layouts.admin')
@section('title',lng('dashboard.categories.create_categories','ضافة قسم'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :href="route('system.categories.index')" :name="lng('dashboard.categories.services','الخدمات')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.categories.create_categories')"/>
    </x-header.title>
@endsection

@section('content')
    <x-theme.card>
        <form action="{{route('system.centers.store')}}" id="FormSubmit" method="post">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <x-inputs.input name="name" required :title="lng('dashboard.centers.name','اسم المركز')"/>
                </div>
                <div class="col-md-4">
                    <x-inputs.input name="phone" required :title="lng('dashboard.centers.phone','رقم المركز')"/>
                </div>
                <div class="col-md-4">
                    <x-inputs.select name="status" required :title="lng('dashboard.centers.status','حالة المركز')" :options="\App\Models\DialysisCenter::getStatusArray()"/>
                </div>

                <div class="col-md-4">
                    <x-inputs.input name="governorate" required :title="lng('dashboard.centers.governorate','المحافظة')"/>
                </div>
                <div class="col-md-4">
                    <x-inputs.input name="city" required :title="lng('dashboard.centers.city','المنطقة')"/>
                </div>
                <div class="col-md-4">
                    <x-inputs.input name="address" required :title="lng('dashboard.centers.address','العنوان كاملا')"/>
                </div>
                <div class="col-md-4">
                    <x-inputs.input name="total_machines" required :title="lng('dashboard.centers.total_machines','عدد الأجهزة الكلية')"/>
                </div>
                <div class="col-md-4">
                    <x-inputs.input name="working_machines" required :title="lng('dashboard.centers.working_machines','عدد الأجهزة الفعالة')"/>
                </div>


                <div class="w-100"></div>
                <div class="col-md-5">
                    <x-button class="w-100 btn-save" data-closemodal="#OpenModal_2">
                        <span class="svg-icon svg-icon-2"><x-lineawesome-check-solid/>
                        </span>@lng('dashboard.general.add','اضافة')

                    </x-button>
                </div>
            </div>
        </form>
    </x-theme.card>

@endsection
@push('js')


@endpush

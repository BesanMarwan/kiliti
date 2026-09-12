@extends('layouts.admin')
@section('title',lng('dashboard.districts.create_district','اضافة حي جديد'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :href="route('system.districts.index')" :name="lng('dashboard.districts.districts','الأحياء')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.districts.create_district','اضافة حي جديد')"/>
    </x-header.title>
@endsection

@section('content')
    <form action="{{route('system.districts.store')}}" id="FormSubmit" method="post">

    <x-theme.card>
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <x-inputs.input name="name_ar" required :title="lng('dashboard.general.name_ar','الاسم')"/>
                </div>
                <div class="col-md-6">
                    <x-inputs.input name="name_en" required :title="lng('dashboard.general.name_en','Name')"/>
                </div>

                <div class="col-md-6">
                    <x-inputs.select name="area_id" id="area" required :title="lng('dashboard.general.area_id','المنطقة')" :options="$areas" :value="old('area_id')"/>
                </div>
                <div class="col-md-6">
                    <x-inputs.select name="city_id" id="parent" required :title="lng('dashboard.general.city_id','المدينة')" :options="[]"/>
                </div>

                <div class="w-100"></div>
                <div class="col-md-5">
                    <x-button class="w-100 btn-save" data-closemodal="#OpenModal_2">
                        <span class="svg-icon svg-icon-2"><x-lineawesome-check-solid/></span>@lng('dashboard.general.add','اضافة')

                    </x-button>
                </div>
            </div>
    </x-theme.card>


        <script>

            $(function (){
                $('#area').on('change', function () {

                    var id = this.value;
                    $.get('/cms/admin/areas/show-cities/' + id, function (data) {
                        console.log(data);
                        $('#parent').html('');

                        if (data.data.length > 0) {
                            $('#parent').append('<option value=""></option>');
                            $.each(data.data, function (index, value) {
                                $('#parent').append("<option value='" + value.id + "'>" + value.name + "</option>");
                            });
                            $('#parent').trigger("change");

                        }
                    })
                });

            });

        </script>


    </form>



@endsection
@push('js')


@endpush

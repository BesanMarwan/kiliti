@extends('layouts.admin')
@section('title',lng('dashboard.districts.edit_district','تعديل بيانات حي'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :href="route('system.districts.index')" :name="lng('dashboard.districts.districts','الأحياء')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.districts.edit_district','تعديل بيانات حي')"/>
    </x-header.title>
@endsection

@section('content')
    <x-theme.card>
        <form action="{{route('system.districts.update',$city->id)}}" id="FormSubmit" method="post">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <x-inputs.input name="name_ar" required :value="$city->getTranslation('name','ar')" :title="lng('dashboard.general.name_ar','الاسم ')"/>
                </div>
                <div class="col-md-6">
                    <x-inputs.input name="name_en" required :value="$city->getTranslation('name','en')" :title="lng('dashboard.general.name_en','Name')"/>
                </div>
                <div class="col-md-6">
                    <x-inputs.select name="area_id" id="area" required :title="lng('dashboard.general.area_id','المنطقة')" :options="$areas" :value="$city->parent->parent_id"/>
                </div>

                <div class="col-md-6">
                    <x-inputs.select name="city_id" id="parent" required :title="lng('dashboard.general.city_id','المدينة')" :options="$cities" :value="$city->parent_id"/>
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
    <script>

        $(function (){
            $('#area').on('change', function () {

                var id = this.value;
                $.get('/cms/admin/areas/show-cities/' + id, function (data) {
                    console.log(data);
                    $('#parent').html('');

                    if (data.data.length > 0) {
                        $('#parent').append('<option>المدينة</option>');
                        $.each(data.data, function (index, value) {
                            $('#parent').append("<option value='" + value.id + "'>" + value.name + "</option>");
                        });
                        $('#parent').trigger("change");

                    }
                })
            });

        });

    </script>


@endsection
@push('js')


@endpush

@extends('layouts.admin')
@section('title',lng('dashboard.faq.create_faq','ضافة سؤال جديد'))
@section('page_title')
<x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
    <x-header.breadcrumb-item :href="route('system.faq.index')" :name="lng('dashboard.general.faq','الأسئلة الشائعة')"/>
    <x-header.breadcrumb-item :name="lng('dashboard.faq.create_faq')"/>

</x-header.title>
@endsection

@section('content')
<x-theme.card>
    <form action="{{route('system.faq.store')}}" id="FormSubmit" method="post">
        @csrf
        <div class="row justify-content-center">

         <div class="col-md-12 row">

                    <div class="col-md-6">
                        <x-inputs.input name="question_ar" :class="'arabic'" required
                            placeholder="ادخل السؤال" title="السؤال " />
                    </div>
                    <div class="col-md-6">
                        <x-inputs.input name="question_en" :class="'english'" required
                            placeholder="Enter Question" title="Question" />
                    </div>


                    <div class="col-md-6">
                        <x-inputs.area_editor  name="answer_ar" :class="'arabic'" required
                                        rows="7"
                            placeholder="ادخل الجواب " title="الجواب" />
                    </div>
                    <div class="col-md-6">
                        <x-inputs.area_editor  name="answer_en" :class="'english'" required
                                        rows="7"
                            placeholder="Enter Answer" title="Answer" />
                    </div>



                </div>
                <div class="w-100"></div>
                <div class="col-md-5">
                    <x-button class="w-100 btn-save" data-closemodal="#OpenModal_2">
                        <span class="svg-icon svg-icon-2">
                        </span>@lng('dashboard.general.add','اضافة')

                    </x-button>
                </div>
         </div>
    </form>
</x-theme.card>

@endsection
@push('js')




@endpush

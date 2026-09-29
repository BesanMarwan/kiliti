@extends('layouts.admin')
@section('page_title')
    <x-header.title name="لوحة التحكم">
        <x-header.breadcrumb-item :href="route('system.client_consult.index')" name="توعية العملاء"/>
        <x-header.breadcrumb-item :name="lng('dashboard.categories.edit_faq')"/>
    </x-header.title>
@endsection
@section('content')
<x-theme.card>
    <form action="{{route('system.faq.update',$faq->id)}}" id="editForm"  method="post">
        @csrf

            <div class="row justify-content-center">

                    <div class="col-md-6">
                        <x-inputs.input name="question_ar" :class="'arabic'"
                                        :value="$faq->getTranslation('question', 'ar')" required
                                        placeholder="ادخل السؤال "
                                       :title="'السؤال '"/>
                    </div>
                    <div class="col-md-6">
                        <x-inputs.input name="question_en" :class="'english'" required
                                        :value="$faq->getTranslation('question', 'en')"
                                        placeholder="Enter Question"
                                        :title="'Question'"/>
                    </div>

                    <div class="col-md-6">
                        <x-inputs.area_editor name="answer_ar" :class="'arabic'"
                                              rows="7"
                                              :value="$faq->getTranslation('answer', 'ar')" required
                                              placeholder="ادخل الجواب "
                                              :title="'الجواب'"/>
                    </div>
                    <div class="col-md-6">
                        <x-inputs.area_editor name="answer_en" :class="'english'"
                                              rows="7"
                                              :value="$faq->getTranslation('answer', 'en')" required
                                              placeholder="Enter Answer"
                                              :title="'Answer'"/>
                    </div>

                 <div class="w-100"></div>
                    <div class="col-md-5">
                        <x-button class="w-100 btn-save" data-closemodal="#OpenModal_2">
                            <span class="svg-icon svg-icon-2">
                            </span>@lng('dashboard.general.edit','تعديل')

                        </x-button>
                    </div>
                </div>

    </form>
  </x-theme.card>
@endsection


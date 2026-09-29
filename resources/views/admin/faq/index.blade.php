@extends('layouts.admin')

@section('title','الاسئلة الشائعة')

@section('page_title')
    <x-header.title name="لوحة التحكم">
        <x-header.breadcrumb-item name="الأسئلة الشائعة"/>
    </x-header.title>
@endsection

@section('search_content')
<x-search :searchable="\App\Models\Faq::getSearchable()" />
@endsection

@section('content')
    <x-theme.card>


     <x-slot name="toolbar">
        <a class="btn btn-sm btn-info mx-2 OpenModal" href="{{ route('system.faq.create')  }}"
            data-title=" اضافة سؤال جديد" data-size="modal-xl" level="2">
            <span class="svg-icon svg-icon-white svg-icon-x">@svg('lineawesome-plus-solid')</span>
            اضافة سؤال جديد
        </a>
    </x-slot>



        <x-slot name="bulkactions">
            <button type="button" class="btn btn-danger btn-bulk-action"
                    data-url="{{route('system.faq.delete')}}" data-token="{{csrf_token()}}">حذف المحدد
            </button>
        </x-slot>

        <x-theme.tables.table>

            <x-slot name="thead">
                <th class="w-10px pe-2">
                    <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                                       />
                </th>
                <th class="min-w-125px">السؤال</th>
                <th class="text-center   min-w-100px">الاعدادات</th>
            </x-slot>

            <x-slot name="tbody">
                @forelse($out as $o)
                    <tr id="TR_{{$o->id}}">
                        <td class="w-10px pe-2">
                            <x-theme.tables.checkbox value="{{$o->id}}"/>
                        </td>
                        <td>
                            <p class="text-gray-800 text-hover-primary mb-1">{{ $o->getTranslation('question', 'ar') }}</p>
                            <p>{{$o->getTranslation('question', 'en')}}</p>
                        </td>


                        <td class="text-center">
                            <x-theme.tables.menu title="العمليات">
                           <x-theme.tables.menu-item :title="lng('dashboard.general.edit','تعديل')" class="OpenModal"
                                            data-title="تعديل السؤال" data-size="modal-xl" level="2"
                                            :href="route('system.faq.update',$o->id)" />

                                <x-theme.tables.menu-item title="حذف" data-table-action="delete_row"
                                                          data-url="{{route('system.faq.delete')}}"
                                                          data-token="{{csrf_token()}}" data-id="{{$o->id}}"/>

                            </x-theme.tables.menu>
                        </td>
                    </tr>
                    @empty
                        <tr id="TR_0">

                            <td colspan="15" class="text-center text-muted">
                                لا يوجد نتائج
                            </td>
                        </tr>
                    @endforelse
            </x-slot>

        </x-theme.tables.table>
        {{$out->links()}}
    </x-theme.card>
@endsection

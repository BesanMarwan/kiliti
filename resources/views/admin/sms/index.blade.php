@extends('layouts.admin')
@section('title',lng('dashboard.general.SMS','الرسائل النصية'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :name="lng('dashboard.general.SMS','الرسائل النصية')"/>
    </x-header.title>
@endsection
@push('css')
    <style>
        .none{
            display:none
        }
    </style>
@endpush
@section('search_content')
    <x-search :searchable="\App\Models\SMS::getSearchable()"/>
@endsection
@section('content')
<x-theme.card>


    <x-slot name="toolbar">
        <a  class="btn btn-sm btn-info  mx-2 OpenModal"
            data-title="@lng('dashboard.general.send_sms','ارسال رسالة نصية')"
            href="{{route('system.sms.create')}}"
            data-size="modal-xl"
            level="2"
        >
            <span class="svg-icon svg-icon-white svg-icon-x">@svg('lineawesome-plus-solid')</span>
            <span>@lng('dashboard.general.send_sms','ارسال رسالة نصية')</span>
        </a>
    </x-slot>

    <x-slot name="bulkactions">
        <button type="button" class="btn btn-danger btn-bulk-action" data-url="{{route('system.sms.delete')}}" data-token="{{csrf_token()}}" >حذف المحدد</button>
    </x-slot>
    <x-theme.tables.table>
        <x-slot name="thead">
            <th class="w-10px pe-2">
                <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                />
            </th>
            <th class="min-w-125px text-center">@lng('dashboard.sms.message','الرسالة')</th>
{{--             <th class="min-w-125px text-center">الفئة المستهدفة</th>--}}
            <th class="min-w-125px text-center">@lng('dashboard.global_notifications.SenderDate','تاريخ الارسال')</th>
            <th class="text-center min-w-100px">@lng('dashboard.general.settings','الاعدادات')</th>
        </x-slot>
        <x-slot name="tbody">

            @forelse($out as $o)
                <tr id="TR_{{$o->id}}">
{{--                      <td class="w-10px pe-2">--}}
{{--                            {{$loop->iteration + ($out->currentPage()-1)*$out->perPage()}}--}}
{{--                        </td>--}}
                    <td class="w-10px pe-2">
                        <x-theme.tables.checkbox value="{{$o->id}}"/>
                    </td>

                    <td class="text-center">{{$o->message}}</td>

{{--                                            <td class="text-center">--}}
{{--                                                 {{$o->type_text}}--}}
{{--                                                </td>--}}

                    <td class="text-center">
                        <div class="badge {{$o->created_at && $o->created_at->diffInDays() == 0 ?'badge-info':'badge-light'}} fw-bolder">{{$o->created_at?$o->created_at->diffForHumans():'-'}}</div>
                    </td>

                    <td class="text-center">
                        <x-theme.tables.menu :title="lng('dashboard.general.settings','الاعدادات')">
                            <x-theme.tables.menu-item :title="lng('dashboard.general.delete')" data-table-action="delete_row" data-url="{{route('system.sms.delete')}}" data-token="{{csrf_token()}}" data-id="{{$o->id}}" />
                        </x-theme.tables.menu>
                    </td>
                </tr>
            @empty
                <tr id="TR_0">

                    <td colspan="15" class="text-center text-muted">
                        @lng('dashboard.general.no_data','لا يوجد نتائج')
                    </td>
                </tr>
            @endforelse

        </x-slot>
    </x-theme.tables.table>
    {{$out->links()}}
</x-theme.card>



@endsection
@push('js')


    <script>
        function removeNone(){
            $('.sent').addClass('none');
            var type =$('#type').val();
            $('.'+type).removeClass('none');
            $('.'+type).attr('required','required');
        }

        $(function(){
            if($('#type').length){
                $type =$('#type').val();
                if($type != ''){
                    var type =$('#type').val();
                    $('.'+type).removeClass('none');
                    $('.'+type).attr('required','required');

                }
            }

        })

    </script>
@endpush

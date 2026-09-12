@extends('layouts.admin')
@section('title','الدعم الفني')
@section('page_title')
    <x-header.title name="لوحة التحكم">
        <x-header.breadcrumb-item name="الدعم الفني"/>
    </x-header.title>
@endsection
@section('search_content')
    <x-search :searchable="\App\Models\Contact::getSearchable()"/>
@endsection
@section('content')
    <x-theme.card>
        <x-slot name="bulkactions">
            @can('contactus.delete')
                <button type="button" class="btn btn-danger btn-bulk-action"
                        data-url="{{route('system.contacts.delete')}}" data-token="{{csrf_token()}}">حذف المحدد
                </button>
            @endcan
        </x-slot>
        <x-theme.tables.table>
            <x-slot name="thead">
                <th class="w-10px pe-2">
                    <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                    />
                </th>
                <th class="min-w-125px text-center">الاسم</th>
                <th class="min-w-125px text-center">الايميل</th>
                <th class="min-w-125px text-center">الجوال</th>
                <th class="min-w-125px text-center"> الرسالة</th>
                <th class="min-w-125px text-center"> تاريخ الارسال</th>
                <th class="text-end min-w-100px text-center">الاعدادات</th>
            </x-slot>
            <x-slot name="tbody">

                @forelse($objects as $object)
                    <tr id="TR_{{$object->id}}">
                        <td class="w-10px pe-2">
                            <x-theme.tables.checkbox value="{{$object->id}}"/>
                        </td>

                        <td class="min-w-125px text-center">
                            @if($object->creator_id > 0 && $object->creator)

                                <a  data-title="{{lng('dashboard.general.details','التفاصيل')}} "
                                    data-size="modal-xl"
                                    level="3"
                                    href="{{route('system.users.show',$object->creator_id)}}" class="text-gray-800 text-hover-primary mb-1 OpenModal">

                                    {{@$object->name}}
                                </a>
                            @else
                                {{@$object->name}}
                            @endif

                            @if(! $object->is_seen)
                                <div class="badge badge-light-warning mx-1">@lng('dashboard.general.New','جديد')</div>
                            @endif
                        </td>
                        <td class="min-w-125px text-center">
                            {{$object->email ?? '-'}}
                        </td>
                        <td class="min-w-125px text-center">
                            {{@$object->country->prefix .@$object->mobile}}
                        </td>
                        <td class="text-center">
                            {{Str::limit($object->message,50)}}
{{--                            {{$object->title}}--}}

                        </td>


                        <td class="text-center">
                            <div class="badge {{$object->created_at && $object->created_at->diffInDays() == 0 ?'badge-success':'badge-light'}} fw-bolder">
                                {{$object->created_at?$object->created_at->format('Y-m-d'):'-'}}
                            </div>
                        </td>


                        <td class="text-center">
                            <x-theme.tables.menu title="العمليات">

                                @can('contacts.delete')
                                    <x-theme.tables.menu-item title="حذف" data-table-action="delete_row"
                                                              data-url="{{route('system.contacts.delete')}}"
                                                              data-token="{{csrf_token()}}" data-id="{{$object->id}}"/>
                                @endcan

{{--                                <div class="menu-item px-3">--}}
{{--                                    <a href="{{route('system.contacts.replay.index',$object->id)}}"--}}
{{--                                       data-title="{{lng('dashboard.contacts.show','عرض التفاصيل')}} "--}}
{{--                                       class="menu-link px-3 text-start ">عرض التفاصيل</a>--}}
{{--                                </div>--}}

                                    <div class="menu-item px-3">
                                        <a href="{{route('system.contacts.details',$object->id)}}"
                                           data-title="{{lng('dashboard.contacts.details','عرض التفاصيل')}} "
                                           data-size="modal-xl"
                                           level="2"
                                           class="menu-link px-3 text-start "> التفاصيل</a>
                                    </div>




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
        {{$objects->links()}}
    </x-theme.card>



@endsection

@push('js')
    <script>
        function validate_num(evt) {
            var theEvent = evt || window.event;

            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }

    </script>
@endpush

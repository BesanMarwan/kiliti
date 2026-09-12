@extends('layouts.admin')
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :name="lng('dashboard.admins.admins')"/>
    </x-header.title>
@endsection
@section('search_content')
    <x-search :searchable="\App\Models\Admin::getSearchable()"/>
@endsection
@section('content')
    <x-theme.card>

        <x-slot name="toolbar">
            <a  class="btn btn-sm btn-info  mx-2 OpenModal"
                data-title=" {{lng('admin.admins.add_new_admin')}}"
                href="{{route('system.admins.create')}}"
                data-size="modal-xl"
                level="2"
            >
                <span class="svg-icon svg-icon-white svg-icon-x">@svg('lineawesome-plus-solid')</span>
                <span>{{lng('admin.admins.add_new_admin')}}</span>
            </a>
        </x-slot>

        <x-slot name="bulkactions">
            <button type="button" class="btn btn-danger mx-2 btn-bulk-action"
                    data-url="{{route('system.admins.delete')}}" data-token="{{csrf_token()}}">@lng('dashboard.general.delete_selected','حذف المحدد')
            </button>

        </x-slot>

        <x-theme.tables.table>
            <x-slot name="thead">
                <th class="w-10px pe-2">
                    <x-theme.tables.checkbox data-kt-check="true" data-kt-check-target="#showTable .form-check-input"
                                             />
                </th>
                <th class="min-w-125px">@lng('dashboard.general.image')</th>
                <th class="min-w-125px text-center">@lng('dashboard.general.Name')</th>
                <th class="min-w-125px text-center">@lng('dashboard.general.Mobile')</th>
                <th class="min-w-125px text-center">@lng('dashboard.general.Email')</th>
                <th class="min-w-125px text-center">@lng('dashboard.general.Role')</th>
                <th class="min-w-125px text-center">@lng('dashboard.general.Last Login')</th>
                <th class="min-w-100px text-center">@lng('dashboard.general.settings')</th>
            </x-slot>
            <x-slot name="tbody">

                @forelse($admins as $admin)
                    <tr id="TR_{{$admin->id}}">
                        <td class="w-10px pe-2">
                            <x-theme.tables.checkbox value="{{$admin->id}}"/>
                        </td>
                        <td class="d-flex align-items-center min-w-125px text-center">
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <div class="symbol-label">
                                    <img src="{{$admin->image_url}}" alt="Emma Smith" class="w-100" />
                                </div>
                            </div>
                        </td>
                        <td class="min-w-125px text-center">
                            <div class="d-flex flex-column">
                                <span class="text-gray-800 text-hover-primary mb-1">{{$admin->name}}</span>
                            </div>
                        </td>
                        <td class="min-w-125px text-center">{{$admin->mobile}}</td>
                        <td class="min-w-125px text-center">{{$admin->email}}</td>

                        <td class="min-w-125px text-center">{{$admin->getRoleNames()->implode(',')}}</td>

                        <td class="min-w-125px text-center">
                            <div class="badge {{$admin->login_at && $admin->login_at->diffInDays() == 0 ?'badge-success':'badge-light'}} fw-bolder">{{$admin->login_at?$admin->login_at->diffForHumans():'-'}}</div>
                        </td>


                        <td class="text-center">
                            <x-theme.tables.menu :title="lng('dashboard.general.settings','الاعدادات')">
                                <x-theme.tables.menu-item :title="lng('dashboard.general.edit')" class=" OpenModal"
                                                          data-title="{{lng('dashboard.admins.edit_admin')}}"
                                                          data-size="modal-xl"
                                                          level="2"
                                                          :href="route('system.admins.update',['id'=>$admin->id])"/>

                                <x-theme.tables.menu-item :title="lng('dashboard.general.changePassword')" class=" OpenModal"
                                                          data-title="{{lng('dashboard.general.changePassword')}}"
                                                          data-size="modal-xl"
                                                          level="2"
                                                          :href="route('system.admins.password',['id'=>$admin->id])"/>

                                <x-theme.tables.menu-item :title="lng('dashboard.general.delete')" data-table-action="delete_row" data-url="{{route('system.admins.delete')}}" data-token="{{csrf_token()}}" data-id="{{$admin->id}}" />
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
        {{$admins->links()}}
    </x-theme.card>



@endsection

@push('js')
    <script>

        $("body").on('click', '*[data-table-action="delete_row"]',

            function (e) {
                e.preventDefault();
                var desc = $(this).data('desc') ? $(this).data('desc') : '';
                var Id = $(this).data('id');
                var url = $(this).data('url');
                var token = $(this).data('token');
                var thisF = $(this);
                let parentMenu=$(this).parents('td').find('.btn-menu');
                Swal.fire(
                    {
                        title: "هل انت متأكد ؟",
                        text: "هل تريد بالتأكيد حذف العنصر" + '   ' + desc,
                        icon: "warning",
                        showCancelButton: 1,
                        confirmButtonText: "نعم , قم بالحذف !",
                        cancelButtonText: "لا, الغي العملية !",

                    }).then(function (e) {
                    if (e.value) {


                        parentMenu.attr('data-kt-indicator', 'on').addClass('disabled')
                        $.post(url,
                            {
                                _token: token,
                                id: Id,
                            },
                            function (data, status) {
                                if (data.done == 1) {
                                    Swal.fire({
                                        title: 'تم الحذف بنجاح',
                                        text: data.msg,
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(
                                        function () {
                                            parentMenu.attr('data-kt-indicator', 'off').removeClass('disabled')
                                            var ra = thisF.parents('tr');
                                            var d = thisF.parents('.productItem');
                                            var table = thisF.parents('table');
                                            d.css('background', 'rgba(255,0,0,0.53)').fadeOut(600);
                                            ra.css('background', 'rgba(255,0,0,0.53)').fadeOut(600, function () {
                                                ra.remove();
                                                var num = 1;
                                                table.find('.LOOPIDS').each(function () {
                                                    $(this).text(num);
                                                    num = num + 1;
                                                });
                                            });
                                        }
                                    )

                                } else {
                                    parentMenu.attr('data-kt-indicator', 'off').removeClass('disabled')

                                    Swal.fire({
                                        title:data.title||'حدث خطأ ',
                                        text: data.message||'ما',
                                        icon: 'error',
                                        timer: 4000,
                                        showConfirmButton: false
                                    })
                                }

                            }).fail(function (data2, status) {
                            var data2 = data2.responseJSON;
                            Swal.fire({
                                title: 'خطأ',
                                text: data2.response_message,
                                icon: 'error',
                                timer: 4000,
                                showConfirmButton: false
                            })
                        });
                    } else {
                        e.dismiss && Swal.fire("تم الالغاء", "لم يتم عمل اي تغيير", "error");
                    }
                });
            });
    </script>
@endpush

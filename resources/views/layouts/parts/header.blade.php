<!--begin::Header-->
<div id="kt_header" style="" class="header align-items-stretch">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Aside mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                 id="kt_aside_mobile_toggle">

                <span class="svg-icon svg-icon-2x mt-1">
{{--                    <x-metronic-Menu/>--}}
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::Aside mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="?page=index" class="d-lg-none">
                <img alt="Logo" src="{{asset('assets/media/logos/logo.png')}}" class="h-30px"/>
            </a>
        </div>
        <!--end::Mobile logo-->
        <!--begin::Wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <!--begin::Navbar-->
            <div class="d-flex align-items-center" id="kt_header_nav">
               @yield('page_title')

            </div>
            <!--end::Navbar-->
            <!--begin::Topbar-->
            <div class="d-flex align-items-stretch flex-shrink-0">


                <!--begin::Toolbar wrapper-->
                <div class="d-flex align-items-stretch flex-shrink-0">


                    <!--begin::Notifications-->
                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                        <!--begin::Menu- wrapper-->
                        <div
                            class="btn  btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px"
                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end" id="NotificationBill"
                            data-kt-menu-flip="bottom">
{{--                            <x-metronic-Compiling/>--}}
                        </div>


                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
                            <!--begin::Heading-->
                            <div class="d-flex flex-column bgi-no-repeat rounded-top"
                                 style="background-image:url('{{asset('assets/media/misc/pattern-1.jpg')}}')">

                                <h3 class="text-white fw-bold px-9 mt-10 mb-6">@lng('dashboard.global_notifications.global_notifications','الاشعارات')
                                    <span class="fs-8 opacity-75 ps-3">
                                        <span id="NotificationCount">{{auth('admin')->user()->notifications_count}}</span>
                                         @lng('dashboard.global_notifications.notification','اشعار')
                                    </span></h3>
                            </div>

                            <div class="tab-content">

                                <div class="tab-pane fade show active" id="kt_topbar_notifications_2" role="tabpanel">

                                    <!--begin::Items-->
                                    <h3 class="text-center  my-5 px-8" id="NotificationLoading">{{lng('dashboard.general.loading')}} ...</h3>
                                    <h3 class="text-center  my-5 px-8" id="NoNotifications">{{lng('dashboard.general.no_notification')}}</h3>
                                    <div class="scroll-y mh-325px my-5 px-8" style="display: none" id="NotifcationsContainer">

                                    </div>
                                    <!--end::Items-->
                                    @if(false)
                                    <div class="py-3 text-center border-top">
                                        <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">عرض الكل
                                            <!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
                                            <span class="svg-icon svg-icon-5">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24" />
																		<rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
																		<path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
																	</g>
																</svg>
															</span>
                                            <!--end::Svg Icon--></a>
                                    </div>

                                        @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Notifications-->
                    <!--begin::User-->
                    <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                        <!--begin::Menu wrapper-->
                        <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click"
                             data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"
                             data-kt-menu-flip="bottom">
                            <img src="{{auth()->guard('admin')->user()->image_url}}" alt="metronic"/>
                        </div>


                        <!--begin::Menu-->
                        <div
                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" src="{{auth()->guard('admin')->user()->image_url}}"/>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Username-->
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder d-flex align-items-center fs-5">{{auth()->guard('admin')->user()->name}}
                                            <span
                                                class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">{{auth()->guard('admin')->user()->getRoleNames()->implode(',')}}</span>
                                        </div>
                                        <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{auth()->guard('admin')->user()->email}}</a>
                                    </div>
                                    <!--end::Username-->
                                </div>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu separator-->
                            <div class="separator my-2"></div>
                            <!--end::Menu separator-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="{{route('system.admins.profile')}}" class="menu-link px-5">@lng('dashboard.general.my_profile','بياناتي')</a>
                            </div>
                            <!--end::Menu item-->



                            <div class="separator my-2"></div>
                          @if(config('custom.show_change_language'))
                            <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start"
                                 data-kt-menu-flip="bottom">
                                <a href="#" class="menu-link px-5">
														<span class="menu-title position-relative">@lng('dashboard.language.language','اللغة')
														<span
                                                            class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                                    {{ LaravelLocalization::getCurrentLocaleNative() }}

                                    {{--														<img class="w-15px h-15px rounded-1 ms-2"--}}
{{--                                                             src="{{asset('assets/media/flags/saudi-arabia.svg')}}" alt="metronic"/></span></span>--}}
                                </a>

                                <!--begin::Menu sub-->
                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                    <!--begin::Menu item-->


                                    <!--end::Menu item-->

                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                                        <div class="menu-item px-3">
                                            <a hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="menu-link d-flex px-5 @if(LaravelLocalization::getCurrentLocale() ==$localeCode) active @endif ">
															<span class="symbol symbol-20px me-4">
																<img class="rounded-1"
                                                                     src="{{asset('assets/media/svg/flags/'.$localeCode.'.svg')}}"
                                                                     alt="metronic"/>
															</span>
                                                {{ $properties['native'] }}
                                            </a>
                                        </div>

                                    @endforeach


                                    <!--begin::Menu item-->

                                </div>
                                <!--end::Menu sub-->
                            </div>
                            @endif
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="{{route('admin.logout')}}" class="menu-link px-5">@lng('dashboard.general.logout','تسجيل الخروج')</a>
                            </div>
                            <!--end::Menu item-->
                            <div class="menu-item px-5">
                                <form action="{{route('admin.dashboard',['mode'=>'dark'])}}">
                                <div class="menu-content px-5">
                                    <label class="form-check form-switch form-check-custom form-check-solid pulse pulse-success" for="kt_user_menu_dark_mode_toggle">

                                            @if(session('mode','light') == 'dark')
                                            <input type="hidden" name="mode" value="light">
                                            @endif
                                            <input class="form-check-input w-30px h-20px autoSubmit" type="checkbox" value="dark" {{session('mode','light') == 'dark'?'checked="checked"':''}}  name="mode" id="kt_user_menu_dark_mode_toggle">


                                        <span class="pulse-ring ms-n1"></span>
                                        <span class="form-check-label text-gray-600 fs-7">@lng('dashboard.general.nightMode','الوضع الليلي')</span>
                                    </label>
                                </div>
                                </form>
                            </div>

                        </div>
                        <!--end::Menu-->


                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::User -->
                    <!--begin::Heaeder menu toggle-->
                    <!--end::Heaeder menu toggle-->
                </div>
                <!--end::Toolbar wrapper-->


            </div>
            <!--end::Topbar-->


        </div>


        <!--end::Wrapper-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->


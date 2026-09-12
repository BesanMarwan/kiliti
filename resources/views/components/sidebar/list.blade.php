
@canany($permission)
<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{isset($active)&&$active?' here show ':''}}">
									<span class="menu-link">
										<span class="menu-icon">
											 @if($svg)
                                                <span class="svg-icon svg-icon-2">
												{{$svg}}
											</span>
                                            @elseif($icon)
                                                {{$icon}}
                                            @endif

										</span>
										<span class="menu-title">{{$name}}</span>
										<span class="menu-arrow"></span>
									</span>
    <div class="menu-sub menu-sub-accordion menu-active-bg">
        {{$items}}
    </div>
</div>
@endcan

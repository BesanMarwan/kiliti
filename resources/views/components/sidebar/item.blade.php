@can($permission)
<div class="menu-item">
    <a class="menu-link {{isset($active)&&$active?'active':''}}" href="{{$href}}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
       data-bs-placement="right">
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
    </a>
</div>
@endcan

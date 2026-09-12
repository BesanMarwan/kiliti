@can($permission)
<div class="menu-item">
    <a class="menu-link {{isset($active)&&$active?'active':''}}" href="{{$href}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
        <span class="menu-title">{{$name}}</span>
    </a>
</div>
@endcan

@foreach($out as $o)

    <x-theme.notification-item :title="$o->title" :message="$o->message" :href="$o->link?:''"
                               :time="$o->created_at->diffForHumans()"/>
@endforeach

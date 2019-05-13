@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} replied to 
        <a href="{{ $activity->subject->thread->path() }}">
            {{ $activity->subject->thread->title }}
        </a> 
    @endslot

    @slot('body')
        <p>{{ $activity->subject->body }}</p>                
    @endslot
@endcomponent
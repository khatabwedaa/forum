@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} replied <i class="fas fa-reply" style="color:#1da1f2;"></i> to 
        <a href="{{ $activity->subject->thread->path() }}">
            {{ $activity->subject->thread->title }}
        </a> 
    @endslot

    @slot('body')
        <p>{{ $activity->subject->body }}</p>                
    @endslot
@endcomponent
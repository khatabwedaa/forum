@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} Published <i class="fas fa-align-left" style="color:#3b5998;"></i>
        <a href="{{ $activity->subject->path() }}">
            {{ $activity->subject->title }}
        </a> 
    @endslot

    @slot('body')
        <p>{{ $activity->subject->body }}</p>                
    @endslot
@endcomponent

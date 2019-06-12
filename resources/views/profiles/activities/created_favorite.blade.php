@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} favorited <i class="fas fa-heart" style="color:#dd4b39;"></i> 
        
        <a href="{{ $activity->subject->favorited->path() }}">
            a reply 
        </a>
    @endslot

    @slot('body')
        <p>{!! $activity->subject->favorited->body !!}</p>
    @endslot
@endcomponent
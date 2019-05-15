@component('profiles.activities.activity')
    @slot('heading')
        <a href="{{ $activity->subject->favorited->path() }}">
            {{ $profileUser->name }} favorited a reply 
        </a>
    @endslot

    @slot('body')
        <p>{{ $activity->subject->favorited->body }}</p>
    @endslot
@endcomponent
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="margin-top:2rem">
        <div class="col-md-8 offset-md-2">
            <avatar-form :user="{{ $profileUser }}"></avatar-form>

            <hr style="margin-bottom:2rem">

            @forelse ($activities as $date => $activity)
                <h4 class="head-s">{{ $date }}</h4>
                
                @foreach ($activity as $record)
                    @if (view()->exists("profiles.activities.{$record->type}"))
                        @include("profiles.activities.{$record->type}" , ['activity' => $record])       
                        <hr>
                    @endif
                @endforeach
            @empty
                <p>There is no activity for this user yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
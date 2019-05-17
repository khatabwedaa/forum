@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="margin-top:2rem">
        <div class="col-md-8 offset-md-2">
            <div>
                <h2 class="head-h">
                    {{ $profileUser->name }}
                </h2>
    
                <hr style="margin-bottom:2rem">
            </div>
            
            @forelse ($activities as $date => $activity)
                <h3>{{ $date }}</h3><hr>
                
                @foreach ($activity as $record)
                    @if (view()->exists("profiles.activities.{$record->type}"))
                        @include("profiles.activities.{$record->type}" , ['activity' => $record])       
                    @endif
                @endforeach
            @empty
                <p>There is no activity for this user yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
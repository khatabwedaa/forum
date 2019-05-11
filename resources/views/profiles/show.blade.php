@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div>
                <h2>
                    {{ $profileUser->name }}
                    <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                </h2>
    
                <hr>
            </div>
            
            @foreach ($threads as $thread)
                <div class="card" style="margin-bottom:1rem;">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profile' , $thread->creator) }}">{{ $thread->creator->name }}</a> Posted: 
                                {{ $thread->title }}
                            </span>
    
                            <span>{{ $thread->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <p>{{ $thread->body }}</p>
                    </div>
                </div>
            @endforeach
    
            {{ $threads->links() }}
        </div>
    </div>
</div>
@endsection
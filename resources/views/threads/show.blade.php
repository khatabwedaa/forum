@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $thread->title }}
                </div>
                
                <div class="card-body">
                    <p>{{ $thread->body }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($thread->replies as $reply)
                <div class="card" style="margin-top:1rem;">
                    <div class="card-header">
                        <a href="#">
                            {{ $reply->owner->name }}
                        </a> said {{ $reply->created_at->diffForHumans() }}
                    </div>

                    <div class="card-body">
                        <p>{{ $reply->body }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

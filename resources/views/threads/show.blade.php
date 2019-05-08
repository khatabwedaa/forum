@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-bottom:2rem">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#">{{ $thread->creator->name }}</a> Posted: 

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
                @include('threads.reply')
            @endforeach
        </div>
    </div>

    @auth
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ $thread->path() . '/replies' }}" method="post">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" id="body" class="form-control" placeholder="Having something to say?" rows="3"></textarea>
                    </div>

                    <button class="btn btn-primary">Post</button>
                </form>
            </div>
        </div>
    @else
        <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to share in this  discussion</p>
    @endauth
</div>
@endsection

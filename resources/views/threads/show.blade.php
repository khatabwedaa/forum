@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/vendor/css/jquery.atwho.min.css">
@endsection

@section('content')
<thread-component :thread="{{ $thread }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('threads._thread')

                <replies-component @removed="repliesCount--" @added="repliesCount++"></replies-component>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by 
                            <a href="#">{{ $thread->creator->name }}</a>, and currently 
                            has <span v-text="repliesCount"></span> {{ Str::plural('comment' , $thread->replies_count) }}.
                        </p>      

                        @auth
                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>

                                <button class="btn btn-sm btn-primary" v-if="authorize('isAdmin')" @click="toggleLock" v-text="locked ? 'Unlock' : 'Lock'"></button>
                            </p> 
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-component>
@endsection

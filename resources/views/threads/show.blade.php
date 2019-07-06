@extends('layouts.app')

@section('content')
<thread-component :ini-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card" style="margin-bottom:1rem;">
                    <div class="card-header">
                        <div class="level">
                            <img src="{{ $thread->creator->avatar_path }}" width="25" height="25" class="mr-1">

                            <span class="flex">
                                <a href="{{ route('profile' , $thread->creator) }}">{{ $thread->creator->name }}</a> Posted: 
                                {{ $thread->title }}
                            </span>
                            
                            @can('update', $thread)
                                <form action="{{ $thread->path() }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm" style="color:#ce2910"><i class="fas fa-trash"></i></button>
                                </form>
                            @endcan                      
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <p>{{ $thread->body }}</p>
                    </div>
                </div>

                <replies-component @removed="repliesCount--" @added="repliesCount++"></replies-component>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by 
                            <a href="#">{{ $thread->creator->name }}</a>, and currently 
                            has <span v-text="repliesCount"></span> {{ str_plural('comment' , $thread->replies_count) }}.
                        </p>      

                        @auth
                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                            </p> 
                        @endauth         
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-component>
@endsection

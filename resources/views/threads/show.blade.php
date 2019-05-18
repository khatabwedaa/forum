@extends('layouts.app')

@section('content')
<thread-component :ini-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card" style="margin-bottom:1rem;">
                    <div class="card-header">
                    <div class="level">
                            <span class="flex">
                                <a href="{{ route('profile' , $thread->creator) }}">{{ $thread->creator->name }}</a> Posted: 
                                {{ $thread->title }}
                            </span>
                            @can('update', $thread)
                                <form action="{{ $thread->path() }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">Delete Thread</button>
                                </form>
                            @endcan                      
                    </div>
                    </div>
                    
                    <div class="card-body">
                        <p>{{ $thread->body }}</p>
                    </div>
                </div>

                <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>

                {{-- {{ $replies->links() }} --}}

                @auth
                    <form action="{{ $thread->path() . '/replies' }}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Having something to say?" rows="3"></textarea>
                        </div>

                        <button class="btn btn-primary">Post</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to share in this  discussion</p>
                @endauth
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by 
                            <a href="#">{{ $thread->creator->name }}</a>, and currently 
                            has <span v-text="repliesCount"></span> {{ str_plural('comment' , $thread->replies_count) }}.
                        </p>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-component>
@endsection

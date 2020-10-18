@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
           @include('threads._list')

           {{ $threads->links() }}
        </div>

        <div class="col-md-4">
            @if (count($trending))
                <div class="card">
                    <div class="card-header">
                        Trending Threads
                    </div>

                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($trending as $thread)
                                <li class="list-group-item"><a href="{{ $thread->path }}">{{ $thread->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

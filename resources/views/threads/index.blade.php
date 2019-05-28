@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @forelse ($threads as $thread)
                <div class="card" style="margin-bottom:1rem;">
                    <div class="card-header">
                        <div class="level">
                            <div class="flex">
                                <a href="{{ $thread->path() }}">
                                    @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                        <strong>
                                            {{ $thread->title }}
                                        </strong>
                                    @else
                                        {{ $thread->title }}
                                    @endif
                                </a>
                            </div>

                            <a href="{{ $thread->path() }}">
                                {{ $thread->replies_count }} {{ str_plural('reply' ,$thread->replies_count) }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <p>{{ $thread->body }}</p>
                    </div>
                </div>
            @empty
                <div class="card" style="margin-bottom:1rem;">
                    <div class="card-body">
                        <p>There are no relevant results at this time</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

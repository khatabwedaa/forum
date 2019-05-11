@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($threads as $thread)
                <div class="card" style="margin-bottom:1rem;">
                    <div class="card-header">
                        <div class="level">
                            <div class="flex">
                                <a href="{{ $thread->path() }}">
                                    {{ $thread->title }}
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
            @endforeach
        </div>
    </div>
</div>
@endsection

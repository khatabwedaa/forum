<div id="reply-{{ $reply->id }}" class="card" style="margin-bottom:1rem;">
    <div class="card-header">
      <div class="level">
            <div class="flex">
                <a href="{{ route('profile' , $reply->owner) }}">
                    {{ $reply->owner->name }}
                </a> said {{ $reply->created_at->diffForHumans() }}
            </div>

            <div>
                <form action="/replies/{{ $reply->id }}/favorites" method="post">
                    @csrf
                    
                    @auth
                        <button type="submit" class="btn btn-sm btn-primary" {{ $reply->isFavorite() ? 'disabled' : '' }}>
                            {{ $reply->favorites_count }} {{ str_plural('Favorite' , $reply->favorites_count) }}
                        </button>
                    @endauth
                </form>
            </div>
      </div>
    </div>

    <div class="card-body">
        <p>{{ $reply->body }}</p>
    </div>

    @can('update', $reply)
        <div class="card-header">
            <form action="/replies/{{ $reply->id }}" method="post">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        </div>
    @endcan
</div>
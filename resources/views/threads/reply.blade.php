<div class="card" style="margin-bottom:1rem;">
    <div class="card-header">
      <div class="level">
            <div class="flex">
                <a href="#">
                    {{ $reply->owner->name }}
                </a> said {{ $reply->created_at->diffForHumans() }}
            </div>

            <div>
                <form action="/replies/{{ $reply->id }}/favorites" method="post">
                    @csrf

                    <button type="submit" class="btn btn-sm btn-primary" {{ $reply->isFavorite() ? 'disabled' : '' }}>
                        {{ $reply->favorites()->count() }} {{ str_plural('Favorite' , $reply->favorites()->count()) }}
                    </button>
                </form>
            </div>
      </div>
    </div>

    <div class="card-body">
        <p>{{ $reply->body }}</p>
    </div>
</div>
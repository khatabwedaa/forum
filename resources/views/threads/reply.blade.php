<div class="card" style="margin-top:1rem;margin-bottom:1rem;">
    <div class="card-header">
        <a href="#">
            {{ $reply->owner->name }}
        </a> said {{ $reply->created_at->diffForHumans() }}
    </div>

    <div class="card-body">
        <p>{{ $reply->body }}</p>
    </div>
</div>
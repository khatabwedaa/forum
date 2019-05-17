<reply-component :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card" style="margin-bottom:1rem;">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <a href="{{ route('profile' , $reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a> said {{ $reply->created_at->diffForHumans() }}
                </div>

                <div>
                    @auth
                        <favorite :reply="{{ $reply }}"></favorite>
                    @endauth
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea name="body" class="form-control" v-model="body"></textarea>
                </div>

                <button type="submit" class="btn btn-sm btn-primary" @click="update">Update</button>
                <button type="submit" class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>

        @can('update', $reply)
            <div class="card-header level">
                <button class="btn btn-sm btn-secondary mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-sm btn-danger" @click="destroy">Delete</button>
            </div>
        @endcan
    </div>
</reply-component>
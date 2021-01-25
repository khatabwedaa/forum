<div class="card" style="margin-bottom:1rem;" v-if="editing">
    <div class="card-header">
        <input class="form-control" type="text" name="title" v-model="form.title">
    </div>
    
    <div class="card-body">
        <textarea class="form-control" name="body" v-model="form.body" rows="5"></textarea>
    </div>

    <div class="card-header">
        <div class="level">
            <div>
                <button @click="update" type="submit" class="btn btn-sm btn-primary">Update</button>
                <button class="btn btn-sm btn-link" @click="cancel">Cancel</button>
            </div>
    
            @can('update', $thread)
                <form action="{{ $thread->path() }}" method="post" class="ml-a">
                    @csrf
                    @method('DELETE')
    
                    <button class="btn btn-sm" style="color:#ce2910"><i class="fas fa-trash"></i></button>
                </form>
            @endcan
        </div>
    </div>
</div>


<div class="card" style="margin-bottom:1rem;" v-if="!editing">
    <div class="card-header">
        <div class="level">
            <img src="{{ $thread->creator->avatar_path }}" width="25" height="25" class="mr-1">

            <span class="flex">
                <a href="{{ route('profile' , $thread->creator) }}">{{ $thread->creator->name }}</a> Posted: 
                <span v-text="title"></span>
            </span>
        </div>
    </div>
    
    <div class="card-body">
        <p v-text="body"></p>
    </div>

    <div class="card-header" v-if="authorize('owns', thread)">
        <button @click="editing = true" class="btn btn-sm btn-primary">Edit</button>
    </div>
</div>
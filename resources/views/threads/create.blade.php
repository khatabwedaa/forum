@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a New Thread</div>
                
                <div class="card-body">
                    <form action="{{ route('threads.store') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="title">Titel</label>
                            <input type="text" name="title" class="form-control" placeholder="title">
                        </div>
                        
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea type="text" name="body" class="form-control" placeholder="body" rows="8"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Publish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

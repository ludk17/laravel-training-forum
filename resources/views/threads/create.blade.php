@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-me-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a New Thread</div>
                    <div class="panel-body">
                        <form action="/threads" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" name="title" id="title">
                            </div>
                            <div class="form-group">
                                <label for="title">Body:</label>
                                <textarea class="form-control" name="body" id="body" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
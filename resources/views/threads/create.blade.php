@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a New Thread</div>

                <div class="panel-body">
                    <form action="/threads" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title"> Title </label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Thread Title">
                        </div> 

                        <div class="form-group">
                            <label for="title"> Body </label>
                            <textarea name="body" class="form-control" rows="8" id="body"> </textarea>
                        </div> 
                        <button class="btn btn-primary" type="submit">Publish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

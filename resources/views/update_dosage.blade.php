

@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-sm-3 col-xs-12">
                            <h4 class="title">Update Dosage Form</h4>
                        </div>
                    </div>
                </div>
                <div class="panel-body">

                    <form action="/dosages_update/{{ $dosage->id }}" method="POST" class="form-horizontal">
                        @csrf
                        @method('PUT')

                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" value="{{$dosage->name}}" class="form-control" id="name" name="name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="short_name" class="col-sm-2 control-label">Short Name</label>
                            <div class="col-sm-10">
                                <input type="text" id="short_name" value="{{$dosage->short_name}}" class="form-control" name="short_name"><br>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{route('dosage-list')}}" class="btn btn-warning">Go Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection




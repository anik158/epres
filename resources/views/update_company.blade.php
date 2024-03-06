

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

                    <form action="/companies_update/{{ $company->id }}" method="POST" class="form-horizontal">
                        @csrf
                        @method('PUT')


                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" value="{{$company->name}}" class="form-control" id="name" name="name">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{route('company-list')}}" class="btn btn-warning">Go Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection






@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-sm-3 col-xs-12">
                            <h4 class="title">Add Drug</h4>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <form action="/update/{{$drug->id}}" method="POST" class="form-horizontal">
                        @csrf
                        @method('PUT')
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                        <div class="form-group">
                                <input type="text" value="{{$drug->name}}" class="form-control" id="name" name="name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="strength" class="col-sm-2 control-label">Strength</label><br>
                            <div class="col-sm-10">
                                <input type="text" value="{{$drug->strength}}" id="strength" name="strength"><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dosage_form" class="col-sm-2 control-label">Dosage Form</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="dosage_form">
                                    <option value="{{$drug->dosage_form}}" selected>{{$drug->dosage_form}}</option>
                                    @foreach($dosages as $dosage)
                                        <option value="{{ $dosage->name }}">{{ $dosage->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="generic" class="col-sm-2 control-label">Generic</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="generic">
                                    <option value="{{$drug->generic}}" selected>{{$drug->generic}}</option>
                                    @foreach($generics as $generic)
                                        <option value="{{ $generic->name }}">{{ $generic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Company</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="company">
                                    <option value="{{$drug->company}}" selected>{{$drug->company}}</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->name }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="applicable_for" class="col-sm-2 control-label">Applicable For</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="applicable_for">
                                    <option value="{{$drug->applicable_for}}" selected>{{$drug->applicable_for}}</option>
                                    @foreach($applicables as $applicable)
                                        <option value="{{ $applicable->category }}">{{ $applicable->category }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{route('drug-list')}}" class="btn btn-warning">Go Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection




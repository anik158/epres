

@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-sm-3 col-xs-12">
                            <h4 class="title">Add Generic</h4>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <form action="/generics" method="POST" class="form-horizontal">
                        @csrf
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="composition" class="col-sm-2 control-label">Composition</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="composition" class="form-control" name="composition"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="indication" class="col-sm-2 control-label">Indication</label>
                            <div class="col-sm-10">
                                <textarea type="text" id="indication" class="form-control" name="indication"></textarea><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="applicable_for" class="col-sm-2 control-label">Applicable For</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="applicable_for">
                                    <option selected>Open this select menu</option>
                                    @foreach($applicable as $ap)
                                        <option value="{{ $ap->category }}">{{ $ap->category }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{route('generic-list')}}" class="btn btn-warning">Go Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



